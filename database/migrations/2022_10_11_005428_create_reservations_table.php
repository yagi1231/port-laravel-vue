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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onUpdate('cascade')->comment('外部キー');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->comment('外部キー');
            $table->string('name')->comment('お客様名');
            $table->string('kana')->comment('カナ');
            $table->string('postcode')->comment('郵便番号');
            $table->string('address')->comment('住所');
            $table->string('after_address')->comment('番地・建物名');
            $table->string('tel')->comment('お客様電話番号');
            $table->integer('sumprice')->comment('合計金額');
            $table->string('delivery')->nullable()->comment('配達員名');
            $table->string('datetime')->comment('日付');
            $table->string('time')->comment('配達時間');
            $table->string('status')->default('準備中')->comment('配達状況');
            $table->string('remarks')->nullable()->comment('備考欄');
            $table->unsignedTinyInteger('role_id')->nullable()->comment('管理者権限');
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
        Schema::dropIfExists('reservations');
    }
};
