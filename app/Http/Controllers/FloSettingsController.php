<?php

namespace App\Http\Controllers;

use App\Models\FloSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FloSettingsController extends Controller
{
    //
    public function Index(){

        $flo_settings = FloSettings::find(1);

        $all_flo_settings = FloSettings::all();

        return Inertia::render('Settings', [

            'flo_settings' => $flo_settings,
            'all_flo_settings'=>$all_flo_settings
        ]);
    }

    public function Update(Request $request){


        \Illuminate\Support\Facades\Request::validate([

            'selected_setting' => ['required'],
            'machine' => ['required','string'],
            'du_no' => ['required','string'],
            'flo_url' => ['required','string'],
            'scan_url' => ['required','string'],
            'unit_price' => ['required','numeric'],
            'snap_code' => ['required','string'],
            'snap_api_key' => ['required','string'],
            'snap_webhook_key' => ['required','string'],
            'flo_active' => ['required','boolean'],

        ]);

        $selected_setting = $request->get('selected_setting');

        $flo_settings= FloSettings::find($selected_setting);

        $flo_settings->update($request->only('machine', 'du_no', 'flo_url', 'scan_url','unit_price','snap_code','snap_api_key','snap_webhook_key','flo_active'));

        session()->flash('flash.banner', 'Settings updated!');
        session()->flash('flash.bannerStyle', 'success');

        return Redirect::back()->with('success', 'User updated.');

    }
}
