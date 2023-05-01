<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Analytic.
 *
 * @property string $view_name
 * @property string $view_id
 * @property string $website
 */
class Analytic extends Model
{
    use SoftDeletes;

    protected $fillable = ['view_name', 'view_id', 'website_id'];
    protected $hidden = [];

    /**
     * Set to null if empty.
     *
     * @param $input
     */
    public function setWebsiteIdAttribute($input)
    {
        $this->attributes['website_id'] = $input ? $input : null;
    }

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id')->withTrashed();
    }
}
