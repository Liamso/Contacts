<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date:Y-m-d',
    ];

    /**
     * The attributes that can not be filled for mass assignment.
     * 
     * @var array
     */
    protected $guarded = [];
    
    /**
     * Gets all contact numbers for a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactNumbers()
    {
        return $this->hasMany(ContactNumber::class);
    }
    
    /**
     * Gets the primary phone number for a contact.
     *
     * @return App\Models\ContactNumber
     */
    public function getPrimaryPhoneAttribute()
    {
        return $this->contactNumbers->where('is_primary', 1)->first();
    }

    /**
     * Concatenates a contact's first and last names.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    /**
     * Applies a query string to a search for a contact.
     * Will attempt to search by normalised first name,
     * last name and company columns, as well as the
     * email column as-is.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $terms
     * @return void
     */
    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, $terms)
    {
        if (!empty($terms)) {
            collect(explode(' ', $terms))->each(function ($term) use ($query) {
                $normalisedTerm = preg_replace('/[^A-Za-z0-9]/', '', $term).'%';
                $query->where('contacts.first_name_normalised', 'like', $normalisedTerm)
                    ->orWhere('contacts.last_name_normalised', 'like', $normalisedTerm)
                    ->orWhere('contacts.company_normalised', 'like', $normalisedTerm)
                    ->orWhere('email', $term);
            });
        }
    }
}
