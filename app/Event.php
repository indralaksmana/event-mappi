<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Event extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'event';
    
    protected $fillable = [
        'name',
        'category',
        'sector',
        'status',
        'startDate',
        'endDate',
        'timeStart',
        'timeEnd',
        'place',
        'organizer',
        'description',
        'type',
        'forUsers',
        'createdBy',
        'updatedBy'
    ];
}
