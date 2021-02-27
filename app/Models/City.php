<?php

namespace App\Models;

use App\Models\Traits\Relationship\CityRelationship;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use CityRelationship;

    protected $table = 'indonesia_cities';

    protected $fillable = ['province_id', 'name', 'meta'];
}
