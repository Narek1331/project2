<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    public function all()
    {
        return Ticket::all();
    }

    public function getAllByUser(int $userId)
    {
        return Ticket::where('user_id',$userId)->get();
    }

    public function find(int $id): ?Ticket
    {
        return Ticket::find($id);
    }

    public function findOrFail(int $id): ?Ticket
    {
        return Ticket::findOrFail($id);
    }

    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function update(int $id, array $data): ?Ticket
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->update($data);
        }
        return $ticket;
    }

    public function delete(int $id): bool
    {
        $ticket = Ticket::find($id);
        return $ticket ? $ticket->delete() : false;
    }
}
