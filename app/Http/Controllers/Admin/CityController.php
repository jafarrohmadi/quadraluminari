<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Address\Service\CityService;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;

class CityController extends Controller
{
    protected $cityService;

    /**
     * CityController constructor.
     * @param CityRepository $cityService
     */
    public function __construct(CityRepository $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * @param $provinceId
     * @return mixed
     */
    public function getCityByProvinceId($provinceId)
    {
        return $this->cityService->findAllData(['province_id'=> $provinceId])->pluck('name', 'id');
    }
}
