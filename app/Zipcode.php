<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Zipcode.
 *
 * @property string $zipcode
 * @property string $clinic
 * @property string $location
 */
class Zipcode extends Model
{
    use SoftDeletes;

    protected $fillable = ['zipcode', 'clinic_id', 'location_id'];
    protected $hidden = [];

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
     * Set to null if empty.
     *
     * @param $input
     */
    public function setLocationIdAttribute($input)
    {
        $this->attributes['location_id'] = $input ? $input : null;
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id')->withTrashed();
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id')->withTrashed();
    }
}
