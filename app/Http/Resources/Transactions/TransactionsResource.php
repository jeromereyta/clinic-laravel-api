<?php

declare(strict_types=1);

namespace App\Http\Resources\Transactions;

use App\Http\Resources\Resource;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;

final class TransactionsResource extends Resource
{
    private IdentifierEncoderInterface $identifierEncoder;

    /**
     * @param mixed[] $transactions
     */
    public function __construct(array $transactions, IdentifierEncoderInterface $identifierEncoder)
    {
        $this->identifierEncoder = $identifierEncoder;
        parent::__construct($transactions);
    }

    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $transaction) {
            $results[] = new TransactionResource($transaction, $this->identifierEncoder);
        }

        return $results;
    }
}
