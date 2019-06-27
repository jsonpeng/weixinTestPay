<table class="table table-responsive" id="jobPackages-table">
    <thead>
        <tr>
        <th>职位名称</th>
        <th>月数</th>
        <th>价格</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($jobPackages as $jobPackage)
        <tr>
            <td>{!! $jobPackage->job_name !!}</td>
       {{--      <td>{!! $jobPackage->job_id !!}</td> --}}
            <td>{!! $jobPackage->month !!}</td>
            <td>{!! $jobPackage->price !!}</td>
            <td>
                {!! Form::open(['route' => ['jobPackages.destroy', $jobPackage->id,$job->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                 {{--    <a href="{!! route('jobPackages.show', [$jobPackage->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('jobPackages.edit', [$jobPackage->id,$job->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>