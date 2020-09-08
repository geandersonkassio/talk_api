<?php

use Illuminate\Database\Seeder;
use \App\User;
use \Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Maria',
            'email' => 'maria@dimensao.com.br',
            'password' => '1234',
            'admin' => true,
        ]);

        User::create([
            'name' => 'George',
            'email' => 'george@dimensao.com.br',
            'password' => '1234',
            'property' => 'Space Calhau 2 locado Vila Maranhão, São Luís - MA'
        ]);
    }
}
