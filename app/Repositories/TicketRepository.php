<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    public function getAllTickets()
    {
        return Ticket::all();
    }
}
