<?php
use Illuminate\Database\Seeder;


class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    User::create(array(
        'name'     => 'sanga',
        'email'    => 'oni@1234',
        'password' => Hash::make('sanga'),
    ));
}
}
