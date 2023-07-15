<?php

namespace App\Http\Controllers;

use App\SchoolUser;
use App\User;
use App\School_info;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'=>'required',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:3|confirmed',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
         $user->save();
        $reg_id = $user->id;
        if($reg_id){
            $school_info = new School_info();
            $school_info->institute_name = $request->name;
            $school_info->contact = $request->contact;
            $school_info->email = $request->email;
            $school_info->save();
            $school_id = $school_info->id;
            $school_contact = $school_info->contact;
            if($school_id){
                $school_user = new SchoolUser();
                $school_user->user_id = $reg_id;
                $school_user->school_id = $school_id;
                $school_user->save();
                $classes = [
                    ['name'=>'Pre-Nursery' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') , 'school_id'=>$school_id ],
                    ['name'=>'Nursery' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') , 'school_id'=>$school_id],
                    ['name'=>'LKG' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') , 'school_id'=>$school_id],
                    ['name'=>'UKG' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') , 'school_id'=>$school_id],
                    ['name'=>'One' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') , 'school_id'=>$school_id],
                    ['name'=>'Two' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01') , 'school_id'=>$school_id],
                    ['name'=>'Three' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01'), 'school_id'=>$school_id ],
                    ['name'=>'Four' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01'), 'school_id'=>$school_id ],
                    ['name'=>'Five' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01'), 'school_id'=>$school_id ],
                    ['name'=>'Six' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01'), 'school_id'=>$school_id ],
                    ['name'=>'Seven' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01'), 'school_id'=>$school_id ],
                    ['name'=>'Eight' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01'), 'school_id'=>$school_id ],
                    ['name'=>'Nine' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01'), 'school_id'=>$school_id ],
                    ['name'=>'Ten' ,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01'), 'school_id'=>$school_id ],
                ];
                $sponsors = [
                    ['name'=>'None','address'=>'','contact_no'=>'','description'=>'','school_id'=>$school_id,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01')],
                    ['name'=>'School','address'=>'','contact_no'=>$school_contact,'description'=>'','school_id'=>$school_id,'created_at'=>Carbon::create('2019', '01', '01') , 'updated_at'=>Carbon::create('2019', '01', '01')]
                ];
                DB::table('classes')->insert($classes);
                DB::table('sponsors')->insert($sponsors);
            }
            return response()->json(['status' => 'success'], 200);
        } 
    }

    public function login(Request $request)
    {
        try{
            $credentials = $request->only('email', 'password');
            if ($token = $this->guard()->attempt($credentials)) {
                return response()->json(['status' => 'success' ,'token'=> $token , 'id' =>Auth::id()] )->header('Authorization', $token);
            }
            return response()->json(['error' => 'login_error'], 401);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function logout()
    {
        try{
            $this->guard()->logout();
            return response()->json([
                'status' => 'success',
                'msg' => 'Logged out Successfully.'
            ], 200);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function user(Request $request)
    {
        try{
            $user = User::find(Auth::user()->id);
            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function refresh()
    {
        try{
            if ($token = $this->guard()->refresh()) {
                return response()
                    ->json(['status' => 'successs'], 200)
                    ->header('Authorization', $token);
            }
            return response()->json(['error' => 'refresh_token_error'], 401);
        } catch (Exception $e) {
            throw $e;
        }
    }
    private function guard()
    {
        try{
             return Auth::guard();
        } catch(Exception $e) {
        throw $e;
        }
}
}
