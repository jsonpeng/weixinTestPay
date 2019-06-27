<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ExamTopicDetail
 * @package App\Models
 * @version August 3, 2018, 4:51 pm CST
 *
 * @property integer exam_id
 * @property integer topic_id
 * @property integer result
 * @property integer correct
 */
class ExamTopicDetail extends Model
{
    use SoftDeletes;

    public $table = 'exam_topic_details';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'exam_id',
        'topic_id',
        'result',
        'correct'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'exam_id' => 'integer',
        'topic_id' => 'integer',
        'result' => 'integer',
        'correct' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function topic(){
        return $this->belongsTo('App\Models\Topic','topic_id','id');
    }

    
}
