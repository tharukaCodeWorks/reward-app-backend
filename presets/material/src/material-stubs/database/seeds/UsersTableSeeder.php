<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'admin')->first();

        $employee = new User();
        $employee->name = 'Tharuka Lakshan';
        $employee->email = 'tharukawapnet@gmail.com';
        $employee->password = bcrypt('12345678');
        $employee->save();
        $employee->roles()->attach($role_admin);
    }
}
