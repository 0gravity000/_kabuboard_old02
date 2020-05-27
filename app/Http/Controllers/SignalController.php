<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DailyHistory;
use Carbon\Carbon;
use DateTimeZone;
use App\Holiday;

class SignalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_volume()
    {
        //現在
        $now = Carbon::now(new DateTimeZone('Asia/Tokyo'));
        //dd($now);
        //比較用
        $first = Carbon::create($now->year, $now->month, $now->day, 16, 30, 0);
        //dd($first);
        $second = Carbon::create($now->year, $now->month, $now->day, 23, 59, 59);
        //dd($second);
        //基準日
        if ($now->greaterThanOrEqualTo($first) && $now->lessThanOrEqualTo($second)) {
            //現在時刻が16:30:00-23:59:59なら基準日はそのまま
        } else {
            //現在時刻が00:00-16:29なら基準日は-1日
            $now->subDay();
            //dd($now);
        }

        //1営業日前 -1日する
        $one_bizday_ago = Carbon::create($now->year, $now->month, $now->day, $now->hour, $now->minute, $now->second);
        $one_bizday_ago = $one_bizday_ago->subDay();
        //土日は除く
        // dayOfWeek returns a number between 0 (sunday) and 6 (saturday)
        while ($one_bizday_ago->dayOfWeek == 6 or $one_bizday_ago->dayOfWeek == 0) {
            //-1日する
            $one_bizday_ago = $one_bizday_ago->subDay();
        }
        //祝日は除く
        $holidays = Holiday::all();
        foreach ($holidays as $holiday) {
            if ($one_bizday_ago->toDateString() == $holiday->updated_at) {
                //-1日する
                $one_bizday_ago = $one_bizday_ago->subDay();
            }
        }

        $baseday_str = $now->toDateString();
        $one_bizday_ago_str = $one_bizday_ago->toDateString();
        //dd($now, $one_bizday_ago);
        //dd($baseday_str, $one_bizday_ago_str);

        //
        $daily_histories_0_buf = DailyHistory::where('updated_at', 'LIKE', "%$baseday_str%")->get();
        //dd($daily_histories_0_buf);
        $array_0 = array();
        $array_minus1 = array();
        //出来高急増判定
        foreach ($daily_histories_0_buf as $daily_history_0_buf) {
            //
            $daily_history_minus1_buf = DailyHistory::where('updated_at', 'LIKE', "%$one_bizday_ago_str%")
                                                ->where('stock_id', $daily_history_0_buf->stock_id)
                                                ->first();
            //dd($daily_history_0_buf, $daily_history_minus1_buf);
            //基準日と1営業日前の両方の出来高が0のものは除外
            if (intval($daily_history_0_buf->volume) == 0 && intval($daily_history_minus1_buf->volume) == 0) {
                continue;
            }
        //出来高が1営業日前よりx倍増えているかチェック
            if (intval($daily_history_0_buf->volume) >= intval($daily_history_minus1_buf->volume)*10) {
                //dd($daily_history_0_buf, $daily_history_minus1_buf);
                //dd($daily_history_0_buf->volume, $daily_history_minus1_buf->volume);
                array_push($array_0, $daily_history_0_buf->id);
                array_push($array_minus1, $daily_history_minus1_buf->id);
            }
        }
        //
        //dd($array_0, $array_minus1);
        $daily_histories_0 = DailyHistory::whereIn('id', $array_0)->get();
        $daily_histories_minus1 = DailyHistory::whereIn('id', $array_minus1)->get();
        //dd($daily_histories_0, $daily_histories_minus1);
        /*
        for ($idx=0; $idx < count($idx) ; $idx++) { 
        }
        */
        return view('signal_volume', compact('daily_histories_0', 'daily_histories_minus1','baseday_str'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
