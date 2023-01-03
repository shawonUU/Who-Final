<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $filter_route = 'admin.dashboard';
        $filter = false;
        $divisions = Division::orderBy('name', 'asc')->pluck('name', 'id');
        $districts = District::orderBy('name', 'asc')->pluck('name', 'id');
        $upazilas = Upazila::orderBy('name', 'asc')->pluck('name', 'id');

        $course_id = $request->query('course_id') ?? (Course::orderBy('id', 'asc')->first()->id  ?? null); // Get first created project as default becasue this project is only for a project at this moment
        $user_who_enrolls = CourseEnrollment::where('course_id', $course_id)->pluck('user_id');
        $user_query = User::with(['certificates', 'course_enrollments'])->orderBy('id', 'asc');

        if ($request->query('division_id')) {
            $user_query->where('division_id', $request->query('division_id'));
        }

        if ($request->query('district_id')) {
            $user_query->where('district_id', $request->query('district_id'));
        }

        if ($request->query('upazila_id')) {
            $user_query->where('upazila_id', $request->query('upazila_id'));
        }

        $data['total_registered_user'] = $user_query->count() ?? 0;
        $completed_user_ids = Certificate::where('course_id', $course_id)->pluck('user_id')->toArray(); // who completed module and quiz
        $not_completed_user_query = $user_query->whereNotIn('id', $completed_user_ids)->orderBy('id', 'asc');

        $total_enroll_user = $user_query->whereIn('id', $user_who_enrolls)->count();

        $data['total_completed']            = count($completed_user_ids) ?? 0;
        $data['total_certificate_download'] = Certificate::where('user_id', $completed_user_ids)->where('certificate', 1)->count();
        $data['total_hybernate_user']       = User::whereBetween('last_login_at', [Carbon::now()->subDays(30), Carbon::now()->subDays(90)])->count() ?? 0;
        $data['total_inactive_user']        = User::where('last_login_at', '<', Carbon::now()->subDays(90))->count() ?? 0;
        $data['total_active_user']          = ($total_enroll_user - ($data['total_completed'] + $data['total_hybernate_user'] + $data['total_inactive_user']));


        $user_status_piechart               = $this->user_status_piechart($data);
        // return $user_status_piechart;
        return view('dashboard.admin.dashboard', compact('divisions', 'districts', 'upazilas', 'filter_route', 'filter', 'data', 'user_status_piechart'));
    }


    public function admin_list(Request $request)
    {
        // return $request;
        $auth_id      = Auth::guard('admin')->id();
        $type         = $request->type ?? 'viewer';
        $filter_route = 'admin.admin_list';
        $filter       = false;
        $admins       = Admin::withSearch()->where('type', $type)->where('id', '!=', $auth_id)->paginate(10);
        return view('admin.admins.index', compact('admins', 'filter_route', 'filter'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $type = $request->type ?? 'viewer';

        $validated = $request->validate([
            'name'                => 'required|max:255',
            'email'               => 'unique:admins|email|required',
            'password'            => 'required',
            'type'                => 'required'
        ]);

        $input                   = $request->except('password', 'type');
        $input['type']           = $type;
        $input['password']       = Hash::make($request->password);

        Admin::create($input);


        Toastr::success($type . ' created successfull', '', ["positionClass" => "toast-top-right"]);
        return redirect()->route('admin.list', ['type' => $type]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|max:255',
            'email'               => 'email|required',
            'type'                => 'required'
        ]);
        if ($request->password == $request->confirm_password) {
            $user = Admin::where('email', $request->email)->first();
            if (!empty($user) && $user->id != $request->id) {
                Toastr::error(__('Already have an account with this email'), '', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
            $email = $request->email ? $request->email : $user->email;
            // $phone = $request->phone ? $request->phone : $user->phone;
            $password = $request->password ? Hash::make($request->password) : $user->password;
            $type = $request->type ?  $request->type : $user->type;
            $status = $request->status ?  $request->status : $user->status;
            $admin = $user->update([
                'name' => $request->name,
                'email' => $email,
                'type' => $type,
                'status' => $status,
                // 'phone' => $phone,
                'password' => $password,
            ]);
            Toastr::success(__('Info updated successfully'), '', ["positionClass" => "toast-top-right"]);
        } else {
            Toastr::error(__('Both Password aren\'t match'), '', ["positionClass" => "toast-top-right"]);
        }
        return redirect()->back();
    }

    public function show(Request $request, $admin_id)
    {
        $admin = Admin::find($admin_id);
        if (empty($admin)) {
            Toastr::error('Admin/Viewer not found', '', ["positionClass" => "toast-top-right"]);
            return back();
        }
        return view('admin.admins.show', compact('admin'));
    }

    public function profile()
    {
        $auth_id = Auth::guard('admin')->id();
        $admin_info = Admin::find($auth_id);
        if (empty($admin_info)) {
            Toastr::error('Admin/Viewer not found', '', ["positionClass" => "toast-top-right"]);
            return back();
        }
        return view('admin.profile.show', compact('admin_info'));
    }

    public function destroy($admin_id)
    {

        $admin = Admin::find($admin_id);
        $admin->delete();
        return back();
    }

    public function user_status_piechart($data)

    {
        $statistics = [["Task", "User"]];
        if ($data['total_completed'] + $data['total_hybernate_user'] +  $data['total_inactive_user'] + $data['total_active_user'] == 0) {
            return $statistics;
        }

        $arr   = ['Completed', $data['total_completed']];
        array_push($statistics, $arr);

        $arr   = ['Active', $data['total_active_user']];
        array_push($statistics, $arr);

        $arr   = ['Hybernate', $data['total_hybernate_user']];
        array_push($statistics, $arr);

        $arr   = ['Inactive', $data['total_inactive_user']];
        array_push($statistics, $arr);

        return $statistics;
    }
}
