<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Website.
 *
 * @property string $company
 * @property string $clinic
 * @property string $website
 */
class Website extends Model
{
    use SoftDeletes;

    protected $fillable = ['website', 'company_id', 'clinic_id'];
    protected $hidden = [];

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setCompanyIdAttribute($input)
    {
        $this->attributes['company_id'] = $input ? $input : null;
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

    public function company()
    {
        return $this->belongsTo(ContactCompany::class, 'company_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id')->withTrashed();
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'parent_website_id');
    }

    public function adwords()
    {
        return $this->hasMany(Adword::class, 'website_id');
    }

    public function analytics()
    {
        return $this->hasMany(Analytic::class, 'website_id');
    }
}
