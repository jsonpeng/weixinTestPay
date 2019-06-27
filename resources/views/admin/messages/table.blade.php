<table class="table table-responsive" id="messages-table">
    <thead>
        <tr>
        <th>消息名称</th>
{{--         <th>Content</th> --}}
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($messages as $messages)
        <tr>
            <td>{!! $messages->name !!}</td>
{{--             <td>{!! $messages->content !!}</td> --}}
            <td>
                {!! Form::open(['route' => ['messages.destroy', $messages->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
           {{--          <a href="{!! route('messages.show', [$messages->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('messages.edit', [$messages->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>