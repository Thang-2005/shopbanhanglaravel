<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_information', function (Blueprint $table) {
            $table->id('info_id');
            $table->string('info_address')->nullable();
            $table->string('info_phone')->nullable();
            $table->string('info_email')->nullable();
            $table->text('info_contact')->nullable();
            $table->text('info_map')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_information');
    }
};
