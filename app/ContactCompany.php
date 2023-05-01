<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContactCompany.
 *
 * @property string $name
 * @property string $logo
 */
class ContactCompany extends Model
{
    protected $fillable = ['name', 'logo'];
    protected $hidden = [];

    public function websites()
    {
        return $this->hasMany(Website::class, 'company_id');
    }

    public function clinics()
    {
        return $this->hasMany(Clinic::class, 'company_id');
    }
}
