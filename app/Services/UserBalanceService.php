<?php

namespace App\Services;
use App\Models\{
    UserBalanceTransaction,
    User
};

class UserBalanceService
{
    public function topUp($price)
    {
        $user = auth()->user();

        $user->update([
            'balance' => $user->balance + $price
        ]);

        $user->balanceTransactions()->create([
            'price' => $price,
            'description' => 'Пополнение баланса',
            'type' => 'increment',
            'status' => true
        ]);


    }

    public function decreaseByUserId($user_id,$price)
    {
        $user = User::find($user_id);

        $user->update([
            'balance' => $user->balance - $price
        ]);

        $user->balanceTransactions()->create([
            'price' => $price,
            'description' => '',
            'type' => 'decrement',
            'status' => true
        ]);


    }

    public function referredUser(User $user, User $referredUser)
    {
        $user->update([
            'balance' => $user->balance + 100
        ]);

        $user->balanceTransactions()->create([
            'price' => 100,
            'description' => 'Бонус за регистрацию пользователя: ' . $referredUser->email,
            'type' => 'increment',
            'status' => true
        ]);
    }

}
