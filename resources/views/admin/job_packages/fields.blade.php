<!-- Job Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('job_name', '兼职名称:') !!}
    {!! Form::text('job_name', $job->name, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>

<!-- Job Id Field -->
{{-- <div class="form-group col-sm-12">
    {!! Form::label('job_id', 'Job Id:') !!}
    {!! Form::text('job_id', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Month Field -->
<div class="form-group col-sm-12">
    {!! Form::label('month', '月数:') !!}<span class="required">(必填)</span>
    {!! Form::text('month', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-12">
    {!! Form::label('price', '价格:') !!}<span class="required">(必填)</span>
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('jobPackages.index',$job->id) !!}" class="btn btn-default">返回</a>
</div>
