<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function savePushNotificationToken(Request $request)
    {
        //dd($request->token);
        $user=User::find(Auth::user()->id);
        $user->device_token = $request->token;
        $user->update();
        return response()->json(['token saved successfully.']);
    }

    public function sendPushNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAAXf3AV1c:APA91bHhGoNzMnoJHSmXL7BDW4qdR87lktjloPwJwQDVZ5m7X2E63MLpyDdNXuYbbGgRHk4Ss8fHGGWYxvqxp_mGQcnMgUcIS8G8MWjHonzHZ_YYBSf_VoeoWHCPdLqq1NJ24BbkpuD8';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        return redirect()->back();
        //return response::json(['message'=> 'notification send successfully',$response]);

    }
}
