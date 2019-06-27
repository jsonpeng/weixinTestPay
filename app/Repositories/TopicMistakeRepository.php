<?php

namespace App\Repositories;

use App\Models\TopicMistake;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TopicMistakeRepository
 * @package App\Repositories
 * @version January 18, 2019, 9:23 am CST
 *
 * @method TopicMistake findWithoutFail($id, $columns = ['*'])
 * @method TopicMistake find($id, $columns = ['*'])
 * @method TopicMistake first($columns = ['*'])
*/
class TopicMistakeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'question_type',
        'content',
        'question_img',
        'commit',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TopicMistake::class;
    }
}
