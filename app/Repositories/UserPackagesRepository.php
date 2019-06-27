<?php

namespace App\Repositories;

use App\Models\UserPackages;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserPackagesRepository
 * @package App\Repositories
 * @version August 3, 2018, 2:39 pm CST
 *
 * @method UserPackages findWithoutFail($id, $columns = ['*'])
 * @method UserPackages find($id, $columns = ['*'])
 * @method UserPackages first($columns = ['*'])
*/
class UserPackagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'package_id',
        'package_end',
        'package_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserPackages::class;
    }
}
