<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Todo extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'id',
        'text',
        'marked',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'id';

    protected $table = 'todos';
}
