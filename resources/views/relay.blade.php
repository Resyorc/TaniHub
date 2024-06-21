<!DOCTYPE html>
<html>

<head>
    <title>Relay Control</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <button id="on">Turn On Relay</button>
    <button id="off">Turn Off Relay</button>

    <script>
        $('#on').click(function () {
            $.post('/api/relay/status/ON', function (data) {
                alert(data.relay_status);
            });
        });

        $('#off').click(function () {
            $.post('/api/relay/status/OFF', function (data) {
                alert(data.relay_status);
            });
        });
    </script>
</body>

</html>