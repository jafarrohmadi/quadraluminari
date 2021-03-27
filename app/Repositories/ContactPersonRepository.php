<?php

namespace App\Repositories;

use App\Models\ContactPerson;

/**
 * Class ContactPersonRepository
 * @package App\Repositories
 */
class ContactPersonRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return ContactPerson::class;
    }
}
