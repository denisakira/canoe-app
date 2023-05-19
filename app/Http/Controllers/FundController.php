<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\FundManager;
use App\Services\FundService;
use Illuminate\Http\Request;

class FundController extends Controller
{

    public function __construct(
        private FundService $fundService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $funds = $this->fundService->get($request);
        
        return view('funds.index', [
            'funds' => $funds,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fundManagers = FundManager::all();

        return view('funds.create', [
            'fundManagers' => $fundManagers,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fund = $this->fundService->find($id);

        return view('funds.edit', [
            'fund' => $fund,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fund = $this->fundService->find($id);

        dd($fund);

        return view('funds.edit', [
            'fund' => $fund,
        ]);
    }

    public function get(Request $request)
    {
        $funds = $this->fundService->get($request);

        return response()->json($funds);
    }

    public function find(string $id)
    {
        $fund = $this->fundService->find($id);

        return response()->json($fund);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fund = $this->fundService->create($request->all());

        return response()->json($fund);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fund = $this->fundService->update($id, $request->all());

        return response()->json($fund);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fund = $this->fundService->delete($id);

        return response()->json($fund);
    }
}
