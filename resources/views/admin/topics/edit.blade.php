@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑{!! a_link($subject->name,route('jobSubjects.index',$subject->job_id)) !!}题目
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($topic, ['route' => ['topics.update', $topic->id], 'method' => 'patch']) !!}

                        @include('admin.topics.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>

        <div class="box box-primary">
           <div class="box-body">
               <div class="row" style="margin-left: 25px;">
                <h4 >选项及答案操作</h4> 
                 <?php $sort = ($topic->selections()->count())+1 ;?>
                        <a href="javascript:;" class='btn btn-default btn-xs add_select' data-action="create" data-topicid="{!! $topic->id !!}" data-numsort="{!! $topic->num_sort !!}" data-sort="{!!  $sort !!}" data-letter="{!! select_sort($sort) !!}"><i class="glyphicon glyphicon-plus"></i>添加选项</a>
                    <table class="table table-responsive" id="topics-table">
                        <thead>
                          <tr>
                              <th>选项</th>
                              <th>操作</th>
                          </tr>
                        </thead>
                    <tbody>
                         <?php $selections = $topic->selections()->orderBy('sort','asc')->get();?>
                          @if(count($selections))
                              @foreach ($selections as $selection)
                                  <tr>
                                      <td>&nbsp;&nbsp;{!! tag('['.$selection->type.']','orange') !!}{!! $selection->letter !!}.{!! $selection->name.$selection->attach_url !!} @if($selection->is_result) {!! tag('√') !!} @endif</td>
                                      <td><a href="javascript:;" class='btn btn-default btn-xs add_select' data-action="update" data-id="{!! $selection->id !!}" data-topicid="{!! $topic->id !!}" data-type="{!! $selection->type !!}" data-attachurl="{!! $selection->attach_url !!}" data-numsort="{!! $topic->num_sort !!}" data-result="{!! $selection->is_result !!}" data-sort="{!!  $selection->sort !!}" data-letter="{!!  $selection->letter !!}" data-name="{!! $selection->name !!}"><i class="glyphicon glyphicon-edit"></i>编辑选项</a></td>
                                  </tr>
                              @endforeach
                          @endif
                    </tbody>
                    </table>
               </div>

           </div>
       </div>

   </div>

   <div id="select_box" style="display: none;">
    <div style='width:350px; padding: 0 15px;height: 100%;'>
     {!! Form::open(['route' => ['selections.store'], 'method' => 'post','id'=>'select_form']) !!}
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>选项:</label>
            <input class='form-control' type='text' name='letter' value='A' readonly="readonly" />
        </div>

        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>选项类型:</label>
            <select name="type" class="form-control">
                   <option value="文本">文本</option>
                   <option value="音频">音频</option>
                   <option value="图片">图片</option>
            </select>
        </div>
        
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback name'>
             <label>选项描述:</label>
             <input class='form-control' type='text' placeholder="请输入选项描述" name='name' value='' onkeyup="selectNameSave(this)" />
        </div>
        
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback attach' style="display: none;">
            <label>上传附件:</label>
             <div class="input-append type_files" style="display: none;">
                  <a href="javascript:;"  class="btn upload_file" type="button" >请把文件拖动到这里上传</a>
                  <img src="" style="max-width: 100%; max-height: 160px; margin-top:-60px;display: block;" />
                  <audio src="" controls="controls" style="display:none;"> </audio>
             </div>
        </div>
        <input name="_method" type="hidden" value="post">
        <input type="hidden" name="attach_url" value="">
        <input type="hidden" name="sort" value="">
        <input type="hidden" name="topic_id" value="">
        <input type="hidden" name="subject_id" value="{!! $subject->id !!}">
        <input type="hidden" name="sec" value="{!! $sec !!}">
            <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
                <label>是否设置为答案:</label>
                <select name="is_result" class="form-control">
                    <option value="0">否</option>
                   <option value="1">是</option>
                </select>
            </div> 
        {!! Form::close() !!}

        <button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary' onclick='saveSelectInfo()'>保存</button>

    </div>
</div>
 @include('admin.partials.imagemodel')
@endsection

@include('admin.topics.js')