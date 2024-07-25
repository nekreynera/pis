<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use App\Role;
use App\Clinic;
use App\User;
use App\Secret;
use App\TblUser;
use App\MedInterns;
use Illuminate\Validation\Rule;
use Validator;
use Auth;
use Session;
use DB;
use Hash;

class UsersController extends Controller
{
        

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            $validator = Validator::make($request->all(), [
                'last_name' => 'required|max:35',
                'first_name' => 'required|max:50',
                'middle_name' => 'nullable|max:35',
                'role' => 'required',
                'username' => 'required|unique:users|max:35',
                'password' => 'required|confirmed|min:6'
            ]);
            if ($validator->passes()) { 
                $user = new User();
                $user->last_name = $request->last_name;
                $user->first_name = $request->first_name;
                $user->middle_name = $request->middle_name;
                $user->clinic = $request->clinic;
                $user->role = $request->role;
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->save();

                $secret = new Secret();
                $secret->users_id = $user->id;
                $secret->secret = Crypt::encryptString($request->password);
                $secret->save();

                if ($request->med_interns == 'yes' && $request->role == '7') {
                    $MedInterns = new MedInterns();
                    $MedInterns->interns_id = $user->id;
                    $MedInterns->save();
                }
                
                
                return redirect()->back()->with('toaster', array('success', 'Registration Successful.'));
            }else{
                return redirect()->back()->withInput()->withErrors($validator);  
            }  

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function theme($theme)
    {
        $user = User::find(Auth::user()->id);
        $user->theme = $theme;
        $user->save();
        Session::flash('toaster', array('info', 'Theme succesfully changed.'));
        return redirect()->back();
    }


    public function register()
    {
        $clinics = Clinic::all();
        $roles = Role::all();
        return view('admin.register', compact('clinics', 'roles'));
    }



    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required'
            ]);
        if ($validator->passes()) {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                if (Auth::user()->activated == 'Y'){
                    // HA DATABASE AMO ININ BASIHAN PARA MASABTAN KUN NAG LOGIN HYA - CALOY ININ NAG UPDATE
                    $user = User::find(Auth::user()->id);
                    $user->updated_at = NOW();
                    $user->save();
                    // END 

                    Session::flash('toaster', array('success', 'Welcome, '.Auth::user()->username.'!'));
                    $user = new User();
                    return $user->checkRole();
                }else{
                    Auth::logout();
                    Session::flash('danger', 'Sorry! your account has been deactivated. Please contact an I.T personnel to reactivate.');
                    return redirect()->route('loginpage');
                }
            }else{
                Session::flash("danger", "These credentials do not match our record's.");
                return redirect()->back()->withInput();
            }
        }else{
            return redirect()->back()->withInput()->withErrors($validator); 
        }
    }




    public function logout(Request $request)
    {
            Cache::forget('active_'.Auth::user()->id);
            if (Auth::user()->role == 7){
                $request->session()->forget(['pid', 'modifier', 'modid', 'cid', 'freshForm']);
            }
            Auth::logout();
            Session::flash('toaster', array('warning', 'You are now logged out.'));
            return redirect()->route('loginpage');
    }



    public function edit_account()
    {
        $user = User::find(Auth::user()->id);
        return view('doctors.account', compact('user'));
    }

    public function registerAccount()
    {
        $user = User::find(Auth::user()->id);
        return view('patients.account', compact('user'));
    }

    public function triageAccount()
    {
        $user = User::find(Auth::user()->id);
        return view('triage.account', compact('user'));
    }

    public function receptionsAccount()
    {
        $user = User::find(Auth::user()->id);
        return view('receptions.account', compact('user'));
    }




    public function update_account(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|max:35',
            'first_name' => 'required|max:50',
            'middle_name' => 'nullable|max:35',
            'username' => [
                    'required',
                    Rule::unique('users')->ignore($id),
            ],
            'password' => 'required|confirmed|min:6',
            'oldPassword' => 'required_with:password',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
        ]);
        if ($validator->passes()){
            if (Hash::check($request->oldPassword, Auth::user()->password)){
                if (isset($request->image)){
                    $image_name = time().'.'.$request->image->getClientOriginalExtension();
                    $request->image->move(public_path('users/'), $image_name);
                }
                $user = User::find($id);
                $user->last_name = $request->last_name;
                $user->first_name = $request->first_name;
                $user->middle_name = $request->middle_name;
                $user->profile = (isset($image_name)? $image_name : null);
                $user->username = $request->username;
                $user->password = bcrypt($request->password);
                $user->save();

                $secret = Secret::where('users_id', '=', $id)->first();
                if ($secret){
                    $secret->users_id = $user->id;
                    $secret->secret = Crypt::encryptString($request->password);
                    $secret->save();
                }
                Session::flash('toaster', array('success', 'Account Successfully Updated.'));
                return redirect()->back();
            }else{
                Session::flash('toaster', array('error', 'Old password is incorrect!'));
                return redirect()->back();
            }
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }



    public function mergeUser()
    {
        $users = TblUser::all();
        foreach ($users as $user){
            $adduser = new User();
            $adduser->id = $user->id;
            $adduser->last_name = $user->last_name;
            $adduser->middle_name = $user->middle_name;
            $adduser->first_name = $user->first_name;
            $adduser->first_name = $user->first_name;
            $adduser->username = $user->username;
            $adduser->password = bcrypt('123456');
            $adduser->save();

            $secret = new Secret();
            $secret->users_id = $user->id;
            $secret->secret = Crypt::encryptString('123456');
            $secret->save();
        }
    }



    public function userlist()
    {
        $users = User::leftJoin('clinics', 'clinics.id', '=', 'users.clinic')
                        ->leftJoin('roles', 'roles.id', '=', 'users.role')
                        ->leftJoin('med_interns', 'med_interns.interns_id', '=', 'users.id')
                        ->select('clinics.name as clinicname', 
                                'roles.description as roledesc', 
                                'med_interns.id as med_interns', 
                                    'users.*', DB::raw("CONCAT(users.first_name,' ',CASE WHEN users.middle_name IS NOT NULL THEN LEFT(users.middle_name, 1) ELSE '' END,'.',' ',users.last_name) as name"))
                        ->orderBy('users.id', 'DESC')
                        // ->groupBy('users.last_name', 'users.first_name', 'users.middle_name')
                        ->get();
        return view('admin.userlist', compact('users'));
    }



    public function editUser($id = false)
    {
        $clinics = Clinic::all();
        $roles = Role::all();
        $user = User::find($id);
        $MedInterns = MedInterns::where('interns_id', '=', $id)->first();
        return view('admin.edituser', compact('user','clinics', 'roles', 'MedInterns'));
    }



    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|max:35',
            'first_name' => 'required|max:50',
            'middle_name' => 'nullable|max:35',
            'username' => [
                'required',
                Rule::unique('users')->ignore($request->uid),
            ]
        ]);
        if ($validator->passes()){
            $user = User::find($request->uid);
            $user->last_name = $request->last_name;
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->clinic = $request->clinic;
            $user->role = $request->role;
            $user->activated = $request->activated;
            $user->username = $request->username;
            if ($request->password != null){
                $user->password = bcrypt($request->password);
            }
            $user->save();

            $secret = Secret::where('users_id', '=', $request->uid)->first();
            if ($secret){
                $secret->users_id = $request->uid;
                if ($request->password != null) {
                    $secret->secret = Crypt::encryptString($request->password);
                }
                $secret->save();
            }
            if ($request->med_interns == 'yes' && $request->role == '7') {
                    $MedInterns = new MedInterns();
                    $MedInterns->interns_id = $user->id;
                    $MedInterns->save();
            }else{
                $MedInterns = MedInterns::where('interns_id', '=', $user->id)->first();
                if ($MedInterns) {
                    $MedInterns->delete();
                }
            }
            return redirect()->back()->with('toaster', array('success', 'User details successfully updated'));
        }else{
            return redirect()->back()->withInput()->withErrors($validator);
        }



    }

    public function changeuserclinic(Request $request)
    {
        Auth::user()->update(['clinic' => $request->clinic_id]);
        $user = User::find(Auth::user()->id);
        $user->clinic = $request->clinic_id;
        $user->save();
        return redirect()->back()->with('toaster', array('success', 'Your assigned clinic successfully changed.'));
    }




}