<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;

    // public $table = 'unions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $upload_path = 'uploads/unions';

    public $search_fields = [
        'upazilla_id',
        'name',
        'bn_name',
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
        'upazilla_id' => 'integer',
        'name'        => 'string',
        'bn_name'     => 'string',
        'url'         => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'upazilla_id' => 'required|integer',
        'name'        => 'required|string|max:25',
        'bn_name'     => 'required|string|max:25',
        'url'         => 'required|string|max:50',
        'created_at'  => 'nullable',
        'updated_at'  => 'nullable',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function upazilla() {
        return $this->belongsTo( \App\Models\Upazila::class, 'upazilla_id' );
    }
}
