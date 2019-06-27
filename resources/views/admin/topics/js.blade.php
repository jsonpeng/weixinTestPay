@section('scripts')
<script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
<script type="text/javascript">
    var rec_url = '/zcjy/topics/action?subject_id={{ $subject->id }}&sec={{ $sec }}&is_delete=1';
    $('.rec').zcjyFrameOpen(rec_url,'从当前章节批量恢复题目');
    $('.rec').click(function(){
          $('#action_form').attr('action',rec_url);
    });
    var delete_url = '/zcjy/topics/action?subject_id={{ $subject->id }}&sec={{ $sec }}&is_delete=0';
    $('.delete').zcjyFrameOpen(delete_url,'从当前章节批量删除题目');
    $('.delete').click(function(){
          $('#action_form').attr('action',delete_url);
    });

    function call_back_by_topic_action(attr_arr){
        layer.closeAll();
        $('input[name=attr_arr]').val(attr_arr);
        $('#action_form').submit();
    }

    //导入题目
    $('.import_topic').click(function(){
        layer.open({
            type: 1,
            closeBtn: false,
            shift: 7,
            shadeClose: true,
            title:'请把要导入的Excel文件拖动到这',
            content: $('#import_box').html()
        });
    });

    //开始导入题目
    function startImport(){
          layer.msg('系统正在整理题目...请耐心等待', {
              icon: 16
             ,shade: 0.01
          });
          $.zcjyRequest('/ajax/auto_generate_topic',function(res){
                if(res){
                        layer.msg(res, {
                        icon: 1,
                        skin: 'layer-ext-moon' 
                        });
                       //
                       setTimeout(function(){
                        location.reload();
                       },1000);
                    
                }
                else{
                    click_dom.find('a').text('上传失败╳,请重新上传 ');
                }
          },$('#import_form').serialize());
    }

    //为题目添加选项
    $('.add_select').click(function(){
        if($(this).data('action') == 'create'){
            var title = "序号"+$(this).data('numsort')+"的题目添加"+$(this).data('letter')+"选项";
            //处理表单提交地址
            var request_url = "/zcjy/selections";
            var method = "POST";
        
        }
        else{
            var title = "序号"+$(this).data('numsort')+"的题目编辑"+$(this).data('letter')+"选项";
            //处理表单提交地址
            var request_url = "/zcjy/selections/"+$(this).data('id');
            var method = "PATCH";
        }
        layer.open({
            type: 1,
            closeBtn: false,
            shift: 7,
            shadeClose: true,
            title:title,
            content: $('#select_box').html()
        });
       $('#select_form').attr('action',request_url)
       $('input[name=_method]').val(method);
        //处理选项 序号 topicid
       $('input[name=letter]').val($(this).data('letter'));
       $('input[name=sort]').val($(this).data('sort'));
       $('input[name=topic_id]').val($(this).data('topicid'));
       if($(this).data('action') == 'update'){
            $('select[name=type]').val($(this).data('type'));
            $('select[name=is_result]').val($(this).data('result'));
            //如果不是文本
            if($(this).data('type') != '文本'){
                    $('.attach,.type_files').show();
                    $('.name').hide();
                    if($(this).data('type')== '图片'){
                         click_dom.find('img').show().attr('src',$(this).data('attachurl'));
                         click_dom.find('audio').hide();
                    }
                    else if($(this).data('type')== '音频'){
                         click_dom.find('audio').show().attr('src',$(this).data('attachurl'));
                         click_dom.find('img').hide();
                    }
                   
            }
            else{
                   $('.attach,.type_files').hide();
                   $('.name').show();
                   $('input[name=name]').val($(this).data('name'));
            }
       }
       else{
            $('.attach,.type_files').hide();
            $('select[name=type]').val('文本');
            click_dom.find('img').attr('src','');
            click_dom.find('audio').hide().attr('src','');
            $('select[name=is_result]').val(0);
       }
    });

	//点击类型切换
    $(document).on('change','select[name=type]', function() {
        $('select[name=type]').val($(this).val());
		$('input[name=attach_url]').val('');
		$('.type_files').find('img').attr('src','');
		$('.type_files').find('audio').hide().attr('src','');
		if($(this).val() == '音频' || $(this).val() == '图片'){
			$('.attach,.type_files').show();
			$('.name').hide();
			if($(this).val() == '音频'){
				$('.type_files').find('a').text('请把音频文件拖动到这上传');
			}
			else{
				$('.type_files').find('a').text('请把图片文件拖动到这上传');
			}
		}
		else{
			$('.attach').hide();
			$('.name').show();
		}
	});

    //图片文件上传
  	var myDropzone = $(document.body).dropzone({
        url:'/ajax/upload_file',
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        addRemoveLinks:false,
        maxFiles:100,
        autoQueue: true, 
        previewsContainer: ".attach", 
        clickable: ".type_files",
        headers: {
         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        addedfile:function(file){
            console.log(file);
        },
        totaluploadprogress:function(progress){
			progress=Math.round(progress);
			click_dom.find('a').text(progress+"%");

        },
        queuecomplete:function(progress){
        	console.log(progress);
        	click_dom.find('a').text('上传完毕√');
        },
        success:function(file,data){
        	if(data.code == 0){
            	console.log('上传成功:'+data.message.src);
            	if(data.message.type == 'image'){
            		click_dom.find('img').attr('src',data.message.src);
            	}
            	else if(data.message.type == 'sound'){
            		click_dom.find('audio').show().attr('src',data.message.src);
            	}
                else if(data.message.type == 'excel'){
                    console.log($('#import_form').find('input[name=excel_path]'));
                    $('#import_form').find('input[name=excel_path]').val(data.message.current_src);
                    $('.import_class').find('button').show();
                    return;
                }
                if(click_dom.data('type') == 'question'){
                    $('input[name=attach_sound_url]').val(data.message.src);
                }
                else if(click_dom.data('type') == 'selection'){
                    $('input[name=selection_sound_url]').val(data.message.src);
                }
                else{
                    $('input[name=attach_url]').val(data.message.src);
                }
          
        	}
        	else{
        		click_dom.find('a').text('上传失败╳ ');
        		alert('文件格式不支持!');
        	}
      },
      error:function(){
      	console.log('失败');
      }
  	});

    //选中答案
    $(document).on('change','select[name=is_result]', function() {
          $('select[name=is_result]').val($(this).val());
    });

    //提交保存表单
    function saveSelectInfo(){
        var type = $('select[name=type]:eq(1)').val();
        //如果是文本
        if(type == '文本'){
            if($('input[name=name]:eq(1)').val() == ''){
                alert('请输入选项描述!');
                return;
            }
        }
        else {
        //如果是音频或者图片
            if($('input[name=attach_url]:eq(1)').val() == ''){
                alert('请先上传文件!');
                return;
            }
        }
        $('#select_form').submit();  
    }

    // 输入框输入时保存输入值
    function selectNameSave(obj){
        $('input[name=name]').val($(obj).val());
    }
    var click_dom;
    $(document).on('click','.type_files',function(){
        click_dom = $(this);
        console.log('aa');
        // $('input[type=file]').trigger('click');
    });
    var topic_id;
    //添加组题
    $('.joinGroup').click(function(){
        topic_id = $(this).data('id');
        $.zcjyFrameOpen($(this).data('url')+'&topic_id='+topic_id,'添加子组题');
    });

    function call_back_by_topic_action_group(list){
        layer.closeAll();
        location.href="/zcjy/topic/"+topic_id+"/joinGroup?group_id="+list;
    }
</script>
@endsection