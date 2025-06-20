<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Http\Requests\TicketRequest;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index(Request $request)
    {
        $tickets = $this->ticketService->getAllByUser();
        return view('admin.ticket.index', compact('tickets'));
    }

    public function show($id, Request $request)
    {
        $ticket = $this->ticketService->getById($id);
        return view('admin.ticket.show', compact('ticket'));
    }

    public function create(Request $request)
    {
        return view('admin.ticket.create');
    }
    public function store(TicketRequest $request)
    {
        $this->ticketService->create($request->validated());

        return redirect()->route('admin.ticket')
        ->with('success', 'Тикет успешно создан');

    }
}
