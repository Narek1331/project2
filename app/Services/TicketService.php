<?php

namespace App\Services;

use App\Repositories\TicketRepository;

class TicketService
{
    protected TicketRepository $ticketRepo;

    public function __construct(TicketRepository $ticketRepo)
    {
        $this->ticketRepo = $ticketRepo;
    }

    public function getAll()
    {
        return $this->ticketRepo->all();
    }

    public function getById(int $id)
    {
        return $this->ticketRepo->find($id);
    }

    public function create(array $data)
    {
        return $this->ticketRepo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->ticketRepo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->ticketRepo->delete($id);
    }
}
