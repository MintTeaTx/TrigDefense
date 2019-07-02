<?php

namespace App\Models\Fleet;

use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Fleet extends Model
{
    protected $increments = true;
    protected $table = 'fleet';
    protected $casts = [
        'loot' => 'array',
        'participants' => 'array'
    ];
    protected $fillable = [
        'fc', 'fleet_name','active','complete','ended_at'

    ];
    public function getfc()
    {
        $user = User::find($this->fc);
        return $user;
    }
    public function endFleet()
    {
        $this->active = false;
        $this->complete = true;
        $this->ended_at = Carbon::now();
        $punches = $this->punches()->where('out_time', null)->get();
        //dd($punches);
        foreach ($punches as $punch)
        {
            $punch->out_time = $this->ended_at;
        }
        //$this->punchOut();
        $this->ended_at = Carbon::now();
    }
    public function punches()
    {
        return $this->hasMany(Punch::class);
    }
    public function participants()
    {
        return $this->belongsToMany(User::class)->using( Punch::class);
    }
    public function hasMember($userid)
    {
        //$member = $this->participants()->where('user_id', $userid)->first();
        $punch = $this->punches()->where('user_id', $userid)->latest()->first();
        if($punch) {
            if ($punch->out_time == null) {
                return 1;
            }
            if ($punch->out_time != null) {
                return 2;
            }
        }
        return 0;
    }
    public function duration()
    {
        $start = Carbon::parse($this->created_at);
        $end = Carbon::parse($this->ended_at);
        $hours = $end->diffInHours($start);
        $minutes = $end->diffInMinutes($start)%60;
        $seconds = $end->diffInSeconds($start)%60;

        return $seconds;
    }
    public function seconds()
    {
        $start = Carbon::parse($this->created_at);
        $end = Carbon::parse($this->ended_at);
        $seconds = $end->diffInSeconds($start);

        return $seconds;
    }
    public function punchIn()
    {
        $in_time = now();
        $user = auth()->user();
        $this->punches()->create(['user_id' => $user->id, 'fleet_id'=>$this->id]);
        $punch = Punch::where(['user_id' => $user->id, 'fleet_id'=>$this->id])->latest()->get()->first();
        $punch->in_time = $in_time;
        $punch->user()->associate($user);
        $punch->fleet()->associate($this);
        $punch->save();
        return redirect()->back();
    }
    public function punchOut()
    {
        $out_time = now();
        $user = auth()->user();
        $punch = Punch::where(['user_id' => $user->id, 'fleet_id'=>$this->id])->latest()->get()->first();
        $punch->out_time = $out_time;
        $punch->save();
        return redirect()->back();
    }
    public function rejoin()
    {
        $in_time = now();
        $user = auth()->user();
        $this->punches()->create(['user_id' => $user->id, 'fleet_id'=>$this->id]);
        $punch = Punch::where(['user_id' => $user->id, 'fleet_id'=>$this->id])->latest()->get()->first();
        $punch->in_time = $in_time;
        $punch->save();
        return redirect()->back();
    }
    public function punchInAt(Carbon $time, User $user)
    {
        $in_time = $time;
        $user = auth()->user();
        $this->punches()->create(['user_id' => $user->id, 'fleet_id'=>$this->id]);
        $punch = Punch::where(['user_id' => $user->id, 'fleet_id'=>$this->id])->latest()->get()->first();
        $punch->in_time = $in_time;
        $punch->user()->associate($user);
        $punch->fleet()->associate($this);
        $punch->save();
    }

    public function punchOutAt(Carbon $time, User $user)
    {
        $out_time = $time;
        $user = auth()->user();
        $punch = Punch::where(['user_id' => $user->id, 'fleet_id'=>$this->id])->latest()->get()->first();
        $punch->out_time = $out_time;
        $punch->save();

    }
}
