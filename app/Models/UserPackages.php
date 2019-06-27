<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserPackages
 * @package App\Models
 * @version August 3, 2018, 2:39 pm CST
 *
 * @property integer user_id
 * @property integer package_id
 * @property string package_end
 * @property string package_name
 */
class UserPackages extends Model
{
    use SoftDeletes;

    public $table = 'user_packages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'package_id',
        'package_end',
        'package_name',
        'job_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'package_id' => 'integer',
        'package_end' => 'string',
        'package_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
