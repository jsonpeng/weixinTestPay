<table class="table table-responsive" id="examLogs-table">
    <thead>
        <tr>
        <th>考试科目</th>
        <th>考试结果</th>
        <th>考试人</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($examLogs as $examLog)
        <tr>
            <td>{!! $examLog->subject_name !!}</td>
            <td>{!! $examLog->result !!}</td>
            <td>{!! optional(user_by_id($examLog->user_id))->nickname !!}</td>
            <td>
                {!! Form::open(['route' => ['examLogs.destroy', $examLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('examLogs.show', [$examLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i>查看详情</a>
              {{--       <a href="{!! route('examLogs.edit', [$examLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>