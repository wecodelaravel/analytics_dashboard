<?php

namespace App;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Location.
 *
 * @property string $parent_website
 * @property string $clinic_website_link
 * @property string $clinic
 * @property int $clinic_location_id
 * @property string $nickname
 * @property string $contact_person
 * @property string $address
 * @property string $address_2
 * @property string $city
 * @property string $state
 * @property string $location_email
 * @property string $phone
 * @property string $phone2
 * @property string $storefront
 * @property string $google_map_link
 * @property string $created_by
 */
class Location extends Model
{
    use SoftDeletes, FilterByUser;

    protected $fillable = ['clinic_website_link', 'clinic_location_id', 'nickname', 'address', 'address_2', 'city', 'state', 'location_email', 'phone', 'phone2', 'storefront', 'google_map_link', 'parent_website_id', 'clinic_id', 'contact_person_id', 'created_by_id'];
    protected $hidden = [];

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setParentWebsiteIdAttribute($input)
    {
        $this->attributes['parent_website_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setClinicIdAttribute($input)
    {
        $this->attributes['clinic_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to money format.
     *
     * @param $input
     */
    public function setClinicLocationIdAttribute($input)
    {
        $this->attributes['clinic_location_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setContactPersonIdAttribute($input)
    {
        $this->attributes['contact_person_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setCreatedByIdAttribute($input)
    {
        $this->attributes['created_by_id'] = $input ? $input : null;
    }

    public function parent_website()
    {
        return $this->belongsTo(Website::class, 'parent_website_id')->withTrashed();
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id')->withTrashed();
    }

    public function contact_person()
    {
        return $this->belongsTo(Contact::class, 'contact_person_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function zipcodes()
    {
        return $this->hasMany(Zipcode::class, 'location_id');
    }

    public function scopeByTrackingNumberCompany($query, $company_id)
    {
        $query->whereIn('id', function ($q) use ($company_id) {
            $q->from('tracking_numbers')
                ->where('company_id', $company_id)
                ->select('location_id');
        });
    }
}
