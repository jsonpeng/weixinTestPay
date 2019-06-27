<table class="table table-responsive" id="userBuyLogs-table">
    <thead>
        <tr>
        <th>订单号</th>
        <th>购买人</th>
        <th>支付方式</th>
        <th>支付状态</th>
        <th>购买套餐</th>
        <th>购买金额</th>
        <th>购买职位</th>
        <th>购买时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($userBuyLogs as $userBuyLog)
        <tr>
            <td>{!! $userBuyLog->number !!}</td>
            <td>{!! optional(user_by_id($userBuyLog->user_id))->nickname !!} </td>
            <td>{!! $userBuyLog->pay_platform !!}</td>
            <td>{!! $userBuyLog->pay_status !!}</td>
            <td>{!! $userBuyLog->package_name !!}</td>
            <td>{!! $userBuyLog->price !!}</td>
            <td>{!!  optional($userBuyLog->job()->first())->name !!}</td>
            <td>{!! $userBuyLog->updated_at !!}</td>
            <td>
                {!! Form::open(['route' => ['userBuyLogs.destroy', $userBuyLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
              {{--       <a href="{!! route('userBuyLogs.show', [$userBuyLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('userBuyLogs.edit', [$userBuyLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>