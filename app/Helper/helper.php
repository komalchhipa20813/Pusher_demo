<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\{Notification , NotifyUser };


// / encrypt primary key of user /
if (!function_exists('encryptid')) {
	function encryptid($string) {
		$encrypted = Crypt::encryptString($string);
		return $encrypted;
	}
}

// / decrypt primary key of user /
if (!function_exists('decryptid')) {
	function decryptid($string) {
		$decrypted = Crypt::decryptString($string);
		return $decrypted;
	}
}

function active_class($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
  }
  function active_textclass($path, $active = 'text-white') {
	return call_user_func_array('Request::is', (array) $path) ? $active : 'text-dark';
}
  
  function is_active_route($path) {
    return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
  }
  
  function show_class($path) {
    return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
  }
  if (!function_exists('timecalaculate')) {
    function timecalaculate($date)
     {
           $t1 = Carbon::parse(Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
           ->format('Y-m-d H:i:s'));
           $t2 = Carbon::parse($date);
           $diff = $t1->diff($t2);
           $time='';
   
           if($diff->y != 0)
           {
              $time= $diff->y .' '. (($diff->y == 1 )? 'year' : 'years'). ' ago';
           }
           elseif($diff->m != 0)
           {
             $time= $diff->m .' '. (($diff->m == 1 )? 'month' : 'months'). ' ago';
           }
           elseif($diff->d != 0)
           {
             $time= $diff->d .' '. (($diff->d == 1 )? 'day' : 'days') . ' ago';
           }
           elseif($diff->h != 0)
           {
             $time= $diff->h .' '. (($diff->h == 1 )? 'hour' : 'hours'). ' ago';
           }
           elseif($diff->i != 0)
           {
             $time= $diff->i .' '. (($diff->i == 1 )? 'min' : 'mins'). ' ago';
           }
           elseif($diff->s != 0)
           {
             $time= $diff->s .' '. 'sec ago';
           }
   
           return $time;
     }
   }

  if (!function_exists('headerData')) {
    function headerData() {
      $notification_ids = NotifyUser::where('user_id',Auth::user()->id)->pluck('notif_id')->toArray();

        $notifictions =Notification::latest()->where('status','!=',2)->whereNotIn('id',$notification_ids)->get();
        $data['count']=  $notifictions->count();
        $html='';
        if(!empty( $notifictions) && $data['count'] != 0)
        {
          $html.='
              <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
              <p><span  class="total-notification" style="margin-right: 5px;">'.$data['count'].' </span> New Notifications </p>
              <a style="margin-left: 30px;" class="text-muted notification-clear" href="javascript:notificationClear(0);" > Clear all </a>
            </div>';
           foreach($notifictions as $notification)
           {
              $html.='
              <div class="p-1 pusher-data" >
              <a  class="dropdown-item d-flex align-items-center py-2">
              <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                  <i class="icon-sm text-white" data-feather="book-open"></i>
              </div>
              <div class="flex-grow-1 me-2">
                  <p><span style="display:inline; width:100px;">'.$notification->title.'</span> <span style="margin-left: 110px;" onclick="notificationClear('.$notification->id.')">&times; </span></p>
                  <p  class="tx-12 text-muted">'.$notification->message.'</p>
                  <p class="tx-12 text-muted">'.timecalaculate($notification->date) .'</p>
              </div>	
              </a>
              </div>';
           }
        }
        else{
            $html.='<div class="px-3 py-2 d-flex align-items-center justify-content-between order-bottom"><p  class="tx-12 text-muted">NO NOTIFICATIONS</p></div>';
        }
        $data['notifictions']=$html;
      return $data;
    }
  }

 
  
  

?>