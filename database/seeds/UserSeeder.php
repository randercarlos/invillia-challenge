<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::create([
           'username' => 'teste',
           'email' => 'teste@teste.com',
           'password' => Hash::make('teste')
       ]);

       User::create([
           'username' => 'user',
           'email' => 'user@user.com',
           'password' => Hash::make('user')
       ]);
    }
}
