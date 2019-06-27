<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Selections
 * @package App\Models
 * @version August 1, 2018, 2:18 pm CST
 *
 * @property integer sort
 * @property string type
 * @property string attach_url
 * @property string name
 * @property integer topic_id
 * @property string letter
 */
class Selections extends Model
{
    use SoftDeletes;

    public $table = 'selections';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'sort',
        'type',
        'attach_url',
        'name',
        'topic_id',
        'letter',
        'is_result'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sort' => 'integer',
        'type' => 'string',
        'attach_url' => 'string',
        'name' => 'string',
        'topic_id' => 'integer',
        'letter' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

 
    
}
