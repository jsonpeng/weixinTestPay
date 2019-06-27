<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ExamLog
 * @package App\Models
 * @version August 3, 2018, 4:43 pm CST
 *
 * @property integer subject_id
 * @property integer result
 * @property integer user_id
 * @property string subject_name
 */
class ExamLog extends Model
{
    use SoftDeletes;

    public $table = 'exam_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'subject_id',
        'result',
        'user_id',
        'subject_name',
        'testTime'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'subject_id' => 'integer',
        'user_id' => 'integer',
        'subject_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function detail(){
        return $this->hasMany('App\Models\ExamTopicDetail','exam_id','id');
    }
}
