<?php

namespace App\Repositories;

use App\Models\UserSeeLogs;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserSeeLogsRepository
 * @package App\Repositories
 * @version August 3, 2018, 1:30 pm CST
 *
 * @method UserSeeLogs findWithoutFail($id, $columns = ['*'])
 * @method UserSeeLogs find($id, $columns = ['*'])
 * @method UserSeeLogs first($columns = ['*'])
*/
class UserSeeLogsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sec_id',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserSeeLogs::class;
    }
}
