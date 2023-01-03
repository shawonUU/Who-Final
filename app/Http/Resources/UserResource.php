<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'                      => $this->id,
            'hrs_id'                  => $this->hrs_id ?? null,
            'name'                    => $this->name ?? null,
            // 'email'                   => $this->email ?? null,
            'phone'                   => $this->phone ?? null,
            'gender'                  => $this->gender ?? null,
            'gender_name'             => $this->getGender() ?? null,
            'designation'             => $this->designation ?? null,
            // 'designation_name'        => $this->getDesignation() ?? null,
            'age'                     => $this->age ?? null,
            'organization'            => $this->organization ?? null,
            'division_id'             => $this->division_id ?? null,
            'division'                => $this->getDivision() ?? null,
            'district_id'             => $this->district_id ?? null,
            'district'                => $this->getDistrict() ?? null,
            'upazila_id'              => $this->upazila_id ?? null,
            'upazila'                 => $this->getUpazila() ?? null,
            'status'                  => $this->status ?? null,
            'date_of_registration'    => $this->created_at->format('d-m-Y') ?? null,
            'profile_photo'           => $this->getProfileImage() ?? null,
            // 'device_token'            => $this->device_token ?? null,
        ];
    }
}
