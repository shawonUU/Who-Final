<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected static $logName = "Setting";

    public static function designation_array() {
        return [
            1 => ['en' => 'Medical Doctor', 'bn' => 'ডাক্তার', 'key' => 1],
            2 => ['en' => 'Nurse', 'bn' => 'নার্স', 'key' => 2],
            3 => ['en' => 'Student', 'bn' => 'শিক্ষার্থী', 'key' => 3],
            4 => ['en' => 'Other', 'bn' => 'অন্যান্য', 'key' => 4],
        ];
    }

    public static function course_category() {
        return [
            1 => ['en' => 'Nutrition', 'bn' => 'পুষ্টি', 'key' => 1],
        ];
    }


    public static function genders_array() {
        return [
            1 => ['en' => 'Male', 'bn' => 'পুরুষ', 'key' => 1],
            2 => ['en' => 'Female', 'bn' => 'মহিলা', 'key' => 2],
            3 => ['en' => 'Other', 'bn' => 'অন্যান্য', 'key' => 3],
        ];
    }

    public static function months_array() {
        return [
            1  => ['en' => 'January', 'bn' => 'জানুয়ারি', 'key' => 1],
            2  => ['en' => 'February', 'bn' => 'ফেব্রুয়ারি', 'key' => 2],
            3  => ['en' => 'March', 'bn' => 'মার্চ', 'key' => 3],
            4  => ['en' => 'April', 'bn' => 'এপ্রিল', 'key' => 4],
            5  => ['en' => 'May', 'bn' => 'মে', 'key' => 5],
            6  => ['en' => 'June', 'bn' => 'জুন', 'key' => 6],
            7  => ['en' => 'July', 'bn' => 'জুলাই', 'key' => 7],
            8  => ['en' => 'August', 'bn' => 'আগস্ট', 'key' => 8],
            9  => ['en' => 'September', 'bn' => 'সেপ্টেম্বর', 'key' => 9],
            10 => ['en' => 'October', 'bn' => 'অক্টোবর', 'key' => 10],
            11 => ['en' => 'November', 'bn' => 'নভেম্বর', 'key' => 11],
            12 => ['en' => 'December', 'bn' => 'ডিসেম্বর', 'key' => 12],
        ];
    }

    public static function religions_array() {
        return [
            10 => ['en' => 'Islam', 'bn' => 'ইসলাম', 'key' => 10],
            20 => ['en' => 'Hindu', 'bn' => 'হিন্দু', 'key' => 20],
            30 => ['en' => 'Budist', 'bn' => 'বৌদ্ধ', 'key' => 30],
            40 => ['en' => 'Christian', 'bn' => 'খ্রিষ্টান', 'key' => 40],
        ];
    }


    public static function marital_status_array() {
        return [
            1 => ['en' => 'Married', 'bn' => 'বিবাহিত', 'key' => 1],
            2 => ['en' => 'Unmarried', 'bn' => 'অবিবাহিত', 'key' => 2],
            3 => ['en' => 'Widowed', 'bn' => 'বিধবা', 'key' => 3],
        ];
    }

    public static function employment_status_array() {
        return [
            10 => ['en' => 'Active', 'bn' => 'সক্রিয়', 'key' => 10],
            20 => ['en' => 'Replaced', 'bn' => 'প্রতিস্থাপিত', 'key' => 20],
            30 => ['en' => 'Resigned', 'bn' => 'পদত্যাগ করেছেন', 'key' => 30],
        ];
    }

    public static function employee_assigned_or_not_array() {
        return [
            1 => ['en' => 'Assigned', 'bn' => '', 'key' => 1],
            2 => ['en' => 'Not Assigned', 'bn' => '', 'key' => 2],
        ];
    }


    public static function yes_no_array() {
        return [
            1 => ['en' => 'yes', 'bn' => 'হ্যাঁ', 'key' => 1],
            2 => ['en' => 'no', 'bn' => 'না', 'key' => 2],
        ];
    }


    public static function days_array() {
        return [
            1 => ['en' => 'Saturday', 'bn' => 'শনিবার', 'key' => 1],
            2 => ['en' => 'Sunday', 'bn' => 'রবিবার', 'key' => 2],
            3 => ['en' => 'Monday', 'bn' => 'সোমবার', 'key' => 3],
            4 => ['en' => 'Tuesday', 'bn' => 'মঙ্গলবার', 'key' => 4],
            5 => ['en' => 'Wednesday', 'bn' => 'বুধবার', 'key' => 5],
            6 => ['en' => 'Thursday', 'bn' => 'বৃহস্পতিবার', 'key' => 6],
            7 => ['en' => 'Friday', 'bn' => 'শুক্রবার', 'key' => 7],
        ];
    }

    public static function education_qualification_array() {
        return [
            1 => ['en' => 'Illiterate', 'bn' => 'নিরক্ষর', 'key' => 1],
            2 => ['en' => 'Grade 5 Pass', 'bn' => '৫ম শ্রেণী পাশ', 'key' => 2],
            3 => ['en' => 'Grade 8 Pass', 'bn' => '৮ম শ্রেণী পাস', 'key' => 3],
            4 => ['en' => 'SSC / Equivalent', 'bn' => 'এসএসসি / সমমান', 'key' => 4],
            5 => ['en' => 'HSC / Equivalent', 'bn' => 'এইচএসসি / সমমান', 'key' => 5],
            6 => ['en' => 'Diploma / Equivalent', 'bn' => 'ডিপ্লোমা / সমমান', 'key' => 6],
            7 => ['en' => 'Degree / Equivalent', 'bn' => 'ডিগ্রি / সমমান', 'key' => 7],
            8 => ['en' => 'Masters / Equivalent', 'bn' => 'মাস্টার্স / সমমান', 'key' => 8],
            9 => ['en' => 'Literate', 'bn' => 'শিক্ষিত', 'key' => 9],
        ];
    }

    public static function disability_types_array() {
        return [
            1 => ['en' => 'Speech impaired', 'bn' => 'বাক প্রতিবন্ধী', 'key' => 1],
            2 => ['en' => 'Visually impaired', 'bn' => 'দৃষ্টিশক্তিহীন', 'key' => 2],
            3 => ['en' => 'Hearing impaired', 'bn' => 'শ্রবণ প্রতিবন্ধী', 'key' => 3],
            4 => ['en' => 'Physically handicapped', 'bn' => 'শারীরিক প্রতিবন্ধী', 'key' => 4],
            5 => ['en' => 'Mentally handicapped', 'bn' => 'মানসিক প্রতিবন্ধী', 'key' => 5],
        ];
    }

    public static function teacher_types_array() {
        return [
            1 => ['en' => 'Regular teacher', 'bn' => 'নিয়মিত শিক্ষক', 'key' => 1],
            3 => ['en' => 'Temporary Teacher', 'bn' => 'অস্থায়ী শিক্ষক', 'key' => 3],
            4 => ['en' => 'Inactive Teacher', 'bn' => 'নিষ্ক্রিয় শিক্ষক', 'key' => 4],
        ];
    }


    public static function array_list_by_element_index( $staticfunction, $index = 'en' ) {
        // for religions
        // self::array_list_by_element_key('religions', 'en');
        $out_array = [];
        foreach ( self::$staticfunction() as $key => $array ) {
            $out_array[$key] = $array[$index];
        }
        return $out_array;
    }

    public static function get_data_by_index( $staticfunction, $index, $lan = 'en', $extra_title = null ) {
        $found = in_array( $index, array_keys( self::$staticfunction() ) );
        if ( !$found ) {
            return null;
        }
        $title_lan = $extra_title . '_' . $lan;
        return $extra_title != null ? self::$staticfunction()[$index][$title_lan] : self::$staticfunction()[$index][$lan];
    }

    public static function get_other_data_by_index( $staticfunction, $index, $lan, $extra_titles = [] ) {
        $data = [];
        if ( empty( $extra_titles ) ) {
            return $data;
        }
        foreach ( $extra_titles as $key => $extra_title ) {
            $title_value = self::get_data_by_index( $staticfunction, $index, $lan, $extra_title );

            $data[$key] = $title_value;
        }
        return $data;
    }
    public static function get_array_by_a_specific_index($staticfunction, $index, $index_value){
        $out_array = [];
        $i=0;
        foreach ( self::$staticfunction() as $key => $array ) {

            if($array[$index]==$index_value)
            $out_array[$i++] = $array;
        }
        return $out_array;

    }

    public static function check_keys_exists( $staticfunctions = [], $indices = [] ) {
        $fields = [];
        if ( empty( $staticfunctions ) || empty( $indices ) ) {
            return false;
        }

        if ( is_array( $staticfunctions ) ) {

            foreach ( $staticfunctions as $key => $fnc ) {

                $get_field = self::check_key_exists( $fnc, $indices[$key] );

                if ( $get_field != "" ) {
                    $fields[$get_field] = $get_field;
                }

            }
        }

        return $fields;
    }

    public static function check_key_exists( $staticfunction, $index ) {
        $key_exists = array_key_exists( request()->$index, self::$staticfunction() );
        $field      = "";

        if ( !$key_exists ) {
            $field = $index;
        }

        return $field;
    }

    public static function get_array_that_return_only_key( $staticfunction, $index = 'key' ) {

        $out_array = [];
        foreach ( self::$staticfunction() as $key => $array ) {
            array_push( $out_array, $array[$index] );
        }
        return $out_array;
    }

    // Array Search With Specific Cloumn Value
    public static function searchWithColumn( $staticfunction, $coloumn, $value ) {
        $data = self::$staticfunction();

        $key = array_search( $value, array_column( $data, $coloumn ) );
        return $data[$key + 1];
    }

    public static function get_array_without_index($array_with_index){
        $remove_indices = [];
        foreach($array_with_index as $array){
            $remove_indices[] = $array;
        }
        return $remove_indices;
    }
}
