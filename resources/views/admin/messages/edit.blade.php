@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑通知消息
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($messages, ['route' => ['messages.update', $messages->id], 'method' => 'patch']) !!}

                        @include('admin.messages.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $('input,textarea').numberInputLimit(191);
</script>
@endsection
