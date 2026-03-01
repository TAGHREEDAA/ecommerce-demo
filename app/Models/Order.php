<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_price', 'status'];

    protected function casts(): array
    {
        return [
            'total_price' => 'integer',
            'status'      => OrderStatus::class,
        ];
    }

    public function isPending(): bool
    {
        return $this->status === OrderStatus::Pending;
    }

    public function isProcessing(): bool
    {
        return $this->status === OrderStatus::Processing;
    }

    public function isCancelled(): bool
    {
        return $this->status === OrderStatus::Cancelled;
    }

    public function isRefunded(): bool
    {
        return $this->status === OrderStatus::Refunded;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
