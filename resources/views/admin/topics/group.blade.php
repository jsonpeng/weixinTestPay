@extends('layouts.app_tem')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">请选择以下题目为子组题</h1>
   
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                 @if(count($topics))
                 <a class="select_all">全选</a>
                 <table class="table table-responsive" id="topics-table">
                        <thead>
                            <tr>
                            <th>序号</th>
                            <th>题目类型</th>
                            <th>题目名称</th>
                            <th>附加文件地址</th>
                            <th>分值</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($topics as $topic)
                            <tr data-id="{!! $topic->id !!}">
                                <td>{!! $topic->num_sort !!}</td>
                                <td>{!! $topic->type !!}</td>
                                <td>{!! $topic->name !!}</td>
                                <td>{!! $topic->attach_url !!}</td>
                                <td>{!! $topic->value !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>
                @else
                <h1 class="text-center">这里空空如也...</h1>
                @endif
            </div>
        
              
             <div class="pull-left" style="margin-top:15px;">
                 <input type="button" class="btn btn-primary"  value="确定" id="rec">
             </div>
              
        
        </div>
        <div class="text-center">
            {!! $topics->appends($input)->links() !!}
        </div>
    </div>
@endsection


@section('scripts')
<script type="text/javascript">
$('.select_all').click(function(){
    $('tbody > tr').toggleClass('trSelected');
});
//选择
$('tr').click(function(){
   $(this).toggleClass('trSelected');
});

//恢复 删除点击后
$('#rec').click(function(){
    var action = actionFunc();
    if(action){
        javascript:window.parent.call_back_by_topic_action_group(action);
    }
});

function actionFunc(){
         var topic_arr=[];
         var selected=$('tr').hasClass('trSelected');
            if(!selected){
               layer.alert('请选择题目', {icon: 2}); 
               return false;
            }
            $('tr').each(function(){
                if($(this).hasClass('trSelected')){
                   topic_arr.push($(this).data('id'));
                   console.log(topic_arr);
                }
                else{
                    $(this).remove();
                }
            });
            return topic_arr;
}
// javascript:window.parent.call_back_by_one();
</script>
@endsection



