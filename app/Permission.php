<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission.
 *
 * @property string $title
 */
class Permission extends Model
{
    protected $fillable = ['title'];
}
