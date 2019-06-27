<?php

namespace App\Repositories;

use App\Models\ExamLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ExamLogRepository
 * @package App\Repositories
 * @version August 3, 2018, 4:43 pm CST
 *
 * @method ExamLog findWithoutFail($id, $columns = ['*'])
 * @method ExamLog find($id, $columns = ['*'])
 * @method ExamLog first($columns = ['*'])
*/
class ExamLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject_id',
        'result',
        'user_id',
        'subject_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ExamLog::class;
    }
}
