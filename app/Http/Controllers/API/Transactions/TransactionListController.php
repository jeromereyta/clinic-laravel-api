<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Transactions;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Transactions\TransactionListRequest;
use App\Repositories\Interfaces\TransactionSummaryRepositoryInterface;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Transactions\TransactionsResource;

final class TransactionListController extends AbstractAPIController
{
    private IdentifierEncoderInterface $identifierEncoder;

    private TransactionSummaryRepositoryInterface $transactionSummaryRepository;

    public function __construct(
        TransactionSummaryRepositoryInterface $transactionSummaryRepository,
        IdentifierEncoderInterface $identifierEncoder
    ) {
        $this->identifierEncoder = $identifierEncoder;
        $this->transactionSummaryRepository = $transactionSummaryRepository;
    }

    public function __invoke(TransactionListRequest $request): JsonResource
    {
        if (empty($request->getFrom()) === true || empty($request->getTo()) === true) {
            $allTransactions = $this->transactionSummaryRepository->all();

            return new TransactionsResource($allTransactions, $this->identifierEncoder);
        }

        $startDate = new Carbon($request->getFrom());

        $endDate = new Carbon($request->getTo());

        $allTransactions = $this->transactionSummaryRepository->findAllByDate($startDate, $endDate);

        return new TransactionsResource($allTransactions);

    }
}
