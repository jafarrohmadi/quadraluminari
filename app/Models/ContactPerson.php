<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    protected $fillable = [
        'active_client_id',
        'contact_person_name',
        'contact_person_grade',
        'contact_person_religion',
        'contact_person_photo',
        'contact_person_phone',
        'contact_person_mobile_phone',
        'contact_person_mobile_email',
    ];
}
