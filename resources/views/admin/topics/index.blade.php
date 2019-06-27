@extends('layouts.app')

@section('content')
      {!! Form::open(['route' => ['selections.store'], 'method' => 'post','id'=>'action_form']) !!}
            <input type="hidden" name="attr_arr" value="">
      {!! Form::close() !!}

    <section class="content-header">
        <h1 class="pull-left">科目{!! a_link($subject->name,route('jobSubjects.index',$subject->job_id)) !!}的第{!! tag($sec) !!}章的题目列表</h1><a style="display: inline-block;margin: 5px;" href="{!! route('jobSubjects.index',$subject->job_id) !!}"><i class="fa fa-level-up"></i>返回上一级</a>
        <a class="btn btn-primary import_topic" href="javascripts:;"><i class="glyphicon glyphicon-download"></i> 从excel中导入题目</a>
        <a style="display: inline-block;margin: 5px;" href="/excel/demo.xls">查看Excel文件规范</a>
        <a class="btn btn-success rec" href="javascripts:;"><i class="glyphicon glyphicon-refresh"></i> 回收站</a>
        <a class="btn btn-danger delete" href="javascripts:;"><i class="glyphicon glyphicon-trash"></i>批量删除</a>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('topics.create').'?subject_id='.$subject->id.'&sec='.$sec !!}">添加题目</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.topics.table')
            </div>
        </div>
        <div class="text-center">
            {!! $topics->appends($input)->links() !!}
        </div>
    </div>
@endsection

@include('admin.topics.js')

