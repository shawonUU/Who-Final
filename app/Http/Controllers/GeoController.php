<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;

class GeoController extends Controller
{
        public function getFilteredDistrict($division_id)
        {

                if ($division_id == 0) {
                        if (Session('APP_LOCALE') == 'en')
                                $districts = District::select('id', 'name')->orderBy('name', 'asc')->get();
                        else
                                $districts = District::select('id', 'bn_name as name')->orderBy('name', 'asc')->get();
                } else {
                        if (Session('APP_LOCALE') == 'en')
                                $districts = District::select('id', 'name')->where('division_id', $division_id)->orderBy('name', 'asc')->get();
                        else
                                $districts = District::select('id', 'bn_name as name')->where('division_id', $division_id)->orderBy('name', 'asc')->get();
                }
                return response()->json($districts, 200);
        }


        public function getFilteredUpazila($district_id)
        {

                if ($district_id == 0) {
                        if (session('APP_LOCALE') == 'en')
                                $upazilas = Upazila::select('id', 'name')->orderBy('name', 'asc')->get();
                        else $upazilas = Upazila::select('id', 'bn_name as name')->orderBy('name', 'asc')->get();
                } else {
                        if (session('APP_LOCALE') == 'en')
                                $upazilas = Upazila::select('id', 'name')->where('district_id', $district_id)->orderBy('name', 'asc')->get();
                        else $upazilas = Upazila::select('id', 'bn_name as name')->where('district_id', $district_id)->orderBy('name', 'asc')->get();
                }

                return response()->json($upazilas, 200);
        }
}
