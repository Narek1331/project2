<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserBalanceService;

class BalanceController extends Controller
{
    protected $userBalanceService;

    public function __construct(UserBalanceService $userBalanceService)
    {
        $this->userBalanceService = $userBalanceService;
    }

    public function index(Request $request)
    {
        return view('admin.balance.index');
    }

    public function topUp(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:1'
        ]);

        $this->userBalanceService->topUp($request->price);

        return back()->with('success', 'Баланс успешно пополнен.');
    }
}
