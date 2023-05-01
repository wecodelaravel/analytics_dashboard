<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact.
 *
 * @property string $company
 * @property string $clinic
 * @property string $user
 * @property string $first_name
 * @property string $last_name
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 * @property string $skype
 * @property text $notes
 */
class Contact extends Model
{
    protected $fillable = ['first_name', 'last_name', 'phone1', 'phone2', 'email', 'skype', 'notes', 'company_id', 'clinic_id', 'user_id'];
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

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
    }

    public function company()
    {
        return $this->belongsTo(ContactCompany::class, 'company_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
