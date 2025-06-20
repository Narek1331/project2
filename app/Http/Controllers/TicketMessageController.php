<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketMessageRequest;
use App\Services\TicketMessageService;
use Illuminate\Http\RedirectResponse;

class TicketMessageController extends Controller
{
    protected $service;

    public function __construct(TicketMessageService $service)
    {
        $this->service = $service;
    }

    public function store(TicketMessageRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $this->service->createMessage($data);

        return redirect()->back()->with('success', 'Сообщение отправлено.');
    }
}
