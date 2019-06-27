<!-- Name Field -->
<div class="form-group col-sm-8">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">文章正文</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
         
                {!! Form::hidden('type','post', ['class' => 'form-control','id'=>'post']) !!}
             
                {!! Form::label('name', '标题:') !!}<span class="required">(必填)</span>
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>



            <div class="form-group">
                {!! Form::label('brief', '简介:') !!}
                {!! Form::textarea('brief', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('content', '正文:') !!}<span class="required">(必填)</span>
                {!! Form::textarea('content', null, ['class' => 'form-control intro']) !!}
            </div>
        </div><!-- /.box-body -->
    </div>    
</div>

<!-- Submit Field -->
<div class="form-group col-sm-4">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">发布设置</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                <label class="fb">{!! Form::checkbox('status', 1, null, ['class' => 'field minimal']) !!}发布</label>
            </div>

            {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('posts.index') !!}" class="btn btn-default">取消</a>
        </div><!-- /.box-body -->
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">其他设置</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('image', '特色图片:') !!}

                <div class="input-append">
                    {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
                    <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image')">选择图片</a>
                    <img src="@if($post) {{$post->image}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
                </div>

            </div>

            <div class="form-group">
                {!! Form::label('view', '浏览量:') !!}
                {!! Form::number('view', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('sort', '排序:') !!}
                {!! Form::number('sort', null, ['class' => 'form-control']) !!}
            </div>
        </div><!-- /.box-body -->
    </div>



    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">SEO设置</h3>
            <p class="text-muted">可以为页面单独设置SEO，如果不设置，将使用网站默认设置</p>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('seo_title', 'SEO标题:') !!}
                {!! Form::text('seo_title', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('seo_des', 'SEO描述:') !!}
                {!! Form::text('seo_des', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('seo_keyword', 'SEO关键字:') !!}
                {!! Form::text('seo_keyword', null, ['class' => 'form-control']) !!}
            </div>
        </div><!-- /.box-body -->
    </div>

     

</div>


