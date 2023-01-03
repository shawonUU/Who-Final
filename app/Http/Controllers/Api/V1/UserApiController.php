<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Components\Traits\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{
    use Message;
    public function profile()
    {
        try {
            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $user = User::find($auth_id);
            if (empty($user)) {
                return $this->apiOutput(400, 'User Not Found');
            }

            $this->data["user"] = (new UserResource($user));
            $this->apiSuccess();

            return $this->apiOutput(200, 'User Profile');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }

    public function profile_update(Request $request)
    {
        try {

            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $user = User::find($auth_id);
            if (empty($user)) {
                return $this->apiOutput(400, 'User Not Found');
            }

            // $user_by_email = User::where('email',$request->email)->first();
            $user_by_phone = User::where('phone', $request->phone)->first();

            // if( ($auth_id != $user_by_email->id) && ($auth_id != $user_by_phone->id) ){
            //     return $this->apiOutput(400, 'This email and phone is used another account!');
            // }

            // if($auth_id != $user_by_email->id){
            //     return $this->apiOutput(400, 'This email is used another account!');
            // }

            if (!empty($user_by_phone) && $auth_id != $user_by_phone->id) {
                return $this->apiOutput(400, 'This phone is used another account!');
            }
            $user->name         = $request->name;
            $user->phone        = $request->phone;
            // $user->email        = $request->email;
            $user->gender       = (int)$request->gender;
            $user->age          =  $request->age;
            $user->designation  =  $request->designation;
            $user->organization = $request->organization;
            $user->division_id  = (int)$request->division_id;
            $user->district_id  = (int)$request->district_id;
            $user->upazila_id   =  (int)$request->upazila_id;

            $user->save();

            $this->apiSuccess();
            $this->data['user'] = (new UserResource($user));
            return $this->apiOutput(200, 'User updated Succsessful');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }

    public function profile_photo_update(Request $request)
    {
        try {
            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $user = User::find($auth_id);
            if (empty($user)) {
                return $this->apiOutput(400, 'User Not Found');
            }

            $exist_file     = $user->photo ?? null;
            $input['photo'] = $user->delete_existing_and_upload_file('photo', $exist_file, $request->photo);

            $user->fill($input);
            $user->save();

            $this->apiSuccess();
            $this->data['photo'] = $user->getProfileImage() ?? null;
            return $this->apiOutput(200, 'Image Upload Successfull!');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }

    public function change_password(Request $request)
    {
        try {
            // dd('Testing');

            $auth_id = Auth::id();
            if ($auth_id == null || !$auth_id) {
                return $this->apiOutput(401, 'User UnAuthorized');
            }

            $user = User::find($auth_id);
            if (empty($user)) {
                return $this->apiOutput(400, 'User Not Found');
            }

            $password_hash = $user->password;
            $old_password  = $request->old_password;

            if (!Hash::check($old_password, $password_hash)) {
                return $this->apiOutput(400, 'Old password is not matched!');
            }

            $user->password  = Hash::make($request->password);
            $user->save();

            //    $this->data['user'] = (new UserResource($user));
            $this->apiSuccess();
            return $this->apiOutput(200, 'Password Change successful!');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }
}
