<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Sector extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'sector';
    
    protected $fillable = [
        'name'
    ];
}
