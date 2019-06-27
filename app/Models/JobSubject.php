<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class JobSubject
 * @package App\Models
 * @version July 31, 2018, 9:18 am CST
 *
 * @property string name
 * @property integer max_section
 */
class JobSubject extends Model
{
    use SoftDeletes;

    public $table = 'job_subjects';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'max_section',
        'job_id',
        'time',
        'is_show',
        'is_delete',
        'sort'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'max_section' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'max_section' => 'required',
        'time' => 'required'
    ];

    public function sections(){
        return $this->hasMany('App\Models\Section','subject_id','id');
    }

    public function job(){
        return $this->belongsTo('App\Models\Job','job_id','id');
    }
    
}
