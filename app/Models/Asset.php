<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    /** @use HasFactory<\Database\Factories\AssetFactory> */
    /** @use SoftDeletes */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tag',
        'name',
        'description',
        'brand',
        'model',
        'series',
        'status',
        'category_id',
        'location_id',
        'contact_id',
        'decommission_reason',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
