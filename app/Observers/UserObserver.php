<?php

namespace App\Observers;

use App\Models\User;
use App\Services\UserBalanceService;
use Illuminate\Support\Str;

class UserObserver
{
    protected UserBalanceService $balanceService;

    public function __construct(UserBalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->token = Str::random(40);
        $user->referral_token = Str::random(20);
        $user->saveQuietly();

        if ($user->referred_by) {
            $referrer = User::where('referral_token', $user->referred_by)->first();

            if ($referrer) {
                $this->balanceService->referredUser($referrer, $user);
            }
        }
    }
}
