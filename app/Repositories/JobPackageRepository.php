<?php

namespace App\Repositories;

use App\Models\JobPackage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class JobPackageRepository
 * @package App\Repositories
 * @version July 30, 2018, 5:11 pm CST
 *
 * @method JobPackage findWithoutFail($id, $columns = ['*'])
 * @method JobPackage find($id, $columns = ['*'])
 * @method JobPackage first($columns = ['*'])
*/
class JobPackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_name',
        'job_id',
        'month',
        'price'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JobPackage::class;
    }

    public function getJobPackages($job_id){
        return JobPackage::where('job_id',$job_id)->orderBy('month','asc');
    }
}
