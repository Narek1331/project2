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
        $tickets = $this->ticketService->getAll();
        return view('admin.ticket.index', compact('tickets'));
    }

    public function create(Request $request)
    {
        return view('admin.ticket.create');
    }
    public function store(TicketRequest $request)
    {
        dd($request->all());
    }
}
