<?php

namespace App\Repositories;

use App\Models\ExamTopicDetail;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ExamTopicDetailRepository
 * @package App\Repositories
 * @version August 3, 2018, 4:51 pm CST
 *
 * @method ExamTopicDetail findWithoutFail($id, $columns = ['*'])
 * @method ExamTopicDetail find($id, $columns = ['*'])
 * @method ExamTopicDetail first($columns = ['*'])
*/
class ExamTopicDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'exam_id',
        'topic_id',
        'result',
        'correct'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExamTopicDetail::class;
    }
}
