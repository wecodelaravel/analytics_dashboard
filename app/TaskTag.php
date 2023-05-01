<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskTag.
 *
 * @property string $name
 */
class TaskTag extends Model
{
    protected $fillable = ['name'];
}
