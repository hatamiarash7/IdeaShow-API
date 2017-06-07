<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        DB::table('users')->delete();
        User::create(array(
            'name' => 'Arash Hatami',
            'phone' => '09182180519',
            'email' => 'hatamiarash7@gmail.com',
            'password' => Hash::make('3920512197'),
        ));
    }
}
