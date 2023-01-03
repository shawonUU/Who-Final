<?php

namespace App\Http\Components\Traits;

trait Message{

    protected $status = false;
    protected $message = '';
    protected $api_token = "";
    protected $data = [];

    /**
     * Success  Function For API
     * Set api response status as Success
     * This Method is responsible all API Response
     */
    protected function apiSuccess($message = Null, $data = Null){
        $this->status = true;
        $this->message = !empty($message) ? ( $this->message ?? $message ) : 'Successfully';
        $this->data = $data ?? $this->data;
    }

    /**
     * Return Default API Output Message
     * This Method for API Response
     */
    protected function apiOutput($status_code = 200, $message = ""){
        $content = [
            'status'    => $this->status,
            'message'   => !empty($message) ? $message : $this->message,
            'api_token' => $this->api_token,
            'data'      => $this->data
        ];
        if(empty($this->api_token)){
            unset($content["api_token"]);
        }
        $status_code = $status_code == 0 || !is_numeric($status_code) || $status_code > 500 ? 500 : $status_code;
        return response($content, $status_code);
    }

    /**
     * Get Error Message
     * If Application Environtment is local then
     * Return Error Message With filename and Line Number
     * else return a Simple Error Message
     */
    protected function getError($e = null){
        if( !empty($e) ){
            if($e->getCode() == 400){
                return $e->getMessage();
            }
            if( env("APP_ENV") == "local" ){
                return $e->getMessage() . ' On File ' . $e->getFile() . ' on line ' . $e->getLine();
            }
            return $e->getMessage();
        }
        return 'Something went wrong!';
    }



    /**
     * Get Validation Error
     */
    public function getValidationError($validator){
        return $validator->errors()->first();
    }

}
