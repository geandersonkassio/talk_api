<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'description'];

    public function schedules()
    {
        $this->belongsToMany(Schedule::class);
    }
    
    public function getCreatedAtAttribute($value)
    {
        return empty($value) 
        ? null 
        : date('d/m/Y', strtotime($value));
    }

    public function getUpdateAtAttribute($value)
    {
        return empty($value) 
        ? null 
        : date('d/m/Y', strtotime($value));
    }

}
