<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id()->unique()->comment('id');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->comment('外部キー');
            $table->string('name')->comment('お客様名');
            $table->string('kana')->comment('カナ');
            $table->string('postcode')->comment('郵便番号');
            $table->string('address')->comment('お客様アドレス');
            $table->string('tel')->unique()->comment('お客様電話番号');
            $table->string('remarks')->nullable()->comment('備考欄');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
