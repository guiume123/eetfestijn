<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'description',
        'event_date',
        'registration_deadline',
        'slug',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'registration_deadline' => 'datetime',
    ];

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    // Accessor: registratie nog open?
    protected function registrationOpen(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->registration_deadline->isFuture(),
        );
    }

    // Accessor: aantal plaatsen al gereserveerd
    protected function totalReservedPeople(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservations()->sum('number_of_people'),
        );
    }
}