<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Section
 * @package App\Models
 * @version July 31, 2018, 1:29 pm CST
 *
 * @property string name
 * @property integer sort
 * @property integer subject_id
 */
class Section extends Model
{
    use SoftDeletes;

    public $table = 'sections';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'sort',
        'subject_id',
        'get_num',
        'is_delete'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'sort' => 'integer',
        'subject_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function subject(){
        return $this->belongsTo('App\Models\JobSubject','subject_id','id');
    }

    
}
