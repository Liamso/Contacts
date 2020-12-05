<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'datetime:Y-m-d',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, $terms)
    {
        if (!empty($terms)) {
            collect(explode(' ', $terms))->each(function ($term) use ($query) {
                $term = preg_replace('/[^A-Za-z0-9]/', '', $term).'%';
                $query->where('contacts.first_name_normalised', 'like', $term)
                    ->orWhere('contacts.last_name_normalised', 'like', $term)
                    ->orWhere('contacts.email', 'like', $term)
                    ->orWhere('contacts.company_normalised', 'like', $term);
            });
        }
    }
}
