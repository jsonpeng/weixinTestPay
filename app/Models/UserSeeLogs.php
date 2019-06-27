<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserSeeLogs
 * @package App\Models
 * @version August 3, 2018, 1:30 pm CST
 *
 * @property integer sec_id
 * @property integer user_id
 */
class UserSeeLogs extends Model
{
    use SoftDeletes;

    public $table = 'user_see_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'sec_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sec_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function section(){
        return $this->belongsTo('App\Models\Section','sec_id','id');
    }

    
}
