<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FeedBack
 * @package App\Models
 * @version January 18, 2019, 9:20 am CST
 *
 * @property string content
 * @property string questtion_img
 * @property string commit
 * @property integer grade
 * @property integer user_id
 */
class FeedBack extends Model
{
    use SoftDeletes;

    public $table = 'feed_back';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'content',
        'question_img',
        'commit',
        'grade',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'content' => 'string',
        'question_img' => 'string',
        'commit' => 'string',
        'grade' => 'integer',
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
