#include <SoftwareSerial.h>
#include <LiquidCrystal_I2C.h>
#include <DHT.h>

// Inisiasi pin
#define RX_PIN 9
#define TX_PIN 8
#define DHT_PIN 2
#define SM_PIN A0
#define RELAY_PIN 3

// Inisiasi tipe DHT
#define DHT_TYPE DHT11

// Inisiasi library
SoftwareSerial wifi(RX_PIN, TX_PIN);
LiquidCrystal_I2C lcd(0x27, 16, 2);
DHT dht(DHT_PIN, DHT_TYPE);

// Membuat variabel untuk menyimpan data sensor
float humi, temp;
int soil;

// Data WiFi dan server
const char *ssid_wifi = "...";
const char *password_wifi = "98765432";
const char *server = "192.168.220.94"; // IP server Laravel
const char *host = "tanihub.test"; // IP server Laravel
const int port = 80;

void setup() {
  wifi.begin(9600);
  lcd.init();
  lcd.backlight();
  pinMode(RELAY_PIN, OUTPUT);
  dht.begin();
  lcd.setCursor(0, 0);
  lcd.print("   Initialize   ");
  lcd.setCursor(0, 1);
  lcd.print("      IoT       ");
  delay(5000);
  connectToWiFi();
  delay(5000);
}

void loop() {
  // Baca data sensor
  int valueTemperature = temperature();
  int valueHumidity = humidity();
  int valueSoilMoisture = soilMoisture();

  // Kirim data sensor ke server
  sendSensorData(valueTemperature, valueHumidity, valueSoilMoisture);

  // Dapatkan status relay dari server
  String status = getStatusFromServer();

  waterPlant(valueSoilMoisture);

  if (status == "on") {
      digitalWrite(RELAY_PIN, HIGH);
      delay(3000);
      digitalWrite(RELAY_PIN, LOW);

  } else if (status == "off") {
      digitalWrite(RELAY_PIN, LOW);
  }

  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("T: ");
  lcd.print(valueTemperature);
  lcd.print((char)223);
  lcd.print("C");
  lcd.setCursor(10, 0);
  lcd.print("H: ");
  lcd.print(valueHumidity);
  lcd.print("%");
  lcd.setCursor(0, 1);
  lcd.print("S: ");
  lcd.print(valueSoilMoisture);
  lcd.print("%");
  lcd.setCursor(10, 1);
  lcd.print("R: ");
  lcd.print(status);

  delay(4000); // Tunggu sebelum permintaan berikutnya
}

void connectToWiFi() {
  lcd.setCursor(0, 0);
  lcd.print("   Connecting   ");
  lcd.setCursor(0, 1);
  lcd.print("    to Wifi     ");
  sendATCommand("AT\r\n", "OK", 1000);
  sendATCommand("AT+RST\r\n", "OK", 5000);
  sendATCommand("AT+CWMODE=1\r\n", "OK", 5000);
  if (sendATCommand("AT+CWJAP=\"" + String(ssid_wifi) + "\",\"" + String(password_wifi) + "\"\r\n", "OK", 10000)) {
    lcd.setCursor(0, 0);
    lcd.print("   Connection   ");
    lcd.setCursor(0, 1);
    lcd.print("     Success    ");
  } else {
    lcd.setCursor(0, 0);
    lcd.print("   Connection   ");
    lcd.setCursor(0, 1);
    lcd.print("     Failed     ");
  }
}

int temperature() {
  temp = dht.readTemperature();
  return temp;
}

int humidity() {
  humi = dht.readHumidity();
  return humi;
}

int soilMoisture() {
  soil = analogRead(SM_PIN);
  return soil;
}

void waterPlant(int valueSoilMoisture) {
  if (valueSoilMoisture > 800) {
    digitalWrite(RELAY_PIN, HIGH); // Nyalakan relay
    delay(3000);
    digitalWrite(RELAY_PIN, LOW);
  } else {
    digitalWrite(RELAY_PIN, LOW); // Matikan relay
  }
}

void sendSensorData(int valueTemperature, int valueHumidity, int valueSoilMoisture) {
    // Format data sebagai application/x-www-form-urlencoded
    String postData = "temperature=" + String(valueTemperature) +
                      "&humidity=" + String(valueHumidity) +
                      "&soil_moisture=" + String(valueSoilMoisture);
                      "&device_id=1";

    // Buat permintaan POST
    String postRequest = "PUT /api/sensor/1 HTTP/1.1\r\n";
    postRequest += "Host: " + String(host) + "\r\n";
    postRequest += "Content-Type: application/x-www-form-urlencoded\r\n";
    postRequest += "Content-Length: " + String(postData.length()) + "\r\n\r\n";
    postRequest += postData;

    // Buka koneksi TCP
    if (sendATCommand("AT+CIPSTART=\"TCP\",\"" + String(server) + "\",80", "OK", 2000) ||
        sendATCommand("AT+CIPSTART=\"TCP\",\"" + String(server) + "\",80", "ALREADY CONNECT", 2000)) {
        
        delay(1000);

        // Kirim panjang data dengan AT+CIPSEND
        if (sendATCommand("AT+CIPSEND=" + String(postRequest.length()), ">", 2000)) {
            // Kirim permintaan HTTP POST
            if (sendATCommand(postRequest, "SEND OK", 2000)) {
                lcd.setCursor(0, 0);
                lcd.print("  Success send  ");
                lcd.setCursor(0, 1);
                lcd.print("      data      ");
            } else {
                lcd.setCursor(0, 0);
                lcd.print("  Failed send   ");
                lcd.setCursor(0, 1);
                lcd.print("      data      ");
            }
        }

        // Tutup koneksi TCP
        sendATCommand("AT+CIPCLOSE", "OK", 1000);
    }
}

String getStatusFromServer() {
    if (sendATCommand("AT+CIPSTART=\"TCP\",\"" + String(server) + "\",80", "OK", 2000) ||
        sendATCommand("AT+CIPSTART=\"TCP\",\"" + String(server) + "\",80", "ALREADY CONNECT", 2000)) {
        
        String getRequest = "GET /api/relay/status HTTP/1.1\r\nHost: " + String(host) + "\r\nConnection: close\r\n\r\n";
        if (sendATCommand("AT+CIPSEND=" + String(getRequest.length()), ">", 2000)) {
            sendATCommand(getRequest, "SEND OK", 2000);
            return readResponse();
        }
    }
    return ""; // Jika gagal melakukan koneksi atau mengirim request
}

bool sendATCommand(String command, String expectedResponse, unsigned long timeout) {
    wifi.println(command);
    unsigned long time = millis();
    while (millis() - time < timeout) {
        while (wifi.available()) {
            String response = wifi.readStringUntil('\n');
            if (response.indexOf(expectedResponse) != -1) {
                return true;
            }
        }
    }
    return false; // Return false jika expectedResponse tidak ditemukan dalam waktu yang ditentukan
}

String readResponse() {
    String response = "";
    unsigned long timeout = millis() + 5000; // Timeout untuk membaca respons
    boolean headerPassed = false;

    while (millis() < timeout) {
        while (wifi.available()) {
            char c = wifi.read();
            response += c;

            // Hanya baca body dari respons HTTP setelah header
            if (response.endsWith("\r\n\r\n")) {
                headerPassed = true;
                response = ""; // Reset response untuk membaca body
            }

            if (headerPassed) {
                // Proses body respons JSON
                int start = response.indexOf("{\"status\":\"");
                int end = response.indexOf("\"}", start);
                if (start >= 0 && end >= 0) {
                    return response.substring(start + 11, end); // Mengambil nilai status
                }
            }
        }
    }

    return ""; // Jika tidak berhasil mendapatkan status
}