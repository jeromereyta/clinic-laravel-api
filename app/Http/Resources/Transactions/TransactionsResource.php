<?php

declare(strict_types=1);

namespace App\Http\Resources\Transactions;

use App\Http\Resources\Resource;

final class TransactionsResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $transaction) {
            $results[] = new TransactionResource($transaction);
        }

        return $results;
    }
}
