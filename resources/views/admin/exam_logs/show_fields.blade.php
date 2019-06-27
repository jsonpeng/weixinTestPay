{{-- <!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $examLog->id !!}</p>
</div> --}}

<!-- Subject Id Field -->
<div class="form-group">
    {!! Form::label('subject_id', '考试科目:') !!}
    <p>{!! $examLog->subject_name !!}</p>
</div>

<!-- Result Field -->
<div class="form-group">
    {!! Form::label('result', '考试结果:') !!}
    <p>{!! $examLog->result !!}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', '考试人:') !!}
    <p>{!! optional(user_by_id($examLog->user_id))->nickname !!}</p>
</div>

<!-- Subject Name Field -->
{{-- <div class="form-group">
    {!! Form::label('subject_name', 'Subject Name:') !!}
    <p>{!! $examLog->subject_name !!}</p>
</div> --}}

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', '考试提交时间:') !!}
    <p>{!! $examLog->created_at !!}</p>
</div>

<!-- Updated At Field -->
{{-- <div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $examLog->updated_at !!}</p>
</div>
 --}}
