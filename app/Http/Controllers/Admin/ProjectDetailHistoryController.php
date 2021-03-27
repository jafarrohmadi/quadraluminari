<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Address\Service\CityService;
use App\Http\Controllers\Controller;
use App\Repositories\CityRepository;
use App\Repositories\ProjectDetailHistoryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ProjectDetailHistoryController extends Controller
{
    protected $projectDetailHistoryRepository;

    /**
     * CityController constructor.
     * @param CityRepository $cityService
     */
    public function __construct(ProjectDetailHistoryRepository $projectDetailHistoryRepository)
    {
        $this->projectDetailHistoryRepository = $projectDetailHistoryRepository;
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function index($id)
    {
        $data = $this->projectDetailHistoryRepository->findAllData(['project_detail_id' => $id]);
        return view('admin.project-detail-history.index', compact('data'));
    }

}
