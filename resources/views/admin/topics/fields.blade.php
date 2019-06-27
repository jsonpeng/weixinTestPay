<!-- Type Field -->
<!-- Num Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('num_sort', '序号:') !!}
    @if(isset($topic))
      {!! Form::text('num_sort', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
    @else
      <?php $sort = (app('zcjy')->TopicRepo()->getSubjectSecTopics($subject->id,$sec)->count())+1; ?>
      {!! Form::text('num_sort', $sort, ['class' => 'form-control','readonly'=>'readonly']) !!}
    @endif
</div>

<div class="form-group col-sm-12">
    {!! Form::label('topic_type', '题目类型:') !!}
    <select name="topic_type" class="form-control" >
        <option value="普通题" @if(isset($topic) && $topic->topic_type == '普通题') selected="selected" @endif>普通题</option>
        <option value="单句听力题" @if(isset($topic) && $topic->topic_type == '单句听力题') selected="selected" @endif>单句听力题</option>
        <option value="对话听力题" @if(isset($topic) && $topic->topic_type == '对话听力题') selected="selected" @endif>对话听力题</option>
        <option value="短文听力题" @if(isset($topic) && $topic->topic_type == '短文听力题') selected="selected" @endif>短文听力题</option>
    </select>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('type', '实际类型:') !!}
    <select name="type" class="form-control" >
        <option value="文本" @if(isset($topic) && $topic->type == '文本') selected="selected" @endif>文本</option>
        <option value="音频" @if(isset($topic) && $topic->type == '音频') selected="selected" @endif>音频</option>
        <option value="图片" @if(isset($topic) && $topic->type == '图片') selected="selected" @endif>图片</option>
    </select>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('union_type', '听力可选类型:') !!}
    <select name="union_type" class="form-control" >
        <option value="0" @if(isset($topic) && $topic->union_type == 0) selected="selected" @endif>普通无可选</option>
        <option value="1" @if(isset($topic) && $topic->union_type == 1) selected="selected" @endif>题干显示 问题显示（对话和短文有问题，单句只有题干） 选项显示（单句、对话、短文都显示）</option>
        <option value="2" @if(isset($topic) && $topic->union_type == 2) selected="selected" @endif>题干隐藏 问题隐藏 选项隐藏（单句的选项隐藏，对话和短文的选项显示）——甲类无限航区</option>
        <option value="3" @if(isset($topic) && $topic->union_type == 3) selected="selected" @endif>题干隐藏 问题显示（对话和短文的问题也显示） 选项显示（单句、对话和短文的选项都显示）————丙类沿海航区</option>
    </select>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('name', '题目名称:') !!}

    {!! Form::textarea('name', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-12">
    {!! Form::label('name', '题目图片:') !!}
    
           <div class="input-append">
            {!! Form::text('attach_url', null, ['class' => 'form-control', 'id' => 'image']) !!}
            <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">选择图片</a>
            <img src="@if(isset($topic)) {{$topic->attach_url}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
        </div>
 
</div>


<div class="form-group col-sm-12">
    {!! Form::label('question', '问题内容:') !!}
    {!! Form::textarea('question', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12 attach" style="display:block;">
    {!! Form::label('attach_sound_url', '问题音频文件管理:') !!}
    {!! Form::hidden('attach_sound_url', null, ['class' => 'form-control']) !!}

    <div class="input-append type_files" style="display:  block;" data-type="question">
                <a href="javascript:;"  class="btn upload_file" type="button" >选择文件</a>
           
                <audio src="@if(isset($topic)) @if($topic->topic_type == '单句听力题' && empty($topic->attach_sound_url)) {!! $topic->attach_url !!} @else {!! $topic->attach_sound_url !!} @endif @endif" controls="controls" style="display:  block;"> </audio>
    </div>

</div>

<div class="form-group col-sm-12 attach" style="display:block;">
    {!! Form::label('selection_sound_url', '选项音频文件管理:') !!}
    {!! Form::hidden('selection_sound_url', null, ['class' => 'form-control']) !!}

    <div class="input-append type_files" style="display:  block;" data-type="selection">
                <a href="javascript:;"  class="btn upload_file" type="button" >选择文件</a>
           
                <audio src="@if(isset($topic) && $topic->topic_type == '单句听力题' || !empty($topic->selection_sound_url)) {!! $topic->selection_sound_url !!} @else {!! $topic->attach_url !!} @endif" controls="controls" style="@if(isset($topic) &&  $topic->topic_type == '单句听力题'  && isset($topic->selection_sound_url) || isset($topic) &&  $topic->topic_type != '单句听力题'  && isset($topic->attach_url) || !empty($topic->selection_sound_url)) display:  block; @else display:none; @endif"> </audio>
    </div>

</div>

<!-- Name Field -->
{{-- <div class="form-group col-sm-12 name" style="@if(isset($topic) && $topic->type != '文本') display:none; @else display:block; @endif">
    {!! Form::label('name', '题目名称:') !!}<span class="required">(必填)</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Attach Url Field -->
{{-- <div class="form-group col-sm-12 attach" style="@if(isset($topic) && $topic->type != '文本') display:block; @else display:none; @endif">
    {!! Form::label('attach_url', '上传题干文件:') !!}
    {!! Form::hidden('attach_url', null, ['class' => 'form-control','id'=>'image1']) !!}

    <div class="input-append type_files" style="display: @if(isset($topic) && $topic->type != '文本') block; @else none; @endif">
                <a href="javascript:;"  class="btn upload_file" type="button" >选择文件</a>
                <img src="@if(isset($topic) && $topic->type == '图片') {!! $topic->attach_url !!} @endif" style="max-width: 100%; max-height: 160px; margin-top:-60px;display: block;">
                <audio src="@if(isset($topic) && $topic->type == '音频') {!! $topic->attach_url !!} @endif" controls="controls" style="display: @if(isset($topic) && $topic->type == '音频') block; @else none; @endif"> </audio>
    </div>

</div>
 --}}


<!-- Sec Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sec_sort', '章节:') !!}
    {!! Form::text('sec_sort', $sec, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('value', '分值(不填默认是0.625):') !!}
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
</div>


{!! Form::hidden('subject_id', $subject->id, ['class' => 'form-control']) !!}


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('topics.index').'?subject_id='.$subject->id.'&sec='.$sec !!}" class="btn btn-default">返回</a>
</div>
