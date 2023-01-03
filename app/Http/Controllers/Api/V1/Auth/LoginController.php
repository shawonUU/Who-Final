<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Components\Traits\Message;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    use Message;

    /**
     * Login Request Into System
     * @return User Model Data with Access Token
     */
    public function login(Request $request)
    {
        try {
            // $validator_arr = [
            //     "mobile_no"   => ['required', "digits:11"],
            //     "password"   => ["required", "min:4"],
            // ];

            // $validator = Validator::make($request->all(), $validator_arr);
            // if($validator->fails()){
            //     $this->apiOutput(400, $this->getValidationError($validator));
            // }

            /**
             * Login Using phone & Password
             */

            return $this->loginUsingHRS($request);
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }


    /**
     * Login Using Phone Number
     */
    protected function loginUsingHRS($request)
    {


        $user = User::with(['division', 'district', 'upazila'])->where("hrs_id", $request->hrs_id)->first();
        if (empty($user)) {
            return $this->apiOutput(400, 'User Not Found');
        }

        if (Auth::attempt(['hrs_id' => $request->hrs_id, 'password' => $request->password])) {

            $this->api_token = $user->createToken('myApp')->plainTextToken;
            $this->data["user"] = (new UserResource($user));
            $this->apiSuccess();

            return $this->apiOutput(200, 'Login Succsessful');
        } else {
            return $this->apiOutput(400, 'Login Failed!');
        }
    }


    /**
     * Login Using Phone Number
     */
    protected function loginUsingEmail($request)
    {


        $user = User::with(['division', 'district', 'upazila'])->where("email", $request->email)->orWhere("email", "like", '%' . $request->email)->first();
        if (empty($user)) {
            return $this->apiOutput(400, 'User Not Found');
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $this->api_token = $user->createToken('myApp')->plainTextToken;
            $this->data["user"] = (new UserResource($user));
            $this->apiSuccess();

            return $this->apiOutput(200, 'Login Succsessful');
        } else {
            return $this->apiOutput(400, 'Login Failed!');
        }
    }

    public function guestRregistration(Request $request)
    {
        try {
            // return $request;
            //    $validated = $request->validate([
            //     'user_name'   => 'required|unique:users|max:255',
            //     'name'        => 'required',
            //     'email'       => 'required|unique:users',
            //     'gender'      => 'required',
            //     'age'         => 'required',
            //     'designation' => 'required',
            //     'institution' => 'required',
            //     'division_id' => 'required',
            //     'district_id' => 'required',
            //     'upazila_id'  => 'required',
            //     'password'    => 'required|confirmed|min:4',
            // ]);
            $has_hrs_id = User::where('hrs_id', $request->hrs_id)->first();
            if (!empty($has_hrs_id)) {
                return $this->apiOutput(400, 'This HRS Id already used another account!!');
            }

            // $user_by_email = User::where('email',$request->email)->first();
            $user_by_phone = User::where('phone', $request->phone)->first();

            // if( !empty($user_by_email) && !empty($user_by_phone) ){
            //     return $this->apiOutput(400, 'This email and phone is used another account!');
            // }

            // if( !empty($user_by_email) ){
            //     return $this->apiOutput(400, 'This email is used another account!');
            // }

            if (!empty($user_by_phone)) {
                return $this->apiOutput(400, 'This phone is used another account!');
            }
            User::create([
                'hrs_id' => $request->hrs_id,
                'name' => $request->name,
                'phone' => $request->phone,
                // 'email' => $request->email,
                'gender' => (int)$request->gender,
                'age' => $request->age,
                'designation' => $request->designation,
                'organization' => $request->organization,
                'division_id' => (int)$request->division_id,
                'district_id' => (int)$request->district_id,
                'upazila_id' => (int)$request->upazila_id,
                'password' => Hash::make($request->password),
            ]);
            $user = User::with(['division', 'district', 'upazila'])->where("hrs_id", $request->hrs_id)->first();
            if (empty($user)) {
                return $this->apiOutput(400, 'User Can not created!');
            }

            $this->apiSuccess();
            $this->data["user"] = (new UserResource($user));
            return $this->apiOutput(200, 'User registration Succsessful');
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }


    /**
     * Profile Logout
     */

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $request->user()->currentAccessToken()->delete();
            $this->apiSuccess();
            return $this->apiOutput(200, "Logout Successfully");
        } catch (Exception $e) {
            return $this->apiOutput($e->getCode(), $this->getError($e));
        }
    }
}
