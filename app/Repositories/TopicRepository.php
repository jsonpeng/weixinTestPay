<?php

namespace App\Repositories;

use App\Models\Topic;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

/**
 * Class TopicRepository
 * @package App\Repositories
 * @version July 31, 2018, 4:30 pm CST
 *
 * @method Topic findWithoutFail($id, $columns = ['*'])
 * @method Topic find($id, $columns = ['*'])
 * @method Topic first($columns = ['*'])
*/
class TopicRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'name',
        'attach_url',
        'sec_sort',
        'num_sort',
        'subject_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Topic::class;
    }


    public function getNextGroupNum(){
          $topic  = Topic::orderBy('group','desc')->first();
          $num = 1;
          if(!empty($topic)){
            $num = $topic->group + 1;
          }
          return $num;
    }

    public function getGroupTopics(){
        return Topic::where('group',0)->get();
    }

    public function getSubjectSecTopics($subject_id,$sec){
        return Topic::where('subject_id',$subject_id)->where('sec_sort',$sec);
    }


    /**
     * [根据关键字搜索题目]
     * @param  [type] $word [description]
     * @return [type]       [description]
     */
    public function searchTopics($word){
          return Cache::remember('get_cache_search_topics_'.$word, Config::get('web.cachetime'), function() use($word){
                return Topic::where('is_delete',0)
                    ->where('name','like','%'.$word.'%')
                    ->with('selections')
                    ->orderBy('num_sort','asc')
                    ->get();
          });
    }

    /**
     * [根据科目和章节获取题目]
     * @param  [type]  $subject_id [description]
     * @param  [type]  $sec        [description]
     * @param  integer $take       [description]
     * @return [type]              [description]
     */
    public function getCacheTopics($subject_id,$sec,$take=10){
        return Cache::remember('get_cache_topics_'.$subject_id.'_'.$sec.'_'.$take, Config::get('web.cachetime'), function() use($subject_id,$sec,$take){
            if($take == 'all'){
                  return $this->getSubjectSecTopics($subject_id,$sec)
                    ->where('is_delete',0)
                    ->with('selections')
                    ->orderBy('num_sort','asc')
                    ->get();
            }else{
            return $this->getSubjectSecTopics($subject_id,$sec)
            ->where('is_delete',0)
            ->with('selections')
            ->orderBy(\DB::raw('RAND()'))
            ->take($take)
            ->get();
            }
        });
    }

    /**
     * 根据科目检查是否是英语听力题型
     * @param  [type] $subject_id [description]
     * @param  [type] $sec        [description]
     * @return [type]             [description]
     */
    public function varifyEnglishSound($subject_id)
    {
        $count = Topic::where('subject_id',$subject_id)
        ->where('topic_type','单句听力题')
        ->count();
        return  $count>=10 ? true : false;
    }

    /**
     * 针对英语听力的组卷
     * @param  [type] $subject_id [description]
     * @return [type]             [description]
     */
    public function getZuGroupTopics($subject_id)
    {
      #取十个单句题
      $topics = $this->getTypeTopics($subject_id,'单句听力题');
      #取十个对话题
      $topics = $topics->concat($this->getTypeTopics($subject_id,'对话听力题'));
      #取四个短文
      $topics = $topics->concat($this->getTypeTopics($subject_id,'短文听力题',4));
      return $topics;
    }

    /**
     * 获取不同类型的题目 用于数组合并
     * @param  [type]  $subject_id [description]
     * @param  [type]  $topic_type [description]
     * @param  integer $take       [description]
     * @return [type]              [description]
     */
    private function getTypeTopics($subject_id,$topic_type,$take=10)
    {
      $topics = [];
      if ($topic_type == '单句听力题' || $topic_type == '对话听力题')
      {
         $topics = Topic::where('subject_id',$subject_id)
                  ->where('topic_type',$topic_type)
                  ->where('is_delete',0)
                  ->inRandomOrder()
                  ->with('selections')
                  ->take($take)
                  ->get();
      }
      elseif($topic_type == '短文听力题')
      {

           #先取四个首个组题 然后把子组题挂在下面
           $topics = Topic::where('subject_id',$subject_id)
                    ->where('topic_type',$topic_type)
                    ->where('group_type',1)
                    ->where('is_delete',0)
                    ->inRandomOrder()
                    ->with('selections')
                    ->take($take)
                    ->get();

          #先取出子组题
          foreach ($topics as $key => $topic) 
          {
              $topic['child_topics'] = Topic::where('is_delete',0)
              ->where('group',$topic->group)
              ->where('group_type',2)
              ->where('is_delete',0)
              ->with('selections')
              ->get();
          }
          
         #然后合并挂在组题下面
         for ($i=0; $i < count($topics); $i++) 
         { 
            $child_topics = $topics[$i]['child_topics'];
            if(count($child_topics))
            {
              $topics = $topics->concat($child_topics);
            }
         }
         $topics = $topics->sortBy('group');
      }
      return $topics;
    }

    /**
     * 根据科目id及章节序号获取题目总量
     * @param  [type] $subject_id [description]
     * @param  [type] $sec        [description]
     * @return [type]             [description]
     */
    public function getCacheTopicsSum($subject_id,$sec)
    {
       return Cache::remember('get_cache_topics_sum'.$subject_id.'_'.$sec, Config::get('web.cachetime'), function() use($subject_id,$sec){
             return $this->getSubjectSecTopics($subject_id,$sec)
            ->where('is_delete',0)
            ->count();
       });
    }


    public function dealTopic($topic)
    {

    }

    /**
     * [根据科目和章节获取题目]
     * @param  [type]  $subject_id [description]
     * @param  [type]  $sec        [description]
     * @param  integer $take       [description]
     * @return [type]              [description]
     */
    public function getCacheTopicsWithSort($subject_id,$sec,$sort=1){
        return Cache::remember('get_cache_topics_with_skip'.$subject_id.'_'.$sec.'_'.$sort, Config::get('web.cachetime'), function() use($subject_id,$sec,$sort){
            
            $skip = $sort-1 < 0 ? 0 : $sort-1;

            $topic = $this->getSubjectSecTopics($subject_id,$sec)
            ->where('is_delete',0)
            ->with('selections')
            ->orderBy('num_sort','asc')
            ->skip($skip)
            ->take(1)
            ->first();

            if(!empty($topic))
            {
                 $question = str_replace('S1','<br/>S1',$topic->question);
                 $question = str_replace('S2','<br/>S2',$topic->question);
                 $question = ltrim($question,'<br/>');
                 $topic->question = $question;
            }

            return $topic;
            
        });
    }

    /**
     * [根据科目和章节获取题目]
     * @param  [type]  $subject_id [description]
     * @param  [type]  $sec        [description]
     * @param  integer $take       [description]
     * @return [type]              [description]
     */
    public function getCacheTopicsWithSkipTake($subject_id,$sec,$skip=0,$take=50){
        return Cache::remember('get_cache_topics_with_skip'.$subject_id.'_'.$sec.'_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use($subject_id,$sec,$skip,$take){
   
            $topics =  $this->getSubjectSecTopics($subject_id,$sec)
            ->where('is_delete',0)
            ->with('selections')
            ->orderBy('num_sort','asc')
            ->skip($skip)
            ->take($take)
            ->get();

            foreach ($topics as $key => $topic) 
            {
                if(!empty($topic))
                {
                     $question = str_replace('S1','<br/>S1',$topic->question);
                     $question = str_replace('S2','<br/>S2',$topic->question);
                     $question = ltrim($question,'<br/>');
                     $topic->question = $question;
                }
            }

            return $topics;
            
        });
    }
 

    //题目音频文件 批量处理
    public function manyTopicAction($subject_id = 22,$request,$type = 1)
    {   
      if(!empty($subject_id))
      {
            $this->manyDealTopicType($subject_id);
            #然后取科目下的题目
            $topics = Topic::where('subject_id',$subject_id)
            ->where('is_delete',0)
            ->with('selections')
            ->orderBy('sec_sort','asc')
            ->orderBy('num_sort','asc')
            ->get();

            $typeFile = 'lunji_sounds';

            if($type == 2)
            {
                $typeFile = 'all_sounds';
            }

            #然后批量处理单道题目
            foreach ($topics as $key => $topic) 
            {
                    #根地址
                    $base_path = $request->root().'/'.$typeFile.'/第'.$topic->sec_sort.'章/';

                    #文件规则 章节文件规则不变依然按照 第*章 
                    #单句听力题 主要处理 单句题的问题+单句题的选项
                    #文件命名规则 类型(1单句听力题2对话/短文题)+问题/选项(1问题2选项)+题目序号 
                    #示例命名如下
                    #1112.mp3=>[问题]序号是12的单句听力题
                    #1212.mp3=>[选项]序号是12的单句听力题
                    
                    #对话/短文题 主要处理 对话/短文题的内容+小题的问题
                    #文件命名规则 类型(1单句听力题2对话/短文题)+短文题的内容/小题的问题(小题的问题)+题目序号 
                    #示例命名如下
                    #1112.mp3=>[小题的问题]序号是12的对话/短文听力题
                    #1212.mp3=>[短文题的内容]序号是12的对话/短文听力题
                    
                    #处理单题 单句题的问题+单句题的选项  
                    if($topic->topic_type == '单句听力题')
                    {
                        $topic_type = 1;
                        $topic->update(
                            [
                                'attach_url'      => $base_path.$topic_type.'1'.$topic->num_sort.'.mp3',
                                'attach_sound_url'      => null,
                                'selection_sound_url'   => $base_path.$topic_type.'2'.$topic->num_sort.'.mp3',
                            ]
                        );
                    } #处理对话/短文题 然后是对话/短文题的内容+小题的问题
                    elseif($topic->topic_type == '对话听力题' || $topic->topic_type == '短文听力题')
                    {
                        $topic_type = 2;
                        $topic->update(
                            [
                                'attach_url'      => $base_path.$topic_type.'2'.$topic->num_sort.'.mp3',
                                'attach_sound_url'      => $base_path.$topic_type.'1'.$topic->num_sort.'.mp3',
                                'selection_sound_url'   => null,
                            ]
                        );
                    }
                    
                   
            }
            $this->dealTopicsSound($topics);
            return zcjy_callback_data('批量处理完成',0,'web');
      
      }
      else{
        return zcjy_callback_data('参数不对',1,'web');
      }   
    }


    public function manyDealTopicType($subject_id = null)
    {

      $topics =  Topic::where('is_delete',0);

      if(!empty($subject_id))
      {
        $topics = $topics ->where('subject_id',$subject_id);
      }

      $topics = $topics
                  ->where('type','文本')
                  ->chunk(1000, function($topics)
        {
             $topics->each(function ($item, $key) {
               if(strpos($item->attach_url,'.mp3') !== false)
               {
                    $item->update(['type'=>'音频']);
               }
              });

       });
        
    }

    public function dealTopicsSound($topics)
    {
        if(count($topics))
        {
            foreach ($topics as $key => $topic) 
            {
                 $this->dealOneTopicSound($topic,['attach_url','attach_sound_url','selection_sound_url']);

            }
        }
       
    }

    public function dealOneTopicSound($topic,$attributes = ['attach_url'])
    {
        foreach ($attributes as $key => $attribute) 
        {
            if(isset($topic->{$attribute}) && !empty($topic->{$attribute}))
            {
                   if(!chkurl($topic->{$attribute}))
                   {
                     $topic->update([$attribute => '']);
                   }
            }
        }
           
    }




}
