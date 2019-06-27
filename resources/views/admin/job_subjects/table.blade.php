<table class="table table-responsive" id="jobSubjects-table">
    <thead>
        <tr>
        <th>科目名称</th>
        <th>排序权重</th>
        <th>前端显示</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($jobSubjects as $jobSubject)
        <tr>
            <td>{!! $jobSubject->name !!}</td>
            <td>{!! $jobSubject->sort !!}</td>
            <td>{!! $jobSubject->is_show ? '显示' : '不显示' !!}</td>
            <td>
                {!! Form::open(['route' => ['jobSubjects.destroy', $jobSubject->id,$job->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="javascript:;" class='btn btn-default btn-xs' onclick="update_topics('{!! $jobSubject->id !!}')">批量纠正音频</a>
                    <a href="javascript:;" class='btn btn-default btn-xs edit_section' data-type="create" data-nextsec="{!! $jobSubject->max_section+1 !!}" data-subjectname="{!! $jobSubject->name !!}" data-name="" data-sort="{!! $jobSubject->max_section+1 !!}" data-subjectid="{!! $jobSubject->id !!}" data-jobid="{!! $job->id !!}"  data-num="10"><i class="glyphicon glyphicon-plus"></i>添加章节</a>
                    <a href="{!! route('jobSubjects.edit', [$jobSubject->id,$job->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('对应科目下的所有章节及题目都将被删除,确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        <?php $sections = $jobSubject->sections()->where('is_delete',0)->orderBy('sort','asc')->get();?>
         @foreach ($sections as $section)
         <tr> 
            {{-- 第{!! $section->sort !!}章 --}}
            <td>&nbsp;&nbsp;[{!! $section->sort !!}]@if(!empty($section->name)) {!! tag($section->name) !!} @else  第{!! $section->sort !!}章 @endif {!! tag('(单次取'.$section->get_num.'题)','orange')!!}</td>
    {{--         <td></td> --}}
            <td><div class='btn-group'>

                   <a href="javascript:;" class='btn btn-default btn-xs edit_section' data-type="update" data-nextsec="{!! $jobSubject->max_section+1 !!}" data-subjectname="{!! $jobSubject->name !!}" data-id="{{ $section->id }}" data-name="{!! $section->name !!}" data-sort="{!! $section->sort !!}" data-subjectid="{!! $jobSubject->id !!}" data-jobid="{!! $job->id !!}" data-num="{!! $section->get_num !!}" ><i class="glyphicon glyphicon-edit"></i>修改章节</a>
                   <a href="{!! route('topics.index').'?subject_id='.$jobSubject->id.'&sec='.$section->sort !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-plus"></i>管理题目</a>

                        {!! Form::button('重置题目', ['type' => 'button', 'class' => 'btn btn-danger btn-xs delOneSec', 'data-url' => route('topic.delonesec',$job->id).'?subject_id='.$jobSubject->id.'&sec='.$section->sort]) !!}
                        {!! Form::button('删除章节<i class="glyphicon glyphicon-trash"></i>', ['type' => 'button', 'class' => 'btn btn-danger btn-xs delOneSec', 'data-url' => route('topic.delonesec',$job->id).'?subject_id='.$jobSubject->id.'&sec='.$section->sort.'&delete=1']) !!}
               
                </div>
            </td>
         </tr>
         @endforeach
    @endforeach
    </tbody>
</table>

<div id="section_box_update" style="display: none;">
    <div style='width:350px; padding: 0 15px;height: 100%;'>
         <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>科目名称:</label>
            <input  class='form-control' type='text' name='subjectname'  value='' readonly="readonly" />
        </div>
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>序数:</label>
            <input  class='form-control' type='text' name='sort'  value='' readonly="readonly" />
        </div>

        {!! Form::open(['route' => ['sections.update',$job->id], 'method' => 'post','id'=>'section_form_update']) !!}
        <input type="hidden" name="sort" value="">
        <input type="hidden" name="job_id" value="{!! $job->id !!}" />
        <input type="hidden" name="subject_id" value="" />
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>请输入章节名称:</label>
            <input  class='form-control' type='text' name='name'  onkeyup="sectionNameSave(this)" value='' />
        </div>
         <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>前端取题数目:</label>
            <input  class='form-control' type='text' name='get_num' onkeyup="getNumSave(this)"  value='' />
        </div> 
         {!! Form::close() !!}

        <button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary' onclick='saveSectionInfo()'>保存</button>
    </div>
</div>

