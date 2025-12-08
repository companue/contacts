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

    /**
     * Determine whether a given input (array of attributes) is eligible to become primary.
     * For now a detail is "primable" when it contains an `address` value.
     *
     * @param  array  $attributes
     * @return bool
     */
    public static function isPrimable(array $attributes): bool
    {
        return !empty($attributes['address']);
    }

    /**
     * Decide and prepare primary assignment for a new detail before creation.
     * This method may modify the passed `$attributes` (by reference) to set `is_primary`.
     * It will also clear other active primary flags when necessary.
     *
     * Rules implemented:
     * - If the form explicitly requests `is_primary` and the input is primable => make it primary and clear others.
     * - If it's the first (active) detail for the contact and the input is primable => make it primary.
     * - If it's not the first, but there is no primary yet for the contact and the input is primable => make it primary.
     *
     * @param  int|null  $contactId
     * @param  array&    $attributes
     * @return void
     */
    public static function selectPrimaryForCreate($contactId, array & $attributes): void
    {
        $primable = self::isPrimable($attributes);

        if (! $primable) {
            // If not primable, ensure we don't accidentally set primary
            if (isset($attributes['is_primary'])) {
                $attributes['is_primary'] = false;
            }
            return;
        }

        // If explicit primary requested and contact known -> clear others and honor it
        if (!empty($attributes['is_primary']) && ! empty($contactId)) {
            self::where('contact_id', $contactId)->whereNull('deleted_at')->update(['is_primary' => false]);
            $attributes['is_primary'] = true;
            return;
        }

        // If we don't have a contact id we cannot inspect existing details.
        if (empty($contactId)) {
            return;
        }

        $hasExistingDetails = self::where('contact_id', $contactId)->whereNull('deleted_at')->exists();
        $hasPrimary = self::where('contact_id', $contactId)->where('is_primary', true)->whereNull('deleted_at')->exists();

        if (! $hasExistingDetails) {
            // First detail for contact -> make primary
            $attributes['is_primary'] = true;
            return;
        }

        if (! $hasPrimary) {
            // There are details but none is primary -> make this one primary
            // Clear any flags just in case and set this one
            self::where('contact_id', $contactId)->whereNull('deleted_at')->update(['is_primary' => false]);
            $attributes['is_primary'] = true;
            return;
        }

        // Otherwise do nothing (existing primary remains)
    }
}
