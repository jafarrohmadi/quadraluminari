<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePemeriksaanRequest;
use App\Http\Requests\UpdatePemeriksaanRequest;
use App\Http\Resources\Admin\PemeriksaanResource;
use App\Pemeriksaan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PemeriksaanApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pemeriksaan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PemeriksaanResource(Pemeriksaan::all());
    }

    public function store(StorePemeriksaanRequest $request)
    {
        $pemeriksaan = Pemeriksaan::create($request->all());

        return (new PemeriksaanResource($pemeriksaan))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Pemeriksaan $pemeriksaan)
    {
        abort_if(Gate::denies('pemeriksaan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PemeriksaanResource($pemeriksaan);
    }

    public function update(UpdatePemeriksaanRequest $request, Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->update($request->all());

        return (new PemeriksaanResource($pemeriksaan))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Pemeriksaan $pemeriksaan)
    {
        abort_if(Gate::denies('pemeriksaan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pemeriksaan->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
