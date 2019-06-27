<?php

namespace App\Repositories;

use App\Models\Job;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

/**
 * Class JobRepository
 * @package App\Repositories
 * @version July 30, 2018, 4:01 pm CST
 *
 * @method Job findWithoutFail($id, $columns = ['*'])
 * @method Job find($id, $columns = ['*'])
 * @method Job first($columns = ['*'])
*/
class JobRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'sort'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Job::class;
    }

    public function getCacheJobs(){
        return Cache::remember('get_cache_jobs_', Config::get('web.cachetime'), function(){
            return Job::where('is_show',1)->where('is_delete',0)->orderBy('sort','desc')->get();
        });
    }
}
