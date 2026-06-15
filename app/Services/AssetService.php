<?php

namespace App\Services;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AssetService
{
    public function store(array $data): Asset
    {
        return DB::transaction(function () use ($data) {
            $nextId = Asset::withThrashed()->max('id') + 1;
            $data['id'] = $nextId;
            $data['tag'] = $this->createTag($nextId);
            $data['status'] = 'active';

            return Asset::create($data);
        });
    }

    private function createTag(int $nextId): string
    {
        $tag = 'B' . str_pad((string) $nextId, 5, '0', STR_PAD_LEFT);
        return $tag;
    }
}
