<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'type',
        'price_cents',
        'max_quantity',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    // Accessor: prijs in euro met komma
    protected function priceEuro(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->price_cents / 100, 2, ',', '.'),
        );
    }
}