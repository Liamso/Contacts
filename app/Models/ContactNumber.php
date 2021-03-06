<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactNumber extends Model
{
    use HasFactory;

    /**
     * The attributes that can not be filled
     * for mass assignment.
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Gets the contact for a number.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    /**
     * Syncs an array of contact numbers given a
     * contact ID and the array index of 
     * the primary contact number.
     *
     * @param  array $contactNumbers  The array of contact numbers.
     * @param  string $primaryId  The array index of the primary number.
     * @param  int $contactId  The ID of the contact to sync numbers to.
     * @return void
     */
    public static function syncAll($contactNumbers, $primaryId, $contactId)
    {
        foreach($contactNumbers as $id => $contactNumber) {
            $data = [
                'number' => $contactNumber['number'],
                'is_primary' => (string) $id === $primaryId || count($contactNumbers) === 1 ? 1 : 0,
                'contact_id' => $contactId
            ];

            if ($id === 'new') {
                self::create($data);
            } else {
                self::where('id', $id)->update($data);
            }
        }
    }
}
