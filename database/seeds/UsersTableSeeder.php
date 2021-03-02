<?php

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'username'       => 'admin',
                'email'          => 'admin@admin.com',
                'password'       => Hash::make('secret'),
                'remember_token' => null,
            ],
        ];

        $user = User::insert($users);

        $admin_permissions = Permission::all();
        User::findOrFail(1)->permission()->sync($admin_permissions->pluck('id'));
    }
}
