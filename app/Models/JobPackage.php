<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class JobPackage
 * @package App\Models
 * @version July 30, 2018, 5:11 pm CST
 *
 * @property string job_name
 * @property integer job_id
 * @property integer month
 * @property fload price
 */
class JobPackage extends Model
{
    use SoftDeletes;

    public $table = 'job_packages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'job_name',
        'job_id',
        'month',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'job_name' => 'string',
        'job_id' => 'integer',
        'month' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'month' => 'required',
        'price' => 'required'
    ];

    
}
