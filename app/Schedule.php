<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['date_schedule', 'status', 'call_id', 'team_id', 'user_id'];
    protected $appends = ['call', 'team', 'date_schedule_formated'];

    public function team()
    {
        $this->hasOne(Team::class);
    }

    public function call()
    {
        $this->hasOne(Call::class);
    }

    public function user()
    {
        $this->hasOne(User::class);
    }

    public function getCallAttribute()
    {
        return Call::where('id', $this->user_id)->first();
    }

    public function getTeamAttribute()
    {
        return Team::where('id', $this->user_id)->first();
    }

    public function getDateScheduleFormatedAttribute()
    {
        return empty($this->date_schedule)
            ? null
            : date('d/m/Y', strtotime($this->date_schedule));
    }

}
