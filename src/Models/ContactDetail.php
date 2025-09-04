<?php

namespace Companue\Contacts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ContactDetail
 *
 * @property int $id
 * @property int $contact_id
 * @property string|null $type
 * @property string|null $value
 * @property string|null $label
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class ContactDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contact_id',
        'detail_title',
        'address',
        'postal_code',
        'phone_number',
        'mobile_number',
        'is_primary',
    ];

    protected $casts = [
        'contact_id' => 'integer',
        'is_primary' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the contact that owns the detail.
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
