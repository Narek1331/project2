<?php

namespace App\Repositories;

use App\Models\TicketMessage;

class TicketMessageRepository
{
    public function create(array $data): TicketMessage
    {
        return TicketMessage::create($data);
    }

    public function getByTicketId(int $ticketId)
    {
        return TicketMessage::where('ticket_id', $ticketId)
            ->with('ticket')
            ->latest()
            ->get();
    }
}
