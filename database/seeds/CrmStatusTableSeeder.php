<?php

use App\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => '1',
                'name'       => 'Lead',
                'created_at' => '2019-12-02 14:25:22',
                'updated_at' => '2019-12-02 14:25:22',
            ],
            [
                'id'         => '2',
                'name'       => 'Customer',
                'created_at' => '2019-12-02 14:25:22',
                'updated_at' => '2019-12-02 14:25:22',
            ],
            [
                'id'         => '3',
                'name'       => 'Partner',
                'created_at' => '2019-12-02 14:25:22',
                'updated_at' => '2019-12-02 14:25:22',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}
