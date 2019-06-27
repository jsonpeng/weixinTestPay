<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Job
 * @package App\Models
 * @version July 30, 2018, 4:01 pm CST
 *
 * @property string name
 * @property integer sort
 */
class Job extends Model
{
    use SoftDeletes;

    public $table = 'jobs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'sort',
        'is_show',
        'is_delete'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'sort' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    //套餐
    public function packages(){
        return $this->hasMany('App\Models\JobPackage','job_id','id');
    }

    //科目
    public function subjects(){
        return $this->hasMany('App\Models\JobSubject','job_id','id');
    }

    
}
