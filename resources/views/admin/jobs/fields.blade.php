<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '职位名称:') !!}<span class="required">(必填)</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('is_show', '前端显示:') !!}
   	<select name="is_show" class="form-control">
   		<option value="1" @if(isset($job) && $job->is_show == 1) selected="selected" @endif>显示</option>
   		<option value="0" @if(isset($job) && $job->is_show == 0) selected="selected" @endif>不显示</option>
   	</select>
</div>

<!-- Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sort', '职位排序(序数越大排序越靠前):') !!}
    {!! Form::text('sort', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('jobs.index') !!}" class="btn btn-default">返回</a>
</div>
