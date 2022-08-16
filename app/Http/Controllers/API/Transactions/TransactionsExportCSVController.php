<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Transactions;

use App\Exports\TransactionsExport;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Transactions\TransactionListRequest;
use App\Http\Resources\Transactions\TransactionResource;
use App\Repositories\Interfaces\TransactionSummaryRepositoryInterface;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Transactions\TransactionsResource;
use Maatwebsite\Excel\Facades\Excel;

final class TransactionsExportCSVController extends AbstractAPIController
{
    private TransactionSummaryRepositoryInterface $transactionSummaryRepository;

    public function __construct(
        TransactionSummaryRepositoryInterface $transactionSummaryRepository,
    ) {
        $this->transactionSummaryRepository = $transactionSummaryRepository;
    }

    public function __invoke(TransactionListRequest $request)
    {
        $transactions = null;
        $result = [];

        if (empty($request->getFrom()) === true || empty($request->getTo()) === true) {
            $transactions = $this->transactionSummaryRepository->all();
        } else {
            $startDate = new Carbon($request->getFrom());

            $endDate = new Carbon($request->getTo());

            $transactions = $this->transactionSummaryRepository->findAllByDate($startDate, $endDate);
        }

        foreach ($transactions as $transaction) {
            $resource = new TransactionResource($transaction);

            $result[] = json_decode($resource->toJson());
        }

        return Excel::download(new TransactionsExport($result), 'transactions.xlsx');

    }
}
