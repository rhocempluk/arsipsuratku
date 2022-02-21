<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         $user = [
             [
                'name'=>'rosy',
                'email'=>'rosmiyatul@gmail.com',
                'role'=>'Super Admin',
                'password'=> bcrypt('347597'),
             ],
             [
                'name'=>'taza',
                'email'=>'user@gmail.com',
                'role'=>'Admin',
                'password'=> bcrypt('123456'),
             ],
         ];
   
         foreach ($user as $key => $value) {
             User::create($value);
         }
     }
}
