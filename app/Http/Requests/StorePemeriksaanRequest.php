<?php

namespace App\Http\Requests;

use App\Pemeriksaan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePemeriksaanRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('pemeriksaan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'subjektif' => [
                'required',
            ],
            'objektif'  => [
                'required',
            ],
            'penilaian' => [
                'required',
            ],
            'plan'      => [
                'required',
            ],
        ];
    }
}
