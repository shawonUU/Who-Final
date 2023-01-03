<?php

namespace App\Http\Components\Traits;

use App\Http\Components\Helpers\BengaliHelper;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Components\Traits\Message;

trait ValidateApiTrait
{

    use Message;

    public function validateApiRequest(Request $request, $model, $action = 'create'){
        $rules = $action == 'create' ? $model::$rules : $model::$update_rules;

        $validated = Validator::make($request->all(), $rules);
        
        $response = [];

        if($validated->fails()){
            $response = $validated->errors();
        }
        
        return $response;
    }


    public function checkDropdownValueExists($model){
        $array_names = $model::$setting_dropdowns_arrays;
        $fields = $model::$setting_dropdowns_fields;

        $checkKeys = Setting::check_keys_exists($array_names, $fields);

        return $this->add_comma_no_underscore($checkKeys);
    }

    public function checkForeignValuesExists($model){
        $foreign_models = $model::$foreign_models;
        $foreign_ids = $model::$foreign_ids;
        $empty_fields = [];

        foreach($foreign_models as $key => $foreign_model){
            $return_field = $this->checkForeignValueExists($foreign_model, $foreign_ids[$key]);
            
            if($return_field != ""){
                $empty_fields[$return_field] = $return_field;
            }            
        }

        return $this->add_comma_no_underscore($empty_fields);
    }

    public function checkForeignValueExists($model, $field){

        $empty_field = "";
        $check_row_found = $model::find(request()->$field);

        if(empty($check_row_found)){
            $empty_field = $field;
        }

        return $empty_field;
    }

    public function apiActionMessage($item_name, $action){
        return $item_name.' data is'.$action;
    }

    public function apiDatumRequired($item_name){
        return $this->apiActionMessage($item_name, ' required');
    }

    public function apiDataRequired($items = []){
        $item_names = [];
        foreach($items as $key => $item){
            $item_names[$key] = $this->add_comma_no_underscore($item);
        }

        return $this->apiDatumRequired($item_names);
    }


    public function apiDataNotAuthorized($message = null){
        return 'Sorry, you are not authorized'.$message;
    }


    public function apiDataListed($item_name){
        return $this->apiActionMessage($item_name, ' listed');
    }

    public function apiDataShown($item_name){
        return $this->apiActionMessage($item_name, ' shown');
    }

    public function apiDataInserted($item_name, $reverse = ""){
        return $this->apiActionMessage($item_name, $reverse.' inserted');
    }

    public function apiDataUpdated($item_name, $reverse = ""){
        return $this->apiActionMessage($item_name, $reverse.' updated');
    }

    public function apiDataDeleted($item_name, $reverse = ""){
        return $this->apiActionMessage($item_name, $reverse.' deleted');
    }


    
    public function apiDataNotInserted($item_name){
        $this->apiDataInserted($item_name, "not");
    }

    public function apiDataNotUpdated($item_name){
        $this->apiDataUpdated($item_name, "not");
    }

    public function apiDataNotDeleted($item_name){
        $this->apiDataDeleted($item_name, "not");
    }

    
    public function apiNoDataError($item_name){
        return $item_name.' data not found!';
    } 

    public function add_comma_no_underscore($string){
        // return $string;
        return str_replace('_', ' ', implode(', ', $string));
    }


    public function show_ranges_list($start = 1, $end = 2, $lan = null){
        $ranges = [];

        foreach(range($start, $end) as $key => $range){
            if($lan == 'en'){
                $ranges[$key] = $range;
            }else{
                $ranges[$key] = ['en' => $range, 'bn' => BengaliHelper::bn_number($range)];
            }
        }

        return $ranges;
    }

    public function show_ranges_list_en($start, $end){
        return $this->show_ranges_list($start, $end, 'en');
    }


    public function get_authorized_user()
    {
        // auth()->user();
        $header_token = request()->user()->currentAccessToken()->token;
        $access_token = PersonalAccessToken::where('token', $header_token);
        if($access_token->count() != 1){
            return $this->apiOutput(400, 'Token mismatch!');
        }
        $access_token_user = $access_token->first()->tokenable();
        if($access_token_user->count() != 1){
            return $this->apiOutput(400, 'No user for this token!');
        }

        return $access_token_user->first();
    }

    public function get_auth_model(){
        $header_token   = request()->user()->currentAccessToken()->token;
        $access_token     = PersonalAccessToken::where('token', $header_token);

        if($access_token->count() != 1){
            return $this->apiOutput(400, 'Token mismatch');
        }

        return $access_token->first();
    }

    public function check_setting_array_key_exists($array_title, $index){
        
        $data = Setting::get_data_by_index($array_title, $index);
        
        if($data == null){
            return $this->apiOutput(400, $this->apiNoDataError('Cycle'));
        }

        return null;
    }

    public function check_model_id_exists($model, $id){
        
        $data = $model::find($id);
        
        if(empty($data)){
            return $this->apiOutput(400, $this->apiNoDataError($model::$model_title));
        }

        return null;

    }

    public function check_authorized_for_action($model, $id, $center_id){
        $model_center_id = $model::findOrFail($id)->center_id;
        
        return $model_center_id == $center_id ? true:false;

    }

    public function show_required_fields($fields = null){
        return $this->apiOutput(400, "Required fields are ".implode( ', ', $fields));
    }

    public function check_null($condition, $item_name){
        return $condition == null ? $this->apiOutput(400, $this->apiNoDataError($item_name)):'';
    }

    public function check_empty($condition, $item_name){
        return empty($condition) ? $this->apiOutput(400, $this->apiNoDataError($item_name)):'';
    }

}
