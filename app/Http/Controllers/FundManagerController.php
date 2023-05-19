<?php

namespace App\Http\Controllers;

use App\Models\FundManager;
use Illuminate\Http\Request;

class FundManagerController extends Controller
{
    public function index()
    {
        return FundManager::all();
    }

    public function create()
    {
        return view('fund_managers.create');
    }

    public function store()
    {
        FundManager::create([
            'name' => request('name'),
        ]);

        return redirect()->route('fund_managers.index');
    }
}
