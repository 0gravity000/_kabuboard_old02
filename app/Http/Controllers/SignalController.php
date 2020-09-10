<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DailyHistory;
use Carbon\Carbon;
use DateTimeZone;
use App\Holiday;
use Illuminate\Support\Arr;

class SignalController extends Controller
{

    public function index()
    {
        return view('signal');
    }

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
        //土日は除く
        // dayOfWeek returns a number between 0 (sunday) and 6 (saturday)
        while ($now->dayOfWeek == 6 or $now->dayOfWeek == 0) {
            //-1日する
            $now = $now->subDay();
        }
        //祝日は除く
        $holidays = Holiday::all();
        foreach ($holidays as $holiday) {
            if ($now->toDateString() == $holiday->updated_at) {
                //-1日する
                $now = $now->subDay();
            }
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


    public function index_akasanpei()
    {
        //現在
        $now = Carbon::now(new DateTimeZone('Asia/Tokyo'));
        //dd($now);
        //比較用
        $first = Carbon::create($now->year, $now->month, $now->day, 16, 30, 0);
        //dd($first);
        $second = Carbon::create($now->year, $now->month, $now->day, 23, 59, 59);
        //dd($second);

        //基準日を算出vvv
        if ($now->greaterThanOrEqualTo($first) && $now->lessThanOrEqualTo($second)) {
            //現在時刻が16:30:00-23:59:59なら基準日はそのまま
        } else {
            //現在時刻が00:00-16:29なら基準日は-1日
            $now->subDay();
            //dd($now);
        }
        //土日は除く
        // dayOfWeek returns a number between 0 (sunday) and 6 (saturday)
        while ($now->dayOfWeek == 6 or $now->dayOfWeek == 0) {
            //-1日する
            $now = $now->subDay();
        }
        //祝日は除く
        $holidays = Holiday::all();
        foreach ($holidays as $holiday) {
            if ($now->toDateString() == $holiday->updated_at) {
                //-1日する
                $now = $now->subDay();
            }
        }
        //基準日を算出^^^

        //最初に全銘柄分のstock_idと日付を格納した配列を作成
        $baseday_str = $now->toDateString();
        //dd($now, $one_bizday_ago);
        $daily_histories_0_buf = DailyHistory::where('updated_at', 'LIKE', "%$baseday_str%")->get();
        //dd($daily_histories_0_buf);
        $array_0 = array();
        $array_temp = array();
        foreach ($daily_histories_0_buf as $daily_history_0_buf) {
            $array_temp = array('stock_id' => $daily_history_0_buf->stock_id,
                                $baseday_str => $daily_history_0_buf->price);
            array_push($array_0, $array_temp);
            unset($array_temp);
        }
        //dd($array_0);

        //赤三兵判定処理
        $akasan_array = $array_0;   //配列をコピー
        $date_str = $baseday_str;
        $akasan_array_buf = array();    //配列を初期化
        $carbondate = $now;
        $date_array = array();
        array_push($date_array, $baseday_str);
        //３営業日分の現在値をチェックする
        for ($bizdayidx=0; $bizdayidx < 3; $bizdayidx++) { 

            //n営業日前(-1日する)の算出vvv
            $n_bizday_ago = Carbon::create($carbondate->year, $carbondate->month, $carbondate->day, $carbondate->hour, $carbondate->minute, $carbondate->second);
            $n_bizday_ago = $n_bizday_ago->subDay();
            //土日は除く
            // dayOfWeek returns a number between 0 (sunday) and 6 (saturday)
            while ($n_bizday_ago->dayOfWeek == 6 or $n_bizday_ago->dayOfWeek == 0) {
                //-1日する
                $n_bizday_ago = $n_bizday_ago->subDay();
            }
            //祝日は除く
            $holidays = Holiday::all();
            foreach ($holidays as $holiday) {
                if ($n_bizday_ago->toDateString() == $holiday->updated_at) {
                    //-1日する
                    $n_bizday_ago = $n_bizday_ago->subDay();
                }
            }
            $n_bizday_ago_str = $n_bizday_ago->toDateString();
            //var_dump($bizdayidx);
            //n営業日前(-1日する)の算出^^^

            //全銘柄分ループするvvv
            for ($arrayidx=0; $arrayidx < count($akasan_array); $arrayidx++) { 
                $stock_id = $akasan_array[$arrayidx]['stock_id'];
                //var_dump($stock_id);
                $price = $akasan_array[$arrayidx][$date_str];
                //dd($stock_id);

                $daily_history_n_ago_buf = DailyHistory::where('updated_at', 'LIKE', "%$n_bizday_ago_str%")
                                                            ->where('stock_id', $stock_id)
                                                            ->first();
                //赤三兵かチェックする
                if ($daily_history_n_ago_buf->price < $price) {
                    $akasan_array[$arrayidx][$n_bizday_ago_str] = $daily_history_n_ago_buf->price;
                    array_push($akasan_array_buf, $akasan_array[$arrayidx]);
                    //dd($akasan_array_buf);
                }
            }   //全銘柄分ループ^^^

            $akasan_array = $akasan_array_buf;
            $akasan_array_buf = array();    //空にする
            $date_str = $n_bizday_ago_str;
            array_push($date_array, $date_str);
            $carbondate = $n_bizday_ago;
            //dd($akasan_array_buf);
        }  //n営業日前(-1日する)の算出^^^
        //dd($akasan_array);

        //取得した配列を表示用に加工する
        $akasan_disp_array = array();
        $array_temp = array();
        for ($arrayidx=0; $arrayidx < count($akasan_array); $arrayidx++) {
            $stock_id = $akasan_array[$arrayidx]['stock_id'];
            $code = DailyHistory::where('stock_id', $stock_id)->first()->stock->code;
            $name = DailyHistory::where('stock_id', $stock_id)->first()->stock->name;
            $price_0 = $akasan_array[$arrayidx][$date_array[0]];
            $price_1 = $akasan_array[$arrayidx][$date_array[1]];
            $price_2 = $akasan_array[$arrayidx][$date_array[2]];
            $price_3 = $akasan_array[$arrayidx][$date_array[3]];
            $price_delta = floatval($price_0) - floatval($price_3);
            //$akasan_array[$arrayidx]['price_delta'] = $price_delta;

            $array_temp = array($stock_id, $code, $name, $price_delta, $price_0, $price_1, $price_2, $price_3);
            array_push($akasan_disp_array, $array_temp);
            unset($array_temp);
        }
        //dd($akasan_disp_array);
        return view('signal_akasanpei', compact('akasan_disp_array', 'date_array'));
    }

    public function index_debug()
    {

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
