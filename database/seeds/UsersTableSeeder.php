<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
     'name'=> 'ganesh',
     'email' => 'ganeshkhadka46@gmail.com',
     'password' => bcrypt('admin123'),
     'admin' => 1
      ]);
    }
}
