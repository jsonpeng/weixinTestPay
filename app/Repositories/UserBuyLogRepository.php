<?php

namespace App\Repositories;

use App\Models\UserBuyLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserBuyLogRepository
 * @package App\Repositories
 * @version August 3, 2018, 2:14 pm CST
 *
 * @method UserBuyLog findWithoutFail($id, $columns = ['*'])
 * @method UserBuyLog find($id, $columns = ['*'])
 * @method UserBuyLog first($columns = ['*'])
*/
class UserBuyLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'number',
        'pay_status',
        'package_id',
        'price',
        'package_name',
        'job_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserBuyLog::class;
    }
}
