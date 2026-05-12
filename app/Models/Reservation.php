<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'number_of_people',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    // Accessor: totaalprijs van alle gerechten × aantal
    protected function totalPriceCents(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->dishes->sum(fn ($dish) => $dish->price_cents * $dish->pivot->quantity),
        );
    }

    // Accessor: totaalprijs als geformatteerd euro-bedrag
    protected function totalPriceEuro(): Attribute
    {
        return Attribute::make(
            get: fn () => '€ ' . number_format($this->total_price_cents / 100, 2, ',', '.'),
        );
    }

    // Accessor: betaald?
    protected function isPaid(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->paid_at !== null,
        );
    }
}