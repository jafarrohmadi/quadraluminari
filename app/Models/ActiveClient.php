<?php

namespace App\Models;

use App\Models\Traits\Attribute\ActiveClientAttribute;
use App\Models\Traits\Observer\Blameable;
use App\Models\Traits\Relationship\ActiveClientRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ActiveClient
 * @package App\Models
 */
class ActiveClient extends Model
{
    use SoftDeletes, ActiveClientAttribute, ActiveClientRelationship, Blameable;

    public $table = 'active_client';

    public const Status_Active = 1;
    public const Status_Non_Active = 0;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'npwp',
        'remark',
        'phone_number',
        'address_country',
        'address_province_id',
        'address_city_id',
        'address_mailing_address',
        'address_postal_code',
        'number_of_students',
        'number_of_lecturers',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
