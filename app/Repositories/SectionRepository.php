<?php

namespace App\Repositories;

use App\Models\Section;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

/**
 * Class SectionRepository
 * @package App\Repositories
 * @version July 31, 2018, 1:29 pm CST
 *
 * @method Section findWithoutFail($id, $columns = ['*'])
 * @method Section find($id, $columns = ['*'])
 * @method Section first($columns = ['*'])
*/
class SectionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'sort',
        'subject_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Section::class;
    }

    public function getCacheSections($subject_id){
          return Cache::remember('get_cache_sections_'.$subject_id, Config::get('web.cachetime'), function() use($subject_id){
                $subject = app('zcjy')->JobSubjectRepo()->findWithoutFail($subject_id);
                if(!empty($subject))
                {
                    $sections = $subject->sections()->where('is_delete',0)->orderBy('sort','asc')->get();
                    #把题目数量统计下
                    foreach ($sections as $key => $val) 
                    {
                        $val['topic_count'] = app('zcjy')->TopicRepo()->getSubjectSecTopics($subject->id,$val->sort)->where('is_delete',0)->count();
                        // $val['min_sort'] = optional(app('zcjy')->TopicRepo()->getSubjectSecTopics($subject->id,$val->sort)->where('is_delete',0)->orderBy('num_sort','asc')->first())->num_sort;
                    }
                    return zcjy_callback_data($sections);
                }
                else{
                    return zcjy_callback_data('没有找到该科目',1);
                }
          });
    }
}
