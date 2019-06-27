<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TopicMistake
 * @package App\Models
 * @version January 18, 2019, 9:23 am CST
 *
 * @property string question_type
 * @property string content
 * @property string question_img
 * @property string commit
 * @property integer user_id
 */
class TopicMistake extends Model
{
    use SoftDeletes;

    public $table = 'topic_mistakes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'question_type',
        'content',
        'question_img',
        'commit',
        'user_id',
        'topic_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'question_type' => 'string',
        'content' => 'string',
        'question_img' => 'string',
        'commit' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
