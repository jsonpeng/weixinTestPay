<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $jobSubject->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $jobSubject->name !!}</p>
</div>

<!-- Max Section Field -->
<div class="form-group">
    {!! Form::label('max_section', 'Max Section:') !!}
    <p>{!! $jobSubject->max_section !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $jobSubject->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $jobSubject->updated_at !!}</p>
</div>

