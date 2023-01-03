<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use App\Models\User;
use App\Models\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;



class UserController extends Controller
{

    public function show($user_id)
    {
        $user = User::find($user_id);
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
        return view('admin.user_list.show', compact('user', 'genders_array', 'designation_array', 'divisions', 'districts', 'upazilas'));
    }

    public function profile()
    {
        $user = User::find(Auth::id());
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

        return view('users.user.show', compact('user', 'genders_array', 'designation_array', 'divisions', 'districts', 'upazilas'));
    }

    public function update(Request $request)
    {
        try {
            $user = User::where('hrs_id', $request->hrs_id)->first();
            if (empty($user)) {
                Toastr::error(__('User Not Found'), '', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
            // $user_unique_email_check = User::where('email',$request->email)->first();
            // if( !empty($user_unique_email_check) && $user_unique_email_check->id != $user->id ){
            //     Toastr::error(__('Already have an account with this email'), '', ["positionClass" => "toast-top-right"]);
            //     return redirect()->back();
            // }

            $user_unique_phone_check = User::where('phone', $request->phone)->first();
            if (!empty($user_unique_phone_check) && $user_unique_phone_check->id != $user->id) {
                Toastr::error(__('Already have an account with this phone'), '', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
            // return $request;
            $request->validate([
                'name'        => 'required|max:255',
                // 'email'       => 'required',
                'phone'       => 'required',
                'hrs_id'      => 'required',
                'gender'      => 'required',
                'age'         => 'required',
                'designation' => 'required',
                'organization' => 'required',
                'division_id' => 'required',
                'district_id' => 'required',
                'upazila_id'  => 'required',
                // 'password'    => 'required_if:change_pass,==,cps|confirmed|min:4',
            ]);
            $password = $request->password ? Hash::make($request->password) : $user->password;
            $user->update([
                'name' => $request->name,
                // 'email' => $request->email,
                'phone' => $request->phone,
                'gender' => (int)$request->gender,
                'age' => $request->age,
                'designation' => $request->designation,
                'organization' => $request->organization,
                'division_id' => (int)$request->division_id,
                'district_id' => (int)$request->district_id,
                'upazila_id' => (int)$request->upazila_id,
                'password' => $password,
            ]);

            Toastr::success('Profile update Success', '', ["positionClass" => "toast-top-right"]);
            return back();
        } catch (Exception $e) {
            return $e;
            Toastr::error('Unsuccessful Update!', '', ["positionClass" => "toast-top-right"]);
            return back();
        }
    }

    public function updateImage(Request $request)
    {
        try {
            $request->validate([
                'photo'        => 'mimes:jpeg,jpg,png,webp|required|max:10000',
            ]);
            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                Toastr::error('User Unauthorized!', '', ["positionClass" => "toast-top-right"]);
                return back();
            }

            $user = User::find($auth_id);
            if (empty($user)) {
                Toastr::error('User Not Found', '', ["positionClass" => "toast-top-right"]);
                return back();
            }

            $exist_file     = $user->photo ?? null;
            $input['photo'] = $user->delete_existing_and_upload_file('photo', $exist_file, $request->photo);
            $user->fill($input);
            $user->save();

            Toastr::success('Image Updated Successfull!', '', ["positionClass" => "toast-top-right"]);
            return back();
        } catch (Exception $e) {
            Toastr::error('Something wrong when upload image!', '', ["positionClass" => "toast-top-right"]);
            return back();
        }
    }
    public function user_list(Request $request)
    {
        $type = $request->type ?? 'inactive';
        $filter_route = 'admin.user.list';
        $filter       = false;
        $query        = User::withSearch()->orderBy('id', 'desc');
        $divisions = Division::orderBy('name', 'asc')->pluck('name', 'id');
        $districts = District::orderBy('name', 'asc')->pluck('name', 'id');
        $upazilas = Upazila::orderBy('name', 'asc')->pluck('name', 'id');
        if ($type == 'Completed') {
            $query->where('last_login_at', '<', Carbon::now()->subDays(90)); //It should be Updated later
        } else if ($type == 'Active') {
            // $query->whereBetween('last_login_at',[Carbon::now()->subDays(30),Carbon::now()]);
        } else if ($type == 'Hybernates') {
            $query->whereBetween('last_login_at', [Carbon::now()->subDays(30), Carbon::now()->subDays(90)]);
        } else if ($type == 'Inactive') {
            $query->where('last_login_at', '<', Carbon::now()->subDays(90));
        }

        //Filtering
        if ($request->division_id != null || $request->division_id != '') {
            $query->where('division_id', $request->division_id);

            $districts = district::orderBy('name', 'asc')->where('division_id', $request->division_id)->pluck('name', 'id');
        }
        if ($request->district_id != null || $request->district_id != '') {
            $query->where('district_id', $request->district_id);

            $upazilas = upazila::orderBy('name', 'asc')->where('district_id', $request->district_id)->pluck('name', 'id');
        }
        if ($request->upazila_id != null || $request->upazila_id != '') {
            $query->where('upazila_id', $request->upazila_id);
        }
        // return $query->get();
        $users = $query->paginate(2);

        return view('admin.user_list.index', compact('users', 'filter_route', 'filter', 'divisions', 'districts', 'upazilas'));
    }

    public function downloadPdf(Request $request)
    {

        $type = $request->type ?? 'inactive';
        $pdf_name = $type . ' Trainees';

        $query        = User::orderBy('id', 'desc');
        if ($type == 'Completed') {
            $query->where('last_login_at', '<', Carbon::now()->subDays(90)); //It should be Updated later
        } else if ($type == 'Active') {
            $query->whereBetween('last_login_at', [Carbon::now()->subDays(30), Carbon::now()]);
        } else if ($type == 'Hybernates') {
            $query->whereBetween('last_login_at', [Carbon::now()->subDays(30), Carbon::now()->subDays(90)]);
        } else if ($type == 'Inactive') {
            $query->where('last_login_at', '<', Carbon::now()->subDays(90));
        }

        //Filtering
        if ($request->division_id != null || $request->division_id != '') {
            $query->where('division', $request->division_id);
        }
        $users = $query->get();

        $pdf = PDF::loadView('admin.user_list.elements.user_pdf', array('users' => $users, 'content_name' => $pdf_name));
        // return view('users.user_list.elements.user_pdf',compact('users'));
        //     return response()->streamDownload(
        //         fn () => print($pdf),
        //         "filename.pdf"
        //    );
        return $pdf->download($pdf_name . '.pdf');
    }

    public function downloadExcel(Request $request)
    {
        return Excel::download(new ExportUser($request->all()), 'users.xlsx');
    }

    public function banned($user_id, Request $request)
    {
        $user = User::find($user_id);

        if (empty($user)) {
            Toastr::error('User Not found!', '', ["positionClass" => "toast-top-right"]);
        }

        $user->has_any_banned_record = 1;
        $user->save();

        Toastr::success('User Banned Successfull!', '', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function un_banned($user_id, Request $request)
    {
        $user = User::find($user_id);

        if (empty($user)) {
            Toastr::error('User Not found!', '', ["positionClass" => "toast-top-right"]);
        }

        $user->has_any_banned_record = 0;
        $user->save();

        Toastr::success('Remove Banned Successfull!', '', ["positionClass" => "toast-top-right"]);
        return back();
    }

    public function destroy($user_id, Request $request)
    {
        $user = User::find($user_id);

        if (empty($user)) {
            Toastr::error('User Not found!', '', ["positionClass" => "toast-top-right"]);
        }

        $user->delete();

        Toastr::success('User Deleted Successfull!', '', ["positionClass" => "toast-top-right"]);
        return back();
    }
}
