<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferralController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();

        return view('admin.referral.index',[
            'referrals' => $user->referrals,
            'referralsCount' => $user->referrals->count(),
            'referralEarnings' => $user->referrals->count() * 100,
        ]);
    }

}
