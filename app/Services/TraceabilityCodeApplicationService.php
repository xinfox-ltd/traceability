<?php

/*
 * Copyright (c) 2023. Moonstone. All rights reserved.
 */
declare(strict_types=1);

namespace App\Services;

use App\Enums\TraceabilityCodeApplicationStatus;
use App\Models\TraceabilityCodeApplication;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class TraceabilityCodeApplicationService
{
    public function list(User $user, array $params): LengthAwarePaginator
    {
        $query = TraceabilityCodeApplication::query()->with('enterprise');
        if ($user->isEnterprise()) {
            $query->where('enterprise_id', $user->enterprise_id);
        } else {
//            $query->with('enterprise');
        }
        return $query->orderBy('id', 'desc')
            ->paginate($params['page_size'] ?? 20);
    }

    /**
     * @param array $data
     * @return TraceabilityCodeApplication
     */
    public function save(array $data): TraceabilityCodeApplication
    {
        $data['status'] = TraceabilityCodeApplicationStatus::PendingReview;
        return TraceabilityCodeApplication::create($data);
    }

    public function get(User $user, int $id): TraceabilityCodeApplication
    {
        return TraceabilityCodeApplication::with('enterprise')
//            ->where('enterprise_id', $user->id)
            ->findOrFail($id);
    }

    public function delete(User $user, int $id): ?bool
    {
        return TraceabilityCodeApplication::where('enterprise_id', $user->id)->findOrFail($id)->delete();
    }
}
