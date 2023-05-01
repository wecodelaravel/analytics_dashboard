<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TrackingNumber.
 *
 * @property string $metrics_id
 * @property string $number
 * @property string $location
 * @property string $company
 * @property string $callmetric_filter_id
 */
class TrackingNumber extends Model
{
    use SoftDeletes;

    protected $fillable = ['metrics_id', 'number', 'callmetric_filter_id', 'location_id', 'company_id'];
    protected $hidden = [];

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setLocationIdAttribute($input)
    {
        $this->attributes['location_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setCompanyIdAttribute($input)
    {
        $this->attributes['company_id'] = $input ? $input : null;
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id')->withTrashed();
    }

    public function company()
    {
        return $this->belongsTo(ContactCompany::class, 'company_id');
    }
}
