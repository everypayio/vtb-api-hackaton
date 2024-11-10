<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\BankHelper;
use App\Repositories\Interfaces\BankRepositoryInterface;

class BankHelperService implements BankHelper
{

    protected BankRepositoryInterface $repository;

    public function __construct(BankRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function search(array $query, $limit = null): array
    {
        return $this->repository->search($query, $limit)->toArray();
    }

    public function byId(string $id)
    {
        return $this->repository->find($id);
    }

    public function byBIC(string $bic)
    {
        return $this->repository->byBIC($bic);
    }
}
