<table class="table table-responsive" id="topicMistakes-table">
    <thead>
        <tr>
        <th>纠错题目</th>
        <th>纠错类型</th>
        <th>纠错内容</th>
        <th>问题截图</th>
        <th>联系方式</th>
        <th>发布人</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($topicMistakes as $topicMistake)
        <?php $topic = app('zcjy')->TopicRepo()->findWithoutFail($topicMistake->topic_id); ?>
        <tr>
            <td>@if(isset($topic)) {!! a_link($topic->name,route('topics.edit', [$topic->id]).'?subject_id='.$topic->subject_id.'&sec='.$topic->sec_sort) !!} @endif</td>
            <td>{!! $topicMistake->question_type !!}</td>
            <td>{!! $topicMistake->content !!}</td>
            <td><img src="{!! $topicMistake->question_img !!}" style="max-width: 200px;height: auto;" /></td>
            <td>{!! $topicMistake->commit !!}</td>
            <td>{!! optional(user_by_id($topicMistake->user_id))->nickname !!}</td>
            <td>
                {!! Form::open(['route' => ['topicMistakes.destroy', $topicMistake->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
              {{--       <a href="{!! route('topicMistakes.show', [$topicMistake->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('topicMistakes.edit', [$topicMistake->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>