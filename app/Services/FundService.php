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
            ->when($request->query('fundManager'), function ($query, $fundManager) {
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
                    $existingAlias = FundAlias::find($alias['id']);
    
                    if ($existingAlias) {
                        $existingAlias->update($alias);
                    } else {
                        $response->aliases()->create($alias);
                    }
                }

                $response->aliases()->create($alias);
            }
        }

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

    public function findDuplicate(string $name): ?Fund
    {
        $fundsWithSameManager = $this->model->whereRelation('fundManager', 'name', $name)->get();

        return $this->model->where('name', $name)->first();
    }
}
