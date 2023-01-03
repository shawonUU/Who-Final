<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginApiDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray( $request ) {
        // return parent::toArray($request);
      
        return [
            'id'                      => $this->id,
            'center_id'               => $this->ce->id ?? null,
            'center_center_id'        => $this->center->center_id ?? null,
            'center_name_en'          => $this->center->name_en ?? null,
            'center_name_bn'          => $this->center->name_bn ?? null,
            'teacher_type-en'         => $teacher_type == null ? null : $teacher_type->name_en,
            'teacher_type-bn'         => $teacher_type == null ? null : $teacher_type->name_bn,
            'teacher_active_status'   => $this->status ?? null,
            'teacher_name_en'         => $this->name ?? null,
            'teacher_name_bn'         => $this->name ?? null,
            'mothers_name_en'         => $this->mothers_name ?? null,
            'mothers_name_bn'         => $this->mothers_name_bn ?? null,
            'fathers_name_en'         => $this->fathers_name ?? null,
            'fathers_name_bn'         => $this->fathers_name_bn ?? null,
            'spouse_name_en'          => $this->spouse_name ?? null,
            'spouse_name_bn'          => $this->spouse_name_bn ?? null,
            'sex'                     => $this->getSex() ?? null,
            'birth_date'              => $this->getBirthDateAttribute( $this->birth_date ) ?? null,
            'religion'                => $this->getReligion() ?? null,
            'marital_status'          => $this->getMaritalStatus() ?? null,
            'division_id'             => $this->division->id ?? null,
            'division_en'             => $this->division->name ?? null,
            'division_bn'             => $this->division->bn_name ?? null,
            'district_id'             => $this->district->id ?? null,
            'district_en'             => $this->district->name ?? null,
            'district_bn'             => $this->district->bn_name ?? null,
            'upazila_id'              => $this->upazila->id ?? null,
            'upazila_en'              => $this->upazila->name ?? null,
            'upazila_bn'              => $this->upazila->bn_name ?? null,
            'union_id'                => $this->union->id ?? null,
            'union_en'                => $this->union->name ?? null,
            'union_bn'                => $this->union->bn_name ?? null,
            'village'                 => $this->village ?? null,
            'education_qualification' => $this->getEducationQualification() ?? null,
            'teacher_experience'      => $this->getTeachingExperience() ?? null,
            'employeement_status'     => $this->getEmployeementStatus() ?? null,
            'leave_status'            => $this->getEmploymentLeaveStatus() ?? null,
            'mobile_no'               => $this->mobile_no ?? null,
            'date_of_joining'         => $this->date_of_joining ?? null,
            'date_of_resign'          => $this->date_of_resign ?? null,
            'bank_account_no'         => $this->bank_account_no ?? null,
            'device_token'            => $this->device_token ?? null,
        ];
    }
}
