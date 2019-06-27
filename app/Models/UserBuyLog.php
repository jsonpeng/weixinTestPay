<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserBuyLog
 * @package App\Models
 * @version August 3, 2018, 2:14 pm CST
 *
 * @property string number
 * @property string pay_status
 * @property integer package_id
 * @property float price
 * @property string package_name
 * @property integer job_id
 */
class UserBuyLog extends Model
{
    use SoftDeletes;

    public $table = 'user_buy_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'number',
        'pay_status',
        'package_id',
        'price',
        'package_name',
        'job_id',
        'user_id',
        'package_month',
        'pay_platform'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'number' => 'string',
        'pay_status' => 'string',
        'package_id' => 'integer',
        'price' => 'float',
        'package_name' => 'string',
        'job_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function job(){
        return $this->belongsTo('App\Models\Job','job_id','id');
    }

    
}
