<?php

namespace App\Http\Controllers\SuperAdmin;

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
        $tickets = $this->ticketService->getAll();
        return view('superadmin.ticket.index', compact('tickets'));
    }

    public function show($id, Request $request)
    {
        $ticket = $this->ticketService->getById($id);
        return view('superadmin.ticket.show', compact('ticket'));
    }
}
