<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Admin;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        return view('users.front_page.index');
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function login(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::check()) {
            return redirect()->route('user.index');
        }
        if ($request->query('enroll')) {
            Toastr::error('Please login First', '', ["positionClass" => "toast-top-right"]);
        }
        return view('auth.login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function loginInUser(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'hrs_id'       => 'required',
            'password'     => 'required|min:4',
        ]);

        // Attempt to log the user in\
        $user = User::where('hrs_id', $request->hrs_id)->first();

        if (empty($user)) {
            Toastr::error('User Can not found', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
        if ($user->has_any_banned_record) {
            Toastr::error('You are in the banned list', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        if (!$user->has_any_banned_record && Auth::attempt(['hrs_id' => $request->hrs_id, 'password' => $request->password])) {

            // $user = User::find(Auth::id());
            $user->update([
                'last_login_at' => Carbon::now()
            ]);

            return redirect()->route('user.index');
        }
        return redirect()->back()->withInput($request->only('hrs_id'));
    }

    public function userRegistrationPage(Request $request)
    {
        $genders_array = Setting::genders_array();
        $designation_array = Setting::designation_array();
        if (Session('APP_LOCALE') == 'en') {
            $divisions = Division::where('status', 1)->orderBy('name', 'asc')->pluck('name', 'id');
            $districts = District::where('status', 1)->orderBy('name', 'asc')->pluck('name', 'id');
            $upazilas = Upazila::where('status', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        } else {
            $divisions = Division::where('status', 1)->orderBy('name', 'asc')->pluck('bn_name', 'id');
            $districts = District::where('status', 1)->orderBy('name', 'asc')->pluck('bn_name', 'id');
            $upazilas = Upazila::where('status', 1)->orderBy('name', 'asc')->pluck('bn_name', 'id');
        }
        return view('auth.registration', compact('genders_array', 'designation_array', 'divisions', 'districts', 'upazilas'));
    }

    public function registerUser(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'name'        => 'required|max:255',
            // 'email'       => 'required|unique:users',
            'phone'       => 'required|unique:users',
            'hrs_id'      => 'required|unique:users',
            'gender'      => 'required',
            'age'         => 'required',
            'designation' => 'required|max:255',
            'organization' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
            'upazila_id'  => 'required',
            'password'    => 'required|confirmed|min:4',
        ]);
        User::create([
            'name' => $request->name,
            // 'email' => $request->email,
            'phone' => $request->phone,
            'hrs_id' => $request->hrs_id,
            'gender' => (int)$request->gender,
            'age' => $request->age,
            'designation' => $request->designation,
            'organization' => $request->organization,
            'division_id' => (int)$request->division_id,
            'district_id' => (int)$request->district_id,
            'upazila_id' => (int)$request->upazila_id,
            'password' => Hash::make($request->password),
            'last_login_at' => Carbon::now(),
        ]);

        Toastr::success('Registration Success', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('login');
    }

    /**
     * @return RedirectResponse
     */
    public function logoutUser()
    {
        // return Auth::user();
        Auth::logout();
        return redirect()->route('user.index');
    }

    /**
     * @param $locale
     * @return RedirectResponse
     */
    public function changeLocale($locale)
    {
        if (!in_array($locale, ['en', 'bn'])) {
            abort(400);
        }
        session(['APP_LOCALE' => $locale]);
        app()->setLocale($locale);
        // Toastr::success(__('Language changed successfully'), '', ["positionClass" => "toast-bottom-left"]);
        return redirect()->back();
    }


    public function adminLoginPage()
    {
        if (Auth::check()) {
            return redirect()->route('user.index');
        }
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.admin.login');
    }


    public function adminLogin(Request $request)
    {

        $admin = Admin::where('email', $request->email)->active()->first();

        if (empty($admin)) {
            Toastr::error('Login Unsuccessful!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            Toastr::success('Login Successful!', '', ["positionClass" => "toast-top-right"]);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withInput($request->only('email'));
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.page');
    }
}
