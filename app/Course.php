<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    /**
     * Override the toArray method for JSON responses
     * @return array
     */
    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
