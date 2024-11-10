<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Arr;
use App\Database\CursorAdapter;
use App\Repositories\Interfaces\BankRepositoryInterface;

class BankMongodbRepository extends BaseMongodbRepository implements BankRepositoryInterface
{
    public function search(array $filter, ?int $limit = null): CursorAdapter
    {
        $pipeline = [];

        $pipeline[] = [
            '$project' => [
                'name'        => 1,
                'bic'         => 1,
                "description" => ['$concat' => ['$bic', ' - ', '$name']],
                'accounts'    => [
                    '$map' => [
                        'input' => '$accounts',
                        'as'    => 'v',
                        'in'    => '$$v.Account',
                    ],
                ],
            ],
        ];

        if (count($filter)) {
            $cond = Arr::mapWithKeys($filter, fn($value, $key) => [$key => ['$regex' => $value, '$options' => "i"]]);

            if (count($cond) > 1) {
                $cond = ['$or' => [$cond]];
            }

            $pipeline[] = ['$match' => $cond];
        }

        if ($limit) {
            $pipeline[] = ['$limit' => $limit];
        }

        $cursor = $this->collection
            ->aggregate($pipeline);

        return CursorAdapter::make($cursor);
    }

    public function byBIC($bic): ?array
    {
        return $this->first($this->search(['bic' => $bic]));
    }

    public function find(string $id): array|null|object
    {
        $result = $this->collection->findOne(['_id' => $id]);

        return optional($result)->bsonSerialize();
    }
}
