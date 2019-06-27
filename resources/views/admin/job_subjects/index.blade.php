@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">{!! a_link($job->name,route('jobs.edit',$job->id)) !!}的科目列表</h1><a style="display: inline-block;margin: 5px;" href="{!! route('jobs.index') !!}"><i class="fa fa-level-up"></i>返回上一级</a>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('jobSubjects.create',$job->id) !!}">添加科目</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.job_subjects.table')
            </div>
        </div>
        <div class="text-center">
            {!! $jobSubjects->appends('')->links() !!}
        </div>
    </div>
@endsection

@include('admin.job_subjects.js')

