<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Schedule;
use Illuminate\Support\Facades\DB;

class Call extends Model
{
    protected $fillable = ['description', 'status', 'date_open', 'date_close', 'user_id'];

    protected $appends = ['user', 'date_open_formated', 'date_close_formated', 'schedule'];

    public function user()
    {
        $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getUserAttribute()
    {
        return User::where('id', $this->user_id)->first();
    }

    public function getScheduleAttribute()
    {
        return DB::table('schedules')->where('call_id', $this->id)->first();
    }

    public function schedule()
    {
        $this->hasOne(Schedule::class);
    }

    public function getDateOpenFormatedAttribute()
    {
        return empty($this->date_open)
            ? null
            : date('d/m/Y', strtotime($this->date_open));
    }

    public function getDateCloseFormatedAttribute($value)
    {
        return empty($this->date_close)
            ? null
            : date('d/m/Y', strtotime($this->date_close));
    }


    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }

        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
}
