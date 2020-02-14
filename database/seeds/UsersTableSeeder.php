<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'  => 'Tester',
            'email' => 'tester@tester.com',
            'password' => Hash::make('123456789'),
        ];

        $user = (new User)->fill($data);
        $user->save();

    }
}
