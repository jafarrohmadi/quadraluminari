<?php

namespace App\Models\Traits\Relationship;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Trait UserRelationship
 * @package App\Models\Traits\Relationship
 */
trait UserRelationship
{

    /**
     * @return BelongsToMany
     */
    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }
}

