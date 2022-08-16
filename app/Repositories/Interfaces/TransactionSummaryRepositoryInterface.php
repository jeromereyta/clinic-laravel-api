<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientVisit;
use App\Database\Entities\TransactionSummary;
use App\Services\PatientService\Resources\CreatePatientResource;
use App\Services\TransactionSummary\Resources\CreateTransactionSummary;
use Carbon\Carbon;

interface TransactionSummaryRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): array;

    public function findAllByDate(Carbon $fromDate, Carbon $toDate): array;

    public function create(CreateTransactionSummary $resource): TransactionSummary;

    public function findByTransactionSummary(int $id): ?TransactionSummary;

    /**
     * @return mixed
     */
    public function findByPatient(Patient $patient): array;

    public function findByPatientVisit(PatientVisit $patientVisit): ?TransactionSummary;

    public function findLatestTransactionCountToday(): ?string;

    public function deleteTransactionSummary(TransactionSummary $transactionSummary): void;
}
