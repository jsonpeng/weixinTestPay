<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Topic
 * @package App\Models
 * @version July 31, 2018, 4:30 pm CST
 *
 * @property string type
 * @property string name
 * @property string attach_url
 * @property integer sec_sort
 * @property integer num_sort
 * @property integer subject_id
 */
class Topic extends Model
{
    use SoftDeletes;

    public $table = 'topics';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'name',
        'attach_url',
        'sec_sort',
        'num_sort',
        'subject_id',
        'value',
        'is_delete',
        'group',
        'group_type',
        'topic_type',
        'attach_sound_url',
        'selection_sound_url',
        'question',
        'union_type',
        'other_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'name' => 'string',
        'attach_url' => 'string',
        'sec_sort' => 'integer',
        'num_sort' => 'integer',
        'subject_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'name' => 'required'
    ];

    //题目的选项
    public function selections(){
        return $this->hasMany('App\Models\Selections','topic_id','id');
    }

    
}
