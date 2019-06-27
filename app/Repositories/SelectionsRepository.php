<?php

namespace App\Repositories;

use App\Models\Selections;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SelectionsRepository
 * @package App\Repositories
 * @version August 1, 2018, 2:18 pm CST
 *
 * @method Selections findWithoutFail($id, $columns = ['*'])
 * @method Selections find($id, $columns = ['*'])
 * @method Selections first($columns = ['*'])
*/
class SelectionsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sort',
        'type',
        'attach_url',
        'name',
        'topic_id',
        'letter'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Selections::class;
    }

    public function getTopicSelections($topic_id){
        return Selections::where('topic_id',$topic_id);
    }

}
