<?php

namespace App\Imports;

use App\Models\ActiveClient;
use App\Models\ContactPerson;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class ActiveClientImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {

        $activeClient =  ActiveClient::create([
            'name'                    => $row[2],
            'npwp'                    => $row[19],
            'phone_number'            => $row[9],
            'address_mailing_address' => $row[4],
            'status'                  => $row[12] == 'Active' ? 1 : 0,
        ]);

        return new ContactPerson([
            'active_client_id'            => $activeClient->id,
            'contact_person_name'         => $row[10],
            'contact_person_phone'        => $row[9],
            'contact_person_mobile_phone' => $row[8],
            'contact_person_mobile_email' => $row[6],
        ]);
    }
}
