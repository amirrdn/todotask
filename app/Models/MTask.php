<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MTask extends Eloquent
{
    protected $connection = 'mongodb';
	protected $collection = 'task';
    
    protected $fillable = ['name', 'id', 'assigned_to', 'created_at', 'updated_at'];

    public function user () {
        return $this->belongsTo(User::class);
    }
}
