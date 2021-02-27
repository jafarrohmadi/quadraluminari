<?php

namespace App\Repositories;

use App\Models\Permission;

/**
 * Class PermissionRepository
 * @package App\Repositories
 */
class PermissionRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }
}
