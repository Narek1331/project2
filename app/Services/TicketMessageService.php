<?php

namespace App\Services;

use App\Repositories\TicketMessageRepository;

class TicketMessageService
{
    protected $repository;

    public function __construct(TicketMessageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createMessage(array $data)
    {
        return $this->repository->create($data);
    }

    public function getMessagesForTicket(int $ticketId)
    {
        return $this->repository->getByTicketId($ticketId);
    }
}
