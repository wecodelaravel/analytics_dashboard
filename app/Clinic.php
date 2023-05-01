<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Clinic.
 *
 * @property string $nickname
 * @property string $logo
 * @property string $company
 * @property text $notes
 */
class Clinic extends Model
{
    use SoftDeletes;

    protected $fillable = ['nickname', 'logo', 'notes', 'company_id'];
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

    public function company()
    {
        return $this->belongsTo(ContactCompany::class, 'company_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'clinic_user');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'clinic_id');
    }

    public function websites()
    {
        return $this->hasMany(Website::class, 'clinic_id');
    }

    public function zipcodes()
    {
        return $this->hasMany(Zipcode::class, 'clinic_id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'clinic_id');
    }
}
