<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '科目名称:') !!}<span class="required">(必填)</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Max Section Field -->
<div class="form-group col-sm-12">
    {!! Form::label('max_section', '章节数:') !!}<span class="required">(必填)</span>

    @if(!empty($jobSubject))
        {!! Form::text('max_section', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
    @else
        {!! Form::text('max_section', null, ['class' => 'form-control']) !!}
    @endif
</div>

<div class="form-group col-sm-12">
    {!! Form::label('time', '考试时间[分钟]:') !!}<span class="required">(必填)</span>
    {!! Form::text('time', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('sort', '排序权重(序数越大排序越靠前):') !!}
    {!! Form::text('sort', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('is_show', '前端显示:') !!}
    <select name="is_show" class="form-control">
        <option value="1" @if(isset($jobSubject) && $jobSubject->is_show == 1) selected="selected" @endif>显示</option>
        <option value="0" @if(isset($jobSubject) && $jobSubject->is_show == 0) selected="selected" @endif>不显示</option>
    </select>
</div>
{{-- <div class="form-group col-sm-12">
     {!! Form::label('get_num', '前端取题数目:') !!}
     {!! Form::text('get_num', 10, ['class' => 'form-control']) !!}
</div> --}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('jobSubjects.index',$job->id) !!}" class="btn btn-default">返回</a>
</div>
