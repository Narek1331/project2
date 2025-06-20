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

    public function getAllByUser()
    {
        return $this->ticketRepo->getAllByUser(auth()->user()->id);
    }

    public function getById(int $id)
    {
        return $this->ticketRepo->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['user_id'] = auth()->user()->id;
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
