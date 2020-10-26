<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    //run seeder method
    public function run()
    {
        User::create([
            'id' => 'admin',
            'password'=>'123',
        ]);
        
        User::create([
            'id' => 'user',
            'password'=>'123',
        ]);
   }
}
