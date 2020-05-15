<?php

namespace App\Http\Controllers;

use App\RealtimeSetting;
use Illuminate\Http\Request;

use App\Code;
use App\RealtimeChecking;

class RealtimeController extends Controller
{

    public function index_checking()
    {
        $realtime_checkings = RealtimeChecking::all();
        return view('realtime_checking', compact('realtime_checkings'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_setting()
    {
        $realtime_settings = RealtimeSetting::all();
        return view('realtime_setting', compact('realtime_settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $realtime_settings = RealtimeSetting::all();
        return view('realtime_edit', compact('realtime_settings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd(request()->code);
        $codes = Code::where('code', request()->code);
        //dd($codes->first());
        //codesテーブルにないコードの場合
        if($codes->first() == null) {
            return redirect('/realtime/create');
            //dd('$codes->first() == null');
        } 

        $realtime_settings = RealtimeSetting::where('code_id', $codes->first()->id);
        //dd($realtimeSettings);
        //realtime_ettingsテーブルにすでに登録がある場合
        if($realtime_settings->first() != null) {
            //dd('$realtimeSettings->first() != null');
            return redirect('/realtime/create');
        } 

        $realtime_setting = new RealtimeSetting;
        //$code = new Code;
        //dd($code);
        $realtime_setting->user_id = 1;
        $realtime_setting->code_id = $codes->first()->id;
        //dd($realtime_setting);
        $realtime_setting->save();

        $realtime_settings = RealtimeSetting::all();
        return redirect('/realtime_checking');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RealtimeSetting  $realtimeSetting
     * @return \Illuminate\Http\Response
     */
    public function show(RealtimeSetting $realtimeSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RealtimeSetting  $realtimeSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(RealtimeSetting $realtimeSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RealtimeSetting  $realtimeSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealtimeSetting $realtimeSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RealtimeSetting  $realtimeSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id, $code_id)
    {
        $realtime_setting = RealtimeSetting::where('user_id', $user_id)
                                ->where('code_id', $code_id)
                                ->first();
        //dd($realtime_setting);
        $realtime_setting->delete();
        return redirect('/realtime_setting');

        //$realtime_settings = RealtimeSetting::all();
        //return view('realtime', compact('realtime_settings'));
    }
}
