<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = ['name', 'description'];

    public $timestamps = true;

    public function tasks() {
        return $this->hasMany(Task::class);
    }

}
