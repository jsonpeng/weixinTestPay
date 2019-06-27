@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           为科目{!! a_link($subject->name,route('jobSubjects.index',$subject->job_id)) !!}第{!! tag($sec) !!}章添加题目
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'topics.store']) !!}

                        @include('admin.topics.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
     @include('admin.partials.imagemodel')
@endsection

@include('admin.topics.js')
