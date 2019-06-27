@extends('layouts.app')

@section('content')
    <section class="content-header">
        @if(array_key_exists('user_id',$input) && !empty($input['user_id']))
            <?php $user= optional(user_by_id($input['user_id']));?>
            <h1 class="pull-left">{!! $user->nickname !!}的考试记录列表</h1>
        @else
           <h1 class="pull-left">考试记录列表</h1>
        @endif
     {{--    <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('examLogs.create') !!}">添加</a>
        </h1> --}}
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.exam_logs.table')
            </div>
        </div>
        <div class="text-center">
            {!! $examLogs->appends($input)->links() !!}
        </div>
    </div>
@endsection

