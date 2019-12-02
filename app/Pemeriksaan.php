<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemeriksaan extends Model
{
    use SoftDeletes;

    public $table = 'pemeriksaans';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'plan',
        'objektif',
        'subjektif',
        'penilaian',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
