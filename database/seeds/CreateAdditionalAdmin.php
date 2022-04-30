<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdditionalAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =  User::create([
            'name' => 'Amir Ishak',
            'email' => 'amirishak@rofood.co',
            'password' => Hash::make('500500'),
            'phone' => '+966509016572'
        ]);
            $user->assignRole('مشرف');
    }
}
