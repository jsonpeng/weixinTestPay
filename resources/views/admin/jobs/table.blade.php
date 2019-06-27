<table class="table table-responsive" id="jobs-table">
    <thead>
        <tr>
        <th>职位名称</th>
        <th>排序权重</th>
        <th>前端显示</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($jobs as $job)
        <tr>
            <td>{!! $job->name !!}</td>
            <td>{!! $job->sort !!}</td>
            <td>{!! $job->is_show ? '显示' : '不显示' !!}</td>
            <td>
                {!! Form::open(['route' => ['jobs.destroy', $job->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('jobPackages.index', [$job->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-plus"></i>管理套餐</a>
                    <a href="{!! route('jobSubjects.index', [$job->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-plus"></i>管理科目</a>
                    <a href="{!! route('jobs.edit', [$job->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除该职位吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        <?php $packages = $job->packages()->orderBy('month','asc')->get();?>
        @if(count($packages))
            @foreach ($packages as $item)
               <tr> 
                <td>&nbsp;&nbsp;{!! $item->job_name !!}[{!! $item->month !!}个月{!! $item->price !!}元]</td>
               </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>