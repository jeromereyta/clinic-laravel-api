<?php

declare(strict_types=1);

namespace App\Http\Resources\Queue;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientProcedure;
use App\Database\Entities\Procedure;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class ProcedureQueuesResource extends Resource
{
    /**
     * @param mixed[] $queues
     */
    public function __construct(array $queues)
    {
        parent::__construct($queues);
    }
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $queue) {
            /** @var PatientProcedure $patientProcedure */
            $patientProcedure = $queue->getPatientProcedure();

            $procedure = $patientProcedure->getProcedure();

            $patientVisit = $patientProcedure->getPatientVisit();

            $patient = $patientVisit->getPatient();

            $results[$procedure->getName()][] = [
                'patient_name' => $patient->getName(),
                'patient_code' => $patient->getPatientCode(),
                'queue_number' => $queue->getQUeueNumber(),
                'status' => $queue->getStatus(),
            ];
        }

        return $results;
    }
}
