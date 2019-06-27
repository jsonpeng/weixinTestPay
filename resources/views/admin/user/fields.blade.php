<!-- Name Field -->

{{-- <div class="form-group col-sm-12">
    {!! Form::label('name', '姓名:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-12">
        {!! Form::label('image', '头像:') !!}

        <div class="input-append">
            {!! Form::text('head_image', null, ['class' => 'form-control', 'id' => 'image1']) !!}
            <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image1')">选择图片</a>
            <img src="@if($users) {{$users->head_image}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
        </div>

</div>

<div class="form-group col-sm-12">
    {!! Form::label('nickname', '昵称:') !!}
    {!! Form::text('nickname', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('mobile', '手机号:') !!}
    {!! Form::number('mobile', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('job', '注册职位:') !!}
    <select name="job" class="form-control">
        <option value="" @if(!empty($users) && empty($users->job)) selected="selected" @endif>请选择职位</option>
        <?php $jobs = app('zcjy')->JobRepo()->all();?>
        @foreach ($jobs as $job)

            <option value="{!! $job->name !!}" @if(!empty($users) && $users->job==$job->name) selected="selected" @endif>{!! $job->name !!}</option>
        @endforeach
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">返回</a>
</div>





