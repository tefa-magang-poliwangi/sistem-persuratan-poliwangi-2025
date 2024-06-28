<?php

namespace Modules\Kinerja\Http\Controllers;

use Modules\Kinerja\Http\Requests\IkuUpdateRequest;
use Modules\Kinerja\Http\Requests\IkuStoreRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Kinerja\Entities\Iku;

class IkusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $ikus = Iku::where('sasaran', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $ikus = Iku::latest()->paginate($perPage);
        }

        return view('kinerja::iku.index', compact('ikus'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('kinerja::iku.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validated();

        $iku = Iku::create($validated);

        return redirect()
            ->route('ikus.edit', $iku)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request, Iku $iku): View
    {
        //return view('app.ikus.show', compact('iku'));
        return view('kinerja::iku.show',  compact('iku'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request, Iku $iku): View
    {
        // $this->authorize('update', $iku);

        return view('kinerja::iku.edit', compact('iku'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(
        IkuUpdateRequest $request,
        Iku $iku
    ): RedirectResponse {
        $this->authorize('update', $iku);

        $validated = $request->validated();

        $iku->update($validated);

        return redirect()
            ->route('kinerja::ikus.edit', $iku)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, Iku $iku): RedirectResponse
    {
        //$iku->delete();
        return redirect()
            ->route('ikus.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
