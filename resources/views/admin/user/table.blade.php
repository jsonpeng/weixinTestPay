<table class="table table-responsive" id="users-table">
    <thead>
        <tr>
        <th>头像</th>
        <th>微信昵称</th>
        <th>手机号</th>
        <th>注册职位</th>
        <th>当前套餐</th>
        <th>注册时间</th>
        <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
    <?php $packages = $user->packages()->orderBy('created_at','desc')->get();?>
        <tr>
            <td><img src="{!! $user->head_image !!}"  style="max-width: 100%;height: 80px;"/></td>
            <td>{!! $user->nickname !!}</td>
            <td>{!! $user->mobile !!}</td>
            <td>{!! $user->job !!}</td>
            <td>
                @if(count($packages))
                    @foreach ($packages as $item)
                        <a >{!!  a_link($item->package_name,'javascript:;') !!} </a>
                    @endforeach
                @endif
              </td>
            <td>{!! $user->created_at !!}</td>
            <td>
       
                <div class='btn-group'>
                     <a href="/zcjy/examLogs?user_id={!! $user->id !!}" target="_blank" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i>查看考试记录</a> 

                     <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>重置职位', ['type' => 'button', 'class' => 'btn btn-danger btn-xs resetUser', 'onclick' => "resetUser(".$user->id.")"]) !!}
                </div>
            
            </td>
        </tr>
    @endforeach
    </tbody>
</table>