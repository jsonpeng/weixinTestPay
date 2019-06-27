<!-- Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', 'Number:') !!}
    {!! Form::text('number', null, ['class' => 'form-control']) !!}
</div>

<!-- Pay Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pay_status', 'Pay Status:') !!}
    {!! Form::text('pay_status', null, ['class' => 'form-control']) !!}
</div>

<!-- Package Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('package_id', 'Package Id:') !!}
    {!! Form::text('package_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Package Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('package_name', 'Package Name:') !!}
    {!! Form::text('package_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Job Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('job_id', 'Job Id:') !!}
    {!! Form::text('job_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userBuyLogs.index') !!}" class="btn btn-default">Cancel</a>
</div>
