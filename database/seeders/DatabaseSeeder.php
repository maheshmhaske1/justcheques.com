<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ChequeCategories;
use App\Models\PersonalCheque;
use App\Models\LaserCheque;
use App\Models\ManualCheque;
use App\Models\Customer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name'=>'admin user',
            'firstname' => 'Admin',
            'lastname' => 'User',
            'telephone' => '9552344220',
            'company' => 'xyz',
            'suburb' => 'dfdvad',
            'buzzer_code' => 'dvdfvd',
            'email' => 'admin@gmail.com',
            'street_address'=>'pune',
            'email_verified_at' => Carbon::today(),
            'role' => 'admin',
            'city' => 'Pune',
            'postcode' => '411027',
            'state' => 'Maharashtra',
            'country' => 'India',
            'password' => Hash::make('admin'),
        ]);

        PersonalCheque::factory()->createMany([
            [
                'categoriesName' => 'Cheque On Top',
                'img' => 'premium-foil_01.jpg'
            ],
            [
                'categoriesName' => 'Cheque In Middle',
                'img' => 'middle-premium_Page_1.jpg'
            ],
            [
                'categoriesName' => 'Cheque On Bottom',
                'img' => 'premium-bottom-eng.jpg'
            ]

        ]);


        LaserCheque::factory()->createMany([
            [
                'categoriesName' => 'Cheque On Top',
                'img' => 'premium-foil_01.jpg'
            ],
            [
                'categoriesName' => 'Cheque In Middle',
                'img' => 'middle-premium_Page_1.jpg'
            ],
            [
                'categoriesName' => 'Cheque On Bottom',
                'img' => 'premium-bottom-eng.jpg'
            ]
        ]);

        ManualCheque::factory()->createMany([
            [
                'categoriesName' => 'High Security Manual Cheques',
                'img' => 'manual_eng.jpg'
            ],
            [
                'categoriesName' => '2 (carbon) Copy High Security Manual Cheques',
                'img' => 'manual_duplicate.jpg'
            ]
        ]);

        ChequeCategories::factory()->createMany([

            [
                'manual_cheque_id' => '1',
                'laser_cheque_id' => '0',
                'chequeName' => '1-Per Page',
                'price' => '48.00',
                'img' => '1-per-page-manual-cheque.jpg'
            ],
            [
                'manual_cheque_id' => '1',
                'laser_cheque_id' => '0',
                'chequeName' => '2-Per Page',
                'price' => '69.00',
                'img' => 'manual-cheques-two-per-page.png'
            ],
            [
                'manual_cheque_id' => '0',
                'laser_cheque_id' => '1',
                'chequeName' => 'Laser Cheques / Computer Cheques on top',
                'price' => '48.00',
                'img' => 'economical-top.jpg'
            ],
            [
                'manual_cheque_id' => '0',
                'laser_cheque_id' => '1',
                'chequeName' => 'Premium High Security Foil Hologram Laser Cheques / Computer Cheques on top',
                'price' => '69.00',
                'img' => 'premium-foil-eng.jpg'
            ],
            [
                'manual_cheque_id' => '0',
                'laser_cheque_id' => '3',
                'chequeName' => '2 Part Premium High Security Foil Hologram Cheque - 2 Copies',
                'price' => '222.00',
                'img' => 'premium-foil-2-part-english.jpg'
            ]

        ]);

        

        Customer::factory()->create([
            'firstname' => 'Pravin',
            'lastname' => 'Pimpale',
            'telephone' => '9552344220',
            'company' => 'qq',
            'suburb' => 'Pravin',
            'buzzer_code' => 'qq',
            'email' => 'admin@gmail.com',
            'user_id' => '1',
            'city' => 'Pune',
            'street_address' => 'Pune',
            'postcode' => '411027',
            'state' => 'Maharashtra',
            'country' => 'India'
        ]);
    }
}
