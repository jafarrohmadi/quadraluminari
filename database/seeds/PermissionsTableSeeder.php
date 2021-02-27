<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'active_client_view',
                'name' => 'Active Client View'
            ],
            [
                'id'    => '2',
                'title' => 'active_client_create',
                'name' => 'Active Client Create'
            ],
            [
                'id'    => '3',
                'title' => 'active_client_edit',
                'name' => 'Active Client Edit'
            ],
            [
                'id'    => '4',
                'title' => 'active_client_delete',
                'name' => 'Active Client Delete'
            ],
            [
                'id'    => '5',
                'title' =>'active_opportunity_view',
                'name' => 'Active Opportunity View',
            ],
            [
                'id'    => '6',
                'title' =>'active_opportunity_create',
                'name' => 'Active Opportunity Create',
            ],
            [
                'id'    => '7',
                'title' =>'active_opportunity_edit',
                'name' => 'Active Opportunity Edit',
            ],
            [
                'id'    => '8',
                'title' =>'active_opportunity_delete',
                'name' => 'Active Opportunity Delete',
            ],
            [
                'id'    => '9',
                'title' =>'dashboard',
                'name' => 'Dashboard',
            ],
            [
                'id'    => '10',
                'title' => 'user_management_view',
                'name' => 'User Management View',
            ],
            [
                'id'    => '11',
                'title' => 'user_management_create',
                'name' => 'User Management View',
            ],
            [
                'id'    => '12',
                'title' => 'user_management_edit',
                'name' => 'User Management Edit',
            ],
            [
                'id'    => '13',
                'title' => 'user_management_delete',
                'name' => 'User Management Delete',
            ],

        ];

        Permission::insert($permissions);
    }
}
