<?php

namespace App\Events\Transaction;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionProcessedWithError
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public $transactionId, public $errorMessage)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('transaction-status');
    }

    public function broadcastWith(): array
    {
        return [
            'transactionId' => $this->transactionId,
            'status'        => 'error',
            'error'         => $this->errorMessage,
        ];
    }
}
