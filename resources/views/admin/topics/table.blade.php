<table class="table table-responsive" id="topics-table">
    <thead>
        <tr>
        <th>题目类型</th>
        <th>题组类型</th>
        <th>序号</th>
        <th>实际类型</th>
        <th>听力可选类型</th>
{{--         <th>航区类型</th> --}}
      {{--   <th>问题内容</th> --}}
        {{-- <th>问题音频地址</th> --}}
        <th>题目名称</th>
 {{--        <th>题干附加文件地址</th>
        <th>选项音频地址</th> --}}
        <th>分值</th>
            <th colspan="4">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($topics as $topic)
        <tr>
            <td>{!! $topic->topic_type !!}</td>
            <td>@if($topic->group && $topic->group_type == 1)
                <span style="color:red">[首个组题]</span>
                @elseif($topic->group && $topic->group_type == 2)
                  &nbsp;&nbsp;<span style="color:red">[子组题]</span>
                @else
                    [单题]
                @endif </td>
            <td>{!! $topic->num_sort !!}</td>
            <td>{!! $topic->type !!}</td>
            <td>@if($topic->union_type == 0) 普通无可选 @elseif($topic->union_type == 1) 题干显示 问题显示（对话和短文有问题，单句只有题干） 选项显示（单句、对话、短文都显示）@elseif($topic->union_type == 2) 题干隐藏 问题隐藏 选项隐藏（单句的选项隐藏，对话和短文的选项显示—甲类无限航区 @elseif($topic->union_type == 3) 题干隐藏 问题显示（对话和短文的问题也显示） 选项显示(单句、对话和短文的选项都显示)—丙类沿海航区 @endif</td>
  {{--           <td>@if($topic->other_type == 0) 普通无可选 @endif </td> --}}
            {{-- <td>{!! $topic->question !!}</td> --}}
        {{--     <td>{!! $topic->attach_sound_url !!}</td> --}}
            <td>{!! $topic->name !!}</td>
            {{-- <td>{!! $topic->attach_url !!}</td> --}}
          {{--   <td>{!! $topic->selection_sound_url !!}</td> --}}
            <td>{!! $topic->value !!}</td>
            <td>
                {!! Form::open(['route' => ['topics.destroy', $topic->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <?php $sort = ($topic->selections()->count())+1 ;?>
                        <a href="javascript:;" class='btn btn-default btn-xs add_select' data-action="create" data-topicid="{!! $topic->id !!}" data-numsort="{!! $topic->num_sort !!}" data-sort="{!!  $sort !!}" data-letter="{!! select_sort($sort) !!}"><i class="glyphicon glyphicon-plus"></i>添加选项</a>
                        @if(!$topic->group)<a href="topic/{!! $topic->id !!}/updateGroup" class='btn btn-default btn-xs'>更新为题组</a>@endif
                        @if($topic->group && $topic->group_type)<a href="topic/{!! $topic->id !!}/updateGroup/cancle" class='btn btn-default btn-xs'>取消组题</a>@endif
                        @if($topic->group && $topic->group_type == 1)<a class='btn btn-default btn-xs joinGroup' data-url="/zcjy/topic/group?subject_id={{ $subject->id }}&sec={{ $sec }}" data-id="{!! $topic->id !!}"><i class="glyphicon glyphicon-plus"></i>添加子题</a>@endif
                        <a href="{!! route('topics.edit', [$topic->id]).'?subject_id='.$subject->id.'&sec='.$sec !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('该题目下的选项都会被删除,确定删除吗?')"]) !!}
                    </div>
                {!! Form::close() !!}
            </td>
        </tr>
        <?php $selections = $topic->selections()->orderBy('sort','asc')->get();?>
        @if(count($selections))
            @foreach ($selections as $selection)
                <tr>
                    <td>&nbsp;&nbsp;{!! tag('['.$selection->type.']','orange') !!}{!! $selection->letter !!}.{!! $selection->name.$selection->attach_url !!} @if($selection->is_result) {!! tag('√') !!} @endif</td>
                    <td><a href="javascript:;" class='btn btn-default btn-xs add_select' data-action="update" data-id="{!! $selection->id !!}" data-topicid="{!! $topic->id !!}" data-type="{!! $selection->type !!}" data-attachurl="{!! $selection->attach_url !!}" data-numsort="{!! $topic->num_sort !!}" data-result="{!! $selection->is_result !!}" data-sort="{!!  $selection->sort !!}" data-letter="{!!  $selection->letter !!}" data-name="{!! $selection->name !!}"><i class="glyphicon glyphicon-edit"></i>编辑选项</a></td>
                </tr>
            @endforeach
        @endif
    @endforeach
    </tbody>
</table>


<div id="import_box" style="display: none;">
    <div style='width:350px; padding: 0 15px;height: 100%;'>
        <form id="import_form" class="import_class">
            <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback attach' style="">
                 <label>上传Excel文件:</label>
                 <div class="input-append type_files" style="">
                      <a href="javascript:;"  class="btn upload_file" type="button" >请把要导入的Excel文件拖动到这</a>
                      {{-- <a href="">打开excel预览</a> --}}
                 </div>
            </div>
            <input type="hidden" name="excel_path" value="">
            <input type="hidden" name="subject_id" value="{!! $subject->id !!}">
            <input type="hidden" name="sec" value="{!! $sec !!}">

            <button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;display: none;' type='button' class='btn btn-block btn-primary' onclick='startImport()'>开始导入</button>
        </form>

    

    </div>
</div>


<div id="select_box" style="display: none;">
    <div style='width:350px; padding: 0 15px;height: 100%;'>
     {!! Form::open(['route' => ['selections.store'], 'method' => 'post','id'=>'select_form']) !!}
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>选项:</label>
            <input class='form-control' type='text' name='letter' value='A' readonly="readonly" />
        </div>

        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
            <label>选项类型:</label>
            <select name="type" class="form-control">
                   <option value="文本">文本</option>
                   <option value="音频">音频</option>
                   <option value="图片">图片</option>
            </select>
        </div>
        
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback name'>
             <label>选项描述:</label>
             <input class='form-control' type='text' placeholder="请输入选项描述" name='name' value='' onkeyup="selectNameSave(this)" />
        </div>
        
        <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback attach' style="display: none;">
            <label>上传附件:</label>
             <div class="input-append type_files" style="display: none;">
                  <a href="javascript:;"  class="btn upload_file" type="button" >请把文件拖动到这里上传</a>
                  <img src="" style="max-width: 100%; max-height: 160px; margin-top:-60px;display: block;" />
                  <audio src="" controls="controls" style="display:none;"> </audio>
             </div>
        </div>
        <input name="_method" type="hidden" value="post">
        <input type="hidden" name="attach_url" value="">
        <input type="hidden" name="sort" value="">
        <input type="hidden" name="topic_id" value="">
        <input type="hidden" name="subject_id" value="{!! $subject->id !!}">
        <input type="hidden" name="sec" value="{!! $sec !!}">
            <div style='width:320px;padding: 0px 0px 0px 0px;' class='form-group has-feedback'>
                <label>是否设置为答案:</label>
                <select name="is_result" class="form-control">
                    <option value="0">否</option>
                   <option value="1">是</option>
                </select>
            </div> 
        {!! Form::close() !!}

        <button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary' onclick='saveSelectInfo()'>保存</button>

    </div>
</div>
