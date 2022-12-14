<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\FloSettings;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $settings = FloSettings::create([
            'machine' => 'Flo_1',
            'du_no' => 'DU_1',
            'scan_url' => 'https://pos.snapscan.io/merchant/api/v1/payments/',
            'flo_url' => 'http://localhost/api/v1/dispenser/x/pour/y',
            'unit_price' => '500',
            'snap_code' => 'G0qvNaZu',
            'snap_api_key' => 'e8a86435-f60e-42a8-8499-ee9b7128db98',
            'snap_webhook_key' => 'd620cdad-81e3-4c26-858e-894a0213cf29',
            'ngrok_api_token'=>'2Hbyy9drSRpdWUBK3ttkGJDkMWD_6RBbWocRKvWvuEay8syYC',
            'flo_active' => 0
        ]);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@fastflo.co.za',
            'password' => Hash::make('test1234'),
        ]);

    }
}
