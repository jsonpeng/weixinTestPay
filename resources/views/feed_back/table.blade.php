<table class="table table-responsive" id="feedBack-table">
    <thead>
        <tr>
        <th>问题/意见</th>
        <th>问题截图</th>
        <th>联系方式</th>
        <th>评分</th>
        <th>发布人</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($feedBack as $feedBack)
        <tr>
            <td>{!! $feedBack->content !!}</td>
            <td><img src="{!! $feedBack->question_img !!}" style="min-width: 100px;height: auto;" /></td>
            <td>{!! $feedBack->commit !!}</td>
            <td>{!! $feedBack->grade !!}</td>
            <td>{!! optional(user_by_id($feedBack->user_id))->nickname !!}</td>
            <td>
                {!! Form::open(['route' => ['feedBack.destroy', $feedBack->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
              {{--       <a href="{!! route('feedBack.show', [$feedBack->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('feedBack.edit', [$feedBack->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>