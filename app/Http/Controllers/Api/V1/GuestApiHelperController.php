<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Components\Traits\Message;
use App\Models\Setting;
use App\Models\Division;
use App\Models\District;
use App\Models\Union;
use App\Models\Upazila;
use Illuminate\Http\Request;

class GuestApiHelperController extends Controller
{
    use Message;

    public function required_for_registration()
    {
        $data['genders']      = Setting::get_array_without_index(Setting::genders_array());
        $data['designations'] = Setting::get_array_without_index(Setting::designation_array());
        $data['divisions']    = Division::Select('id', 'name')->orderBy('name', 'asc')->get();
        $data['districts']    = District::Select('id', 'name', 'division_id')->orderBy('name', 'asc')->get();
        $data['upazilas']     = Upazila::Select('id', 'name', 'district_id')->orderBy('name', 'asc')->get();

        $this->apiSuccess();
        $this->data = $data;

        return $this->apiOutput(200, 'Registration requirement Array');
    }


    public function geo_list_by_division($division_id)
    {
        try {
            $district_ids = District::where('division_id', $division_id)->where('status', 1)->pluck('id');
            $districts = District::Select('id', 'name', 'division_id')->whereIn('id', $district_ids)->get();
            $this->data['districts'] = $districts;
            $upazilas = Upazila::Select('id', 'name', 'district_id')->whereIn('district_id', $district_ids)->where('status', 1)->get();
            $this->data['upazilas'] = $upazilas;
            $this->apiSuccess();
            return $this->apiOutput(200, 'Geo List!');
        } catch (\Exception $err) {
            return $this->apiOutput($err->getCode(), $this->getError($err));
        }
    }

    public function geo_list_by_district($district_id)
    {
        try {
            $upazilas = Upazila::Select('id', 'name', 'district_id')->where('district_id', $district_id)->get();
            $this->data['upazilas'] = $upazilas;
            // $this->data['unions'] = $unions;
            $this->apiSuccess();
            return $this->apiOutput(200, 'Geo List!');
        } catch (\Exception $err) {
            return $this->apiOutput($err->getCode(), $this->getError($err));
        }
    }


    public function geo_list_by_upazila($upazila_id)
    {
        try {

            $unions = Union::Select('id', 'name', 'upazila_id')->where('upazilla_id', $upazila_id)->get();
            $this->data['unions'] = $unions;
            $this->apiSuccess();
            return $this->apiOutput(200, 'Geo List!');
        } catch (\Exception $err) {
            return $this->apiOutput($err->getCode(), $this->getError($err));
        }
    }
}
