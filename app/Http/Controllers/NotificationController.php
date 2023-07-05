<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Events\UserNotificationEvent;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd($text=Auth::user()->id);
        $auth_id=Auth::user()->id;
        return view('pages.notification.index',compact('auth_id'));
    }

      /* Listing Of Country */
      public function listing() {
        $notification = Notification::latest()->where('status','!=', 2)->get(['id','title','message']);
        $records = [];
        foreach ($notification as $key => $row) {
            $checkbox= '<input type="checkbox" class="checkbox"  name="id[]" id="' . encryptid($row['id']) . '" onclick="single_unselected(this);"   style="    margin-left: 8px;"/>';


            $button = '';
                
                $button .= '<button class="country_edit btn btn-sm btn-success m-1" data-id="' . encryptid($row['id']) . '" >
                <i class="mdi mdi-square-edit-outline"></i>
                </button>';
                $button .= '<button class="delete btn btn-sm btn-danger m-1" data-id="' . encryptid($row['id']) . '">
                <i class="mdi mdi-delete"></i>
                </button>';
            $records[] = array(
                '0' => $checkbox,
                '1' => $row->title,
                '2' => $row->message,
                '3' => $button
            );
        }
        return response(['data'=>$records]);
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
        $request->validate(
			[
				'title' => 'required',
                'message' => 'required',
			]
		);
		$result = Notification::updateOrCreate([
			'id' => decryptid($request->notification_id),
		], [
			'title' => strtoupper($request->title),
			'message' => $request->message,
		]);

		if ($result) {

            $text=$result->id;
            event(new UserNotificationEvent($text));

			$response = [
				'status' => true,
				'message' => 'Notification ' . (decryptid($request->notification_id) == '0' ? 'Added' : 'Updated') . ' Successfully',
				'icon' => 'success',
			];
		} else {
			$response = [
                'data'=>$request->all(),
				'status' => false,
				'message' => "error in updating",
				'icon' => 'error',
			];
		}

		return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
