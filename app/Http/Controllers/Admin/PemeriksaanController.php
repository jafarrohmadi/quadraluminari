<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPemeriksaanRequest;
use App\Http\Requests\StorePemeriksaanRequest;
use App\Http\Requests\UpdatePemeriksaanRequest;
use App\Pemeriksaan;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PemeriksaanController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('pemeriksaan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pemeriksaans = Pemeriksaan::all();

        return view('admin.pemeriksaans.index', compact('pemeriksaans'));
    }

    public function create()
    {
        abort_if(Gate::denies('pemeriksaan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pemeriksaans.create');
    }

    public function store(StorePemeriksaanRequest $request)
    {
        $pemeriksaan = Pemeriksaan::create($request->all());

        return redirect()->route('admin.pemeriksaans.index');
    }

    public function edit(Pemeriksaan $pemeriksaan)
    {
        abort_if(Gate::denies('pemeriksaan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pemeriksaans.edit', compact('pemeriksaan'));
    }

    public function update(UpdatePemeriksaanRequest $request, Pemeriksaan $pemeriksaan)
    {
        $pemeriksaan->update($request->all());

        return redirect()->route('admin.pemeriksaans.index');
    }

    public function show(Pemeriksaan $pemeriksaan)
    {
        abort_if(Gate::denies('pemeriksaan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pemeriksaans.show', compact('pemeriksaan'));
    }

    public function destroy(Pemeriksaan $pemeriksaan)
    {
        abort_if(Gate::denies('pemeriksaan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pemeriksaan->delete();

        return back();
    }

    public function massDestroy(MassDestroyPemeriksaanRequest $request)
    {
        Pemeriksaan::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
