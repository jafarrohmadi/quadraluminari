<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ActiveClientRepository;
use Illuminate\Http\Request;

class GetActiveClientController extends Controller
{
    protected $activeClient;

    /**
     * GetActiveClientController constructor.
     * @param ActiveClientRepository $activeClient
     */
    public function __construct(ActiveClientRepository $activeClient)
    {
        $this->activeClient = $activeClient;
    }

    public function index(Request $request)
    {
        if ($request->has('q')) {
            return response()->json($this->activeClient->findAllData([['name', 'like', '%' . $request->q . '%']]));
        }
    }
}
