<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    // public $table = 'divisions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $upload_path = 'uploads/divisions';

    public $search_fields = [
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
        'id'      => 'integer',
        'name'    => 'string',
        'bn_name' => 'string',
        'url'     => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name'       => 'required|string|max:25',
        'bn_name'    => 'required|string|max:25',
        'url'        => 'required|string|max:50',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function districts() {
        return $this->hasMany( \App\Models\District::class, 'division_id' );
    }
}
