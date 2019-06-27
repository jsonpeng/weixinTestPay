@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            考试详情
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.exam_logs.show_fields')
                    <a href="{!! route('examLogs.index') !!}" class="btn btn-default">返回</a>
                </div>
            </div>
        </div>
        <?php $topics = $examLog->detail()->paginate(defaultPage());?>
        @if(count($topics))
            <div class="box box-primary">
                <div class="box-body">
                  <h4>考试题目详情</h4>
                  <table class="table table-responsive" id="examLogs-table">
                            <thead>
                                <tr>
                                <th>试题</th>
                                <th>选项</th>
                                <th>正确/错误</th>
                                {{--     <th colspan="3">操作</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($topics as $topic)
                                <?php $topic_item =  $topic->topic()->first();?>
                                @if(!empty($topic_item))
                                    <tr>
                                        <td>{!! $topic_item->name !!}</td>
                                        <td>{!! !empty($topic->result) ? select_sort($topic->result) : '没有选'  !!}</td>
                                        <td>{!! empty($topic->correct) ? '错误' : '正确' !!}</td>
                                    </tr>
                                         <?php $selections = $topic_item->selections()->orderBy('sort','asc')->get();?>
                                    @if(count($selections))
                                        @foreach ($selections as $selection)
                                            <tr>
                                                <td>&nbsp;&nbsp;{!! tag('['.$selection->type.']','orange') !!}{!! $selection->letter !!}.{!! $selection->name.$selection->attach_url !!} @if($selection->is_result) {!! tag('√','green') !!} @endif @if(!$topic->correct && $topic->result == $selection->sort) {!! tag('╳') !!} @endif</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                            </tbody>
                    </table>
                </div>
                <div class="text-center">{!! $topics->appends('')->links() !!}</div>
            </div>
        @endif
    </div>
@endsection
