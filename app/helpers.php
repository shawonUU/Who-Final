<?php

use App\User;

if (! function_exists('setting')) {

    function setting($key, $default = null)
    {
        if (is_null($key)) {
            return new \App\Setting();
        }

        if (is_array($key)) {
            return \App\Setting::set($key[0], $key[1]);
        }

        $value = \App\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
}


function if_its_edit_route($segment = null){
	// If you only know it's the last segment

	if($segment){// if you know the segment postion
		$segment = (int) $segment;
		$param = request()->segment($segment);
	} else { // if you don't know got the last segment
		$segments = request()->segments();
	    $param = array_pop($segments);
	}
    if($param == 'edit'){
    	return true;
    }
    return false;
}

function date_en_to_bn($currentDate){
    // $currentDate = date("l, F j, Y");

    $engDATE = array('1','2','3','4','5','6','7','8','9','0','January','February','March','April',
    'May','June','July','August','September','October','November','December','Saturday','Sunday',
    'Monday','Tuesday','Wednesday','Thursday','Friday');
    $bangDATE = array('১','২','৩','৪','৫','৬','৭','৮','৯','০','জানুয়ারী','ফেব্রুয়ারী','মার্চ','এপ্রিল','মে',
    'জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর','শনিবার','রবিবার','সোমবার','মঙ্গলবার','
    বুধবার','বৃহস্পতিবার','শুক্রবার' 
    );
    $convertedDATE = str_replace($engDATE, $bangDATE, $currentDate);
    return $convertedDATE;
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

function clean_and_limit($string, $limit=100){
	$string = clean($string);
	$limit = \Illuminate\Support\Str::limit($string, $limit, $end='');
	return $limit;
}

/**
 * @return int
 */
function getLoggedInUserId()
{
    return Auth::id();
}

/**
 * @return User
 */
function getLoggedInUser()
{
    return Auth::user();
}

/**
 * return avatar full url.
 *
 * @param  int  $userId
 * @param  string  $name
 *
 * @return string
 */
function getUserImageInitial($userId, $name)
{
    return getAvatarUrl()."?name=$name&size=30&rounded=true&color=fff&background=".getRandomColor($userId);
}

/**
 * return avatar url.
 *
 * @return string
 */
function getAvatarUrl()
{
    return 'https://ui-avatars.com/api/';
}

/**
 * Generate Unique key
 *
 * @return string
 */
function generateUniqueKey()
{
    return substr(md5(uniqid(rand(), true)), 0, 16);
}

/**
 * return random color.
 *
 * @param  int  $userId
 *
 * @return string
 */
function getRandomColor($userId)
{
    $colors = ['329af0', 'fc6369', 'ffaa2e', '42c9af', '7d68f0'];
    $index = $userId % 5;

    return $colors[$index];
}

// if (! function_exists('setting')) {


	function current_domain(){
		$protocol =  stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
		$domainName = $_SERVER['HTTP_HOST'];
		return $protocol . $domainName;
	    // $pu = parse_url($_SERVER['REQUEST_URI']);
	    // return $pu["scheme"] . "://" . $pu["host"];
	}

    function my_setting($key, $default = null)
    {
        if (is_null($key)) {
            return new \App\Setting();
        }

        if (is_array($key)) {
            return \App\Setting::set($key[0], $key[1]);
        }

        $value = \App\Setting::get($key);

        return is_null($value) ? value($default) : $value;
    }
// }

function displayArrayRecursively($arr, $indent='') {
    if ($arr) {
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                //
                displayArrayRecursively($value, $indent . '&nbsp;&nbsp;');
            } else {
            	if($key == 'id'){
            		echo '<li>' . $indent . '<label><input value="'.$arr[$key].'" type="checkbox" name="post_category[]" checked="checked">'.$arr['name'].'</label></li>';
	                // echo "$indent $value <br />";
            	}
            }
        }
    }
}


// function displayArrayRecursively($array)
// {
//     // Loops through each element. If element again is array, function is recalled. If not, result is echoed.
//     foreach ($array as $key => $value)
//     {
//         if (is_array($value))
//         {
//             displayArrayRecursively($value); // Or
//             // traverseArray($value);
//         }
//         else
//         {
//             echo $key . " = " . $value . "<br />\n";
//         }
//     }
// }

function limitString($string, $limit = 100) {
    // Return early if the string is already shorter than the limit
    if(strlen($string) < $limit) {return $string;}

    $regex = "/(.{1,$limit})\b/";
    preg_match($regex, $string, $matches);
    return $matches[1];
}

function pr($print, $die=false){
	echo "<pre>";
	print_r($print);
	echo "</pre>";
	if($die) die();
}

function on_bdt($amount, $raw=false){
	if(!$amount){
		return '৳' . 0;
	}
	return '৳' . number_format($amount, 2);
}

function get_youtube_id_via_link($url){
	parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
	return $my_array_of_vars['v'];    
}

function remove_dots($string){
	return str_replace(".", "", $string);
}
function replace_hyphen_with_spaces($string){
	return str_replace(' ', '-', $string);
}
function replace_underscore_with_spaces($string){
	return str_replace(' ', '_', $string);
}

function remove_space_dots_replace_underscore($string){
	$lower_case     = strtolower($string);
	$remove_dots    = remove_dots($lower_case);
	$remove_space   = replace_underscore_with_spaces($remove_dots);
	return $remove_space;
}
function remove_space_dots_replace_hyphen($string){
	$lower_case = strtolower($string);
	$remove_dots = remove_dots($lower_case);
	$remove_space = replace_hyphen_with_spaces($remove_dots);
	return $remove_space;
}

function formated_date($date){
	return \Carbon\Carbon::parse($date)->toFormattedDateString();
}

function formated_date_bangla($date){
    $date = \Carbon\Carbon::parse($date)->format('d-m-Y');
    return date_en_to_bn($date);
}
?>
