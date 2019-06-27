@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑{!! a_link($job->name,route('jobs.edit',$job->id)) !!}的科目
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($jobSubject, ['route' => ['jobSubjects.update', $jobSubject->id,$job->id], 'method' => 'patch']) !!}

                        @include('admin.job_subjects.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection