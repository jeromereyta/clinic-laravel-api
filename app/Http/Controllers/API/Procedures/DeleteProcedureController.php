<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Procedures;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class DeleteProcedureController extends AbstractAPIController
{
    private ProcedureRepositoryInterface $procedureRepository;

    public function __construct(
        ProcedureRepositoryInterface $procedureRepository
    ) {
        $this->procedureRepository = $procedureRepository;
    }

    public function __invoke(int $procedureId): JsonResource
    {
        try {
            $procedure = $this->procedureRepository->findById($procedureId);

            $this->procedureRepository->deleteProcedure($procedure);

            return $this->respondNoContent();
        } catch (NoResultException | NonUniqueResultException $ormException) {
            return $this->respondError('Procedure not found.', Response::HTTP_NOT_FOUND);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
