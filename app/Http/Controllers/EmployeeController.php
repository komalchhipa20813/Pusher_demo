<?php

namespace App\Http\Controllers;

use App\Models\{Branch,Education,Role,User,Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\EmployeeMail;
use Mail;
use Carbon\Carbon;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('pages.employee.index');
    }

    /* Listing Of Employee */
    public function listing() {
        $users = User::where('status', '!=', 2)->where('role_id','!=',1)->with('branch')->latest()->get();
        $records = [];
        $permissionList = permission();
        foreach ($users as $key => $row) {
            $checkbox= '<input type="checkbox" class="checkbox"  name="id[]" id="' . encryptid($row['id']) . '" onclick="single_unselected(this);"   style="    margin-left: 8px;"/>';

            $image = '';
            if(!empty($row->image))
            {
                $image= '<img src="' . url('uploads/images/' . $row->image) . '" alt="Girl in a jacket" width="50" height="60">';
            }
            

            $button = '';
            if (in_array("37", $permissionList)) {

                $button .= '<button class="btn btn-info reset_password" id="reset_password" data-id="' . encryptid($row['id']) . '" >
                <i class="mdi mdi-lock-outline"></i>
                </button>';
            }
            if (in_array("33", $permissionList)) {
                $button .= '<a href="' . route('employee.show', encryptid($row['id'])) . '"><button class="btn btn-sm btn-success m-1"  data-id="' . encryptid($row['id']) . '" >
                <i class="mdi mdi-view-module"></i>
                </button></a>';
            }
            if (in_array("35", $permissionList)) {
                $button .= '<a href="' . route('employee.edit', encryptid($row['id'])) . '"><button class=" btn btn-sm btn-success m-1">
                <i class="mdi mdi-square-edit-outline"></i>
                </button></a>';
            }
            if (in_array("36", $permissionList)) {
                $button .= '<button class="delete btn btn-sm btn-danger m-1" data-id="' . encryptid($row['id']) . '">
                <i class="mdi mdi-delete"></i>
                </button>';
            }
            $records[] = array(
                '0' => $checkbox,
                '1' => $image,
                '2' => $row['first_name'] . ' ' . $row['last_name'],
                '3' => $row['email'],
                '4' => $row['branch']->name,
                '5' => $button
            );
        }
        return response(['data'=>$records]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['branches'] = Branch::select('id', 'name')->where('status', 1)->get();
		$data['educations'] = Education::select('id', 'education')->where('status', 1)->get();
		$data['roles'] = Role::select('id', 'title')->where('status', 1)->where('id', '!=', 1)->get();
		if ($request->id) {
			$data['employee'] = User::find(decryptid($request->id));
		}
		return view('pages.employee.create', compact('data'));
    }

    /*Check Availability Of Branch*/
    public function email_check(Request $request){
        if(isset($request) && $request->email && $request->id){
        $user = User::where('email',$request->email)->where('id','!=',decryptid($request->id))->where('status','!=',2)->first('email');
        return(!is_null($user))? true :false;
        }
        else{
            return false;
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'role_id' => 'required',
			'branch_id' => 'required',
		]);
        $image='';
        if(isset($request->image)){
            $image = time() . 'emp' . strtolower(substr($request->first_name, 0, 3)) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/images/'), $image);
        } else {
            $image = (decryptid($request->employee_id)==0)?null:User::find(decryptid($request->employee_id))->image;
        }

        $branch_data=Branch::find($request->branch_id);
        $code_id= Setting::where('key','user_code')->first()->value;
        $code= (decryptid($request->employee_id)==0)? 'MA'.$branch_data['branch_code'].'-'.$code_id:User::find(decryptid($request->employee_id))->code;

		$status = ($request->has('status')) ? 1 : 0;
        $user = User::updateOrCreate(
			[
				'id' => decryptid($request->employee_id)
			],
			[
				'image' => $image,
                'code' =>$code,
				'branch_id' => $request->branch_id,
				'role_id' => $request->role_id,
				'first_name' => $request->first_name,
				'middle_name' => $request->middle_name,
				'last_name' => $request->last_name,
				'email' => $request->email,
				'phone' => $request->phone,
				'address' => $request->address,
				'gender' => $request->gender,
				'dob' => Carbon::createFromFormat('d-m-Y', $request->dob)
                ->format('Y-m-d H:i:s'),
				'joining_date' => Carbon::createFromFormat('d-m-Y', $request->joining_date)
                ->format('Y-m-d H:i:s'),
				'education_id' => $request->qualification,
				'salary' => $request->salary,
				'designation' => $request->designation,
				'account_number' => $request->salary_account,
				'ifsc_code' => $request->ifsc_code,
				'holder_name' => $request->account_holder,
				'status' => $status,
			]
		);

        if(decryptid($request->employee_id) == '0')
        {
           
            
            $password=Str::random(10);
            $user->update(['password' =>Hash::make($password)]);
            $email_subject= "Registration on ".config('app.name');
            $email_data=[
                'name'=> $request->first_name.' '. $request->middle_name .' '. $request->last_name,
                'password'=>$password,
                'email'=>$request->email,
                'code'=>$code
            ];
            Mail::to($request->email)->send(new EmployeeMail($email_data,$email_subject));
            Setting::where('key','user_code')->update(['value'=>str_pad(++$code_id,2,'0',STR_PAD_LEFT)]);
        }

        if($user)
        {
            $response = [
                    'status' => true,
                    'message' => 'Employee ' . (decryptid($request->employee_id) == '0' ? 'Created' : 'Updated') . ' Successfully',
                    'icon' => 'success',
                    'redirect_url' => "employee",
                ];
		}
        else{
            $response = [
                'status' => false,
                'message' => 'Something Went Wrong! Please Try Again.',
                'icon' => 'error',
            ];
        }
		return response($response);

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = User::with('branch','role','education')->find(decryptid($id));
		if ($employee->status == 2) {
			return redirect()->route('404');
		}
		return view('pages.employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find(decryptid($id));

        if ($user) {
            if ($user->status == 2) {
                return redirect()->route('404');
            }
            $employee = $user;
            $data['branches'] = Branch::select('id', 'name')->where('status', 1)->get();
            $data['educations'] = Education::select('id', 'education')->where('status', 1)->get();
            $data['roles'] = Role::select('id', 'title')->where('status', 1)->where('id', '!=', 1)->get();
            // dd($data);
            return view('pages.employee.create', compact('data','employee'));
        } else {
            return redirect(route('branch.index'));
        }
    }

  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $update['status']=2;
            $result= User::where('id',decryptid($id))->update($update);
            if($result)
            {
                $response = [
                    'status' => true,
                    'message' => "Employee Data Deleted Successfully",
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
		$users = User::where('status','!=',2)->pluck('id')->toArray();
		$result = User::whereIn('id',array_intersect($ids, $users))->update($update);
		if ($result) {
			$response = [
				'status' => true,
				'message' => 'Employee Deleted Successfully',
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

    public function oldreset_password(Request $request)
    {
        return $request->all();
        $user=User::where('status','!=',2)->find(decryptid($$request->id));
        if(!is_null($user))
        {
            $password=Str::random(10);
            $user->update(['password' =>Hash::make($password)]);
            $email_subject= "Reset Password on ".config('app.name');
            $email_data=[
                'name'=> $user['first_name'].' '. $user['middle_name'] .' '. $user['last_name'],
                'password'=>$password,
                'email'=>$user['email'],
                'code'=>$user['code']
            ];
            Mail::to($user['email'])->send(new EmployeeMail($email_data,$email_subject));

            if (Mail::failures()) {
                $response = [
                    'status' => false,
                    'message' => "Something Went Wrong! Please Try Again",
                    'icon' => 'error',
                ];
            }
            else
            {
                $response = [
                    'status' => true,
                    'message' => 'Great! Password reset Successfully and send in your mail',
                    'icon' => 'success',
                ];
               
              
            }
        }
        else
        {
            $response = [
                'status' => false,
                'message' => "Something Went Wrong! Please Try Again",
                'icon' => 'error',
            ];

        }

        return response($response);
    }

    public function reset_password(Request $request)
    {
        
        $user=User::where('status','!=',2)->find(decryptid($request->employee_id));
        if(!is_null($user))
        {
            $user->update(['password' =>Hash::make($request->password)]);
            
            $response = [
                'status' => true,
                'message' => 'Password Reset Successfully.',
                'icon' => 'success',
            ];
                
        }
        else
        {
            $response = [
                'status' => false,
                'message' => "Something Went Wrong! Please Try Again",
                'icon' => 'error',
            ];

        }

        return response($response);
    }
}
