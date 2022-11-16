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

        /*'machine',
        'du_no',
        'scan_url',
        'unit_price',
        'snap_code',
        'snap_api_key',
        'snap_webhook_key',
        'flo_active'*/
    public function up()
    {
        Schema::create('flo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('machine');
            $table->string('du_no');
            $table->string('flo_url');
            $table->string('scan_url');
            $table->string('unit_price');
            $table->string('snap_code');
            $table->string('snap_api_key');
            $table->string('snap_webhook_key');
            $table->string('ngrok_api_token');
            $table->boolean('flo_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flo_settings');
    }
};
