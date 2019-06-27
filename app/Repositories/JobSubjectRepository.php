<?php

namespace App\Repositories;

use App\Models\JobSubject;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

/**
 * Class JobSubjectRepository
 * @package App\Repositories
 * @version July 31, 2018, 9:18 am CST
 *
 * @method JobSubject findWithoutFail($id, $columns = ['*'])
 * @method JobSubject find($id, $columns = ['*'])
 * @method JobSubject first($columns = ['*'])
*/
class JobSubjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'max_section'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JobSubject::class;
    }

    //删除对应科目下的所有章节和题目
    public function deleteAllSecAndTopic($subject_id){
        #章节
        $secs = app('zcjy')->SectionRepo()->model()::where('subject_id',$subject_id)->get();
        foreach ($secs as $key => $item) {
            #题目
            $item->delete();
        }
    }

    //获取职位下的科目
    public function getCacheSubjects($job_id){
            return Cache::remember('get_cache_subjects_'.$job_id, Config::get('web.cachetime'), function() use($job_id){
                    $job = app('zcjy')->JobRepo()->findWithoutFail($job_id);
                    if(!empty($job)){
                        $subjects = $job->subjects()->where('is_show',1)->where('is_delete',0)->orderBy('sort','desc')->get();
                        return zcjy_callback_data($subjects);
                    }
                    else{
                        return zcjy_callback_data('没有找到该职位',1);
                    }
            });
    }
}
