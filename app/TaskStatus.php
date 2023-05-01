<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaskStatus.
 *
 * @property string $name
 */
class TaskStatus extends Model
{
    protected $fillable = ['name'];
}
