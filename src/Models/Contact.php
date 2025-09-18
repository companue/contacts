<?php

namespace Companue\Contacts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Contact
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $title
 * @property string $label
 * @property int|null $creator_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection|\Companue\Contacts\Models\ContactDetail[] $details
 */

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'type',
        'category',
        'title',
        'name_firstname',
        'brand_lastname',
        'national_code',
        'creator_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'creator_id' => 'integer',
        'title' => 'integer',
        'deleted_at' => 'datetime',
    ];


    /**
     * Get the contact details for the contact.
     */
    public function details()
    {
        return $this->hasMany(ContactDetail::class);
    }

    /**
     * Find or create a contact by attributes.
     *
     * @param array|string $contact_
     * @param string $type
     * @return static
     */
    public static function findOrCreate($contact_, $type = 'customer')
    {

        if (strstr($contact_, 'new-')) {
            // may be new customer
            $label = str_replace('new-', '', $contact_);
            $query = Contact::where('label', $label);
            if ($query->count() > 0) {
                $contact = $query->sole();
            } else
                $contact = Contact::create([
                    'label' => $label,
                    'type' => $type,
                ]);
        } else {
            // registered customer
            $contact = Contact::find((int)$contact_);
            if (!str_contains($contact->type, $type)) {
                $contact->type = is_null($contact->type) ? $type : $contact->type . ',' . $type;
                $contact->save();
            }
        }

        return $contact;
    }

    public function getLabelAttribute($value)
    {
        // TODO grammertize must be implemented for non-farsi languages
        return $value ?: (($title = ContactTitle::find($this->title)) ? $title->title . ' ' : '')  . $this->name_firstname . ' ' . $this->brand_lastname;
    }
}
