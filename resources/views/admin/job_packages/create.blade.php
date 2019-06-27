@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           为{!! a_link($job->name,route('jobs.edit',$job->id)) !!}添加套餐
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['jobPackages.store',$job->id]]) !!}

                        @include('admin.job_packages.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
