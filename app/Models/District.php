<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    // public $table = 'districts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $upload_path = 'uploads/districts';

    public $search_fields = [
        'division_id',
        'name',
        'bn_name',
        'lat',
        'lon',
        'url',
    ];

    public $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'division_id' => 'integer',
        'name'        => 'string',
        'bn_name'     => 'string',
        'lat'         => 'string',
        'lon'         => 'string',
        'url'         => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'division_id' => 'required|integer',
        'name'        => 'required|string|max:25',
        'bn_name'     => 'required|string|max:25',
        'lat'         => 'nullable|string|max:15',
        'lon'         => 'nullable|string|max:15',
        'url'         => 'required|string|max:50',
        'created_at'  => 'nullable',
        'updated_at'  => 'nullable',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function division() {
        return $this->belongsTo( \App\Models\Division::class, 'division_id' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function upazilas() {
        return $this->hasMany( \App\Models\Upazila::class, 'district_id' );
    }
}
