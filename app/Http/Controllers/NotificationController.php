<?php

namespace App\Http\Controllers;

use App\Models\{Notification,NotifyUser};
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Events\UserNotificationEvent;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(headerData());
        $notification_ids = NotifyUser::where('user_id',Auth::user()->id)->pluck('notif_id')->toArray();

        $notifictions =Notification::latest()->where('status','!=',2)->whereNotIn('id',$notification_ids)->get();


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
                
                $button .= '<button class="notitfication_edit btn btn-sm btn-success m-1" data-id="' . encryptid($row['id']) . '" >
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

    public function notificationData(Request $request)
    {
        $response = [
            'data'=> headerData(),
            'status' => true,
            'message' => 'Notification  Successfully',
            'icon' => 'success',
        ];
        
        return response($response);
        

    }

    public function readNotification(Request $request)
    {
        if((int)$request->id == 0)
        {
            $notification_ids = NotifyUser::where('user_id',Auth::user()->id)->pluck('notif_id')->toArray();

            $notifictions =Notification::latest()->where('status','!=',2)->whereNotIn('id',$notification_ids)->get();
    
            foreach ($notifictions as $notifiction) {
                $data[] = ['user_id' => Auth::user()->id, 'notif_id' => $notifiction->id];
            }
            
        }
        else{
            $data[] = ['user_id' => Auth::user()->id, 'notif_id' => (int)$request->id];
        }
       
        NotifyUser::insert($data);

        $response = [
            'data'=> headerData(),
            'status' => true,
            'message' => 'Notification read Successfully',
            'icon' => 'success',
        ];
        
        return response($response);

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
            'date'=> Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
            ->format('Y-m-d H:i:s')
		]);

		if ($result) {
            NotifyUser::where('notif_id',decryptid($request->notification_id))->delete();
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
    public function show($id)
    {
        try{
            $notification = Notification::where('id', decryptid($id))->first();
            $response = [
                'data' => $notification,
                'status' => true,
            ];
        }catch (\Throwable $e) {
            $response = [
                'status' => false,
                'message' => 'Something Went Wrong! Please Try Again.',
                'icon' => 'error',
            ];
        }
        return response($response);
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
    public function destroy($id)
    {
        try {
            $update['status']=2;
            $result= Notification::where('id',decryptid($id))->update($update);
            if($result)
            {
                NotifyUser::where('notif_id',decryptid($id))->delete();
                $response = [
                    'status' => true,
                    'message' => "Notification Data Deleted Successfully",
                    'icon' => 'success',
                ];
            }
            else{
                $response = [
                    'status' => false,
                    'message' => "Something Went Wrong! Please Try Again.",
                    'icon' => 'error',
                ];
            }
            
        }catch (\Throwable $e) {
            $response = [
                'status' => false,
                'message' => "Something Went Wrong! Please Try Again.",
                'icon' => 'error',
            ];
        }
        return response($response);
    }

    /* Delete selected Branch */
	public function deleteAll(Request $request) {
		$update['status'] = 2;
		$ids=[];
		$data_ids = $request->ids;
		foreach ($data_ids as $key => $value) {
			$ids[]=decryptid($value);
		}
		$users = Notification::where('status','!=',2)->pluck('id')->toArray();
		$result = Notification::whereIn('id',array_intersect($ids, $users))->update($update);
		if ($result) {
            NotifyUser::whereIn('notif_id',array_intersect($ids, $users))->delete();
			$response = [
				'status' => true,
				'message' => 'Notification Deleted Successfully',
				'icon' => 'success',
			];
		} else {
			$response = [
				'status' => false,
				'message' => "error in deleting",
				'icon' => 'error',
			];
		}
		return response($response);
	}
}
