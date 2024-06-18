<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropUsersTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('users');
    }

    public function down()
    {
        // Jika diperlukan, Anda bisa menambahkan kode untuk membuat tabel lagi di sini
    }
}
