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

        return Inertia::render('Settings', [

            'flo_settings' => $flo_settings,
        ]);
    }

    public function Update(Request $request){


       $flo_settings= FloSettings::find(1);

        \Illuminate\Support\Facades\Request::validate([
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

        $flo_settings->update($request->only('machine', 'du_no', 'flo_url', 'scan_url','unit_price','snap_code','snap_api_key','snap_webhook_key','flo_active'));

        session()->flash('flash.banner', 'Settings updated!');
        session()->flash('flash.bannerStyle', 'success');

        return Redirect::back()->with('success', 'User updated.');

    }
}
