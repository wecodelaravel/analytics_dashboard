<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Booking.
 *
 * @property string $customername
 * @property string $phone
 * @property string $family_number
 * @property string $email
 * @property string $how_long
 * @property string $requested_date
 * @property string $requested_time
 * @property string $requested_clinic
 * @property string $clinic_id
 * @property string $clinic_email
 * @property string $clinic_address
 * @property string $clinic_phone
 * @property string $clinic_text_numbers
 * @property string $client_firstname
 * @property string $submitted_user_city
 * @property string $submitted_user_state
 * @property string $searched_for
 * @property string $latitude
 * @property string $longitude
 * @property string $country
 * @property string $submitted
 */
class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = ['customername', 'phone', 'family_number', 'email', 'how_long', 'requested_date', 'requested_time', 'requested_clinic', 'clinic_id', 'clinic_email', 'clinic_address', 'clinic_phone', 'clinic_text_numbers', 'client_firstname', 'submitted_user_city', 'submitted_user_state', 'searched_for', 'latitude', 'longitude', 'country', 'submitted'];

    protected $hidden = [];
}
