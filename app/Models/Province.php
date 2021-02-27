<?php

namespace App\Models;

use App\Models\Traits\Relationship\ProvinceRelationship;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use ProvinceRelationship;

    protected $table = 'indonesia_provinces';
    protected $fillable = ['name', 'meta'];
}
