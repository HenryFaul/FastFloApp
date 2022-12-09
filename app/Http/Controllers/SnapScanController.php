<?php

namespace App\Http\Controllers;

use App\Models\FloSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SnapScanController extends Controller
{


    //Load live index page with config
    public function Index(): \Inertia\Response
    {
        $flo_settings = FloSettings::find(1);
        $ngrok_running=false;

        $headers = [
            'authorization' => 'Bearer '.$flo_settings->ngrok_api_token,
            'ngrok-version' => '2'
        ];

        $url='https://api.ngrok.com/tunnels';

        $response = Http::withHeaders($headers)->get($url);

        if ($response->successful()){

            $tunnels = json_decode($response->body());

            if(!empty($tunnels->tunnels)){
                $public_url = $tunnels->tunnels[0]->public_url;
                $flo_settings->flo_url=$public_url."/api/v1/dispenser/x/pour/y";
                $flo_settings->save();
                $ngrok_running=true;
            }

        }

        $flo_machine = $flo_settings->machine;
        $unit_price = "$flo_settings->unit_price";
        $base_url = "https://pos.snapscan.io/qr/" . $flo_settings->snap_code . ".svg?";

        return Inertia::render('SnapScan', [
            'machine' => $flo_machine,
            'price' => $unit_price,
            'snap_url' => $base_url,
            'ngrok_running'=>$ngrok_running
        ]);
    }

    //Load  static index page with config
    public function StaticIndex(): \Inertia\Response
    {
        $flo_settings = FloSettings::find(1);
        $ngrok_running=false;

        $headers = [
            'authorization' => 'Bearer '.$flo_settings->ngrok_api_token,
            'ngrok-version' => '2'
        ];

        $url='https://api.ngrok.com/tunnels';

        $response = Http::withHeaders($headers)->get($url);



        if ($response->successful()){

            $tunnels = json_decode($response->body());

            if(!empty($tunnels->tunnels)){
                $public_url = $tunnels->tunnels[0]->public_url;
                $flo_settings->flo_url=$public_url."/api/v1/dispenser/x/pour/y";
                $flo_settings->save();
                $ngrok_running=true;
            }

        }else{

        }
        $flo_machine = $flo_settings->machine;
        $unit_price = "$flo_settings->unit_price";
        $base_url = "https://pos.snapscan.io/qr/" . $flo_settings->snap_code . ".svg?";
        $button_url = "https://pos.snapscan.io/qr/" . $flo_settings->snap_code . "?";

        return Inertia::render('SnapScanStatic', [
            'machine' => $flo_machine,
            'price' => $unit_price,
            'snap_url' => $base_url,
            'snap_button_url' => $button_url,
            'ngrok_running'=>$ngrok_running
        ]);
    }

    //Load  dynamic index page with config

    public function DynamicIndex($id): \Inertia\Response
    {

        $flo_settings = FloSettings::find($id);

        if(is_null($flo_settings)){
            return abort(404);
        }

        $ngrok_running=false;

        $headers = [
            'authorization' => 'Bearer '.$flo_settings->ngrok_api_token,
            'ngrok-version' => '2'
        ];

        $url='https://api.ngrok.com/tunnels';

        $response = Http::withHeaders($headers)->get($url);

        if ($response->successful()){

            $tunnels = json_decode($response->body());

            if(!empty($tunnels->tunnels)){
                $public_url = $tunnels->tunnels[0]->public_url;
                $flo_settings->flo_url=$public_url."/api/v1/dispenser/x/pour/y";
                $flo_settings->save();
                $ngrok_running=true;
            }

        }else{

        }
        $flo_machine = $flo_settings->machine;
        $flo_du = $flo_settings->du_no;
        $unit_price = "$flo_settings->unit_price";
        $base_url = "https://pos.snapscan.io/qr/" . $flo_settings->snap_code . ".svg?";
        $button_url = "https://pos.snapscan.io/qr/" . $flo_settings->snap_code . "?";

        return Inertia::render('SnapScanDynamic', [
            'machine' => $flo_machine,
            'du' => $flo_du,
            'price' => $unit_price,
            'snap_url' => $base_url,
            'snap_button_url' => $button_url,
            'ngrok_running'=>$ngrok_running,
            'id'=>$id
        ]);
    }

    //process a new payment
    public function Payment(Request $request)
    {

        //find settings
        $flo_settings = FloSettings::find($request->get('id'));

        if(is_null($flo_settings)){
            return abort(404);
        }

        //apply values
        $payment_ref = $request->get('paymentRef');
        $qty = $request->get('qty');
        $du_no = $request->get('du_no');
        $url = $flo_settings->scan_url;
        $api_key = $flo_settings->snap_api_key;

        $poll_snap = true;
        $sleepy_time = 1;
        $time_out = 10;

        //sleep 5 seconds to allow for user to initiate payment
        sleep(5);

        try {
            while ($poll_snap) {

                //get all payments from snapscan
                $response = Http::withBasicAuth($api_key, '')->get($url);

                if ($response->successful()) {

                    $payments = json_decode($response->body());

                    //check lesser of first 10 or total payments

                    $loop_times = min(count($payments), 10);

                    for ($x = 0; $x <= $loop_times; $x++) {

                        $pay = $payments[$x];

                        if ($pay->merchantReference == $payment_ref) {

                            //return success if completed
                            if ($pay->status == 'completed') {

                                $poll_snap = false;
                                $response = $this->PourDrinks($du_no, $qty);

                                if ($response==="true"){
                                    Log::info("Processed payment and machine true: " . $payment_ref);
                                    Redirect::back()->with(['status' => 'success', 'style' => 'bg-blue-100 rounded-lg py-5 px-6 mb-4 text-base text-blue-700 mb-3', 'message' => 'Payment is successful. We are pouring' . $qty . ' drinks [' . $payment_ref . '].', 'cur_payment_ref' => $payment_ref]);
                                }
                                else{
                                    Log::info("Processed payment. Issue with machine: " . $payment_ref);
                                    Redirect::back()->with(['status' => 'success', 'style' => 'bg-blue-100 rounded-lg py-5 px-6 mb-4 text-base text-blue-700 mb-3', 'message' => 'Payment is successful. Issue with pouring ' . $qty . ' drinks [' . $payment_ref . '].', 'cur_payment_ref' => $payment_ref]);

                                }

                      }

                            //return error if error
                            if ($pay->status == 'error') {

                                $poll_snap = false;
                                Log::info("Payment error: " . $payment_ref);
                                Redirect::back()->with(['status' => 'error', 'style' => 'bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3', 'message' => 'Payment error. Please try again.', 'cur_payment_ref' => $payment_ref]);
                            }
                        }

                    }


                }

                //return if timed out +/- 45s

                if ($sleepy_time >= $time_out) {

                    $poll_snap = false;
                    Log::info("Timed out: " . $payment_ref);
                    Redirect::back()->with(['status' => 'error', 'style' => 'bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3', 'message' => 'Payment timed out. Please try again.', 'cur_payment_ref' => $payment_ref]);

                }

                //sleep for  sleepy time to wait for transaction
                sleep($sleepy_time);

                //increment sleepy time
                $sleepy_time++;

            }

        } catch (\Exception $exception) {

            //catch and return on exceptions
            Log::info("Exception: " . $payment_ref);
            Redirect::back()->with(['status' => 'error', 'style' => 'bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3', 'message' => 'Application Error. Please notify staff.', 'cur_payment_ref' => $payment_ref]);
        }

    }

    //test url
    public function Tester(Request $request)
    {

        $payment_ref = $request->get('paymentRef');

        $url ="http://localhost/api/v1/dispenser/x/pour/y";

        $x='DU1';
        $y='4';

        //to replace, with replace, og string
        $url=str_replace('x', $x, $url);
        $url=str_replace('y', $y, $url);

        dd($url);
        sleep(10);
        Redirect::back()->with(['status' => 'error', 'style' => 'bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3', 'message' => 'Payment error. Please try again.']);
    }

    public function WebHook(Request $request)
    {
        //TODO
    }

    //connect to dispenser api to pour drinks
    public function PourDrinks($x, $y)
    {
        /*http://localhost/api/v1/dispenser/x/pour/y, where,
        x = Dispenser Device (DU Number i.e. DU1, DU2, DU3 etc.), and
        y = number of pours*/

        $flo_settings = FloSettings::find(1);
        $url = $flo_settings->flo_url;

        dd($x);

        //to replace, with replace, og string
        $url=str_replace('x', $x, $url);
        $url=str_replace('y', $y, $url);

        if ($flo_settings->flo_active) {
            $response = Http::get($url);
            return $response->body();
        }
        else{
            return "Flo not active on app";
        }

    }
}
