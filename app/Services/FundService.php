<?php

namespace App\Services;

use App\Events\FundCreated;
use App\Models\Fund;
use App\Models\FundAlias;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FundService
{
    private Fund $model;

    public function __construct()
    {
        $this->model = new Fund();
    }

    public function get(Request $request): Collection
    {
        return $this->model
            ->when($request->query('name'), function ($query, $name) {
                $query->where('name', 'ilike', '%' . $name . '%');
            })
            ->when($request->query('year'), function ($query, $year) {
                $query->where('start_year', $year);
            })
            ->when($request->query('fund_manager'), function ($query, $fundManager) {
                $query->where('fund_manager_id', $fundManager);
            })
            ->get();
    }

    public function find(string $id): Fund
    {
        return $this->model->find($id);
    }

    public function create(array $data): Fund
    {
        $fund = $this->model->create($data);

        if ($data['aliases']) {
            $aliases = [];
            foreach ($data['aliases'] as $alias) {
                $aliases[] = [
                    'name' => $alias,
                ];
            }
            $fund->aliases()->createMany($aliases);
        }

        return $fund;
    }

    public function update(string $id, array $data): Fund
    {
        $response = $this->model->find($id);

        if (!$response) {
            return $response;
        }

        $response->update($data);

        if ($data['aliases']) {
            foreach ($data['aliases'] as $alias) {
                if (!isset($alias['id'])) {
                    $response->aliases()->create($alias);
                    continue;
                }

                $existingAlias = FundAlias::find($alias['id']);

                if ($existingAlias) {
                    $existingAlias->update($alias);
                }
            }
        }

        if ($data['fund_manager'])

        return $response;
    }

    public function delete(string $id): bool
    {
        $response = $this->model->find($id);

        if (!$response) {
            return false;
        }

        $response->delete();

        return true;
    }

    public function hasDuplicate(string $name, string $managerName): ?Fund
    {
        $fundsWithSameManager = $this->model->whereRelation('fundManager', 'name', $managerName)->get();

        $hasDuplicate = false;

        foreach ($fundsWithSameManager as $fund) {
            $aliases = $fund->aliases;

            $hasDuplicate = $aliases->contains('name', $name);
        }

        if ($fund->name === $name) {
            $hasDuplicate = true;
        }

        return $hasDuplicate;
    }

    public function findDuplicates(): Collection
    {
        $funds = $this->model->all();

        $duplicates = [];

        foreach ($funds as $fund) {
            $duplicate = $this->hasDuplicate($fund->name, $fund->fundManager->name);

            if ($duplicate) {
                $duplicates[] = $fund;
                continue;
            }

            $aliases = $fund->aliases;

            foreach ($aliases as $alias) {
                $duplicate = $this->hasDuplicate($alias->name, $fund->fundManager->name);

                if ($duplicate) {
                    $duplicates[] = $fund;
                    break;
                }
            }
        }

        return collect($duplicates)->unique();
    }
}
