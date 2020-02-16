<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'name',
        'description'
    ];

    public $timestamps = true;


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function scopeDaily($query)
    {
        return $query->where('updated_at', Carbon::today())->orderBy('updated_at', 'DESC');
    }

    public function scopeGetById($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeGetFirstById($query, $id)
    {
        return $this->scopeGetById($query, $id)->first();
    }

}
