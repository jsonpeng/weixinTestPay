@section('scripts')
<script type="text/javascript">
	//点击添加和编辑
	$('.edit_section').click(function(){
		if($(this).data('type') == 'update'){
			var title = '修改科目'+$(this).data('subjectname')+'第'+$(this).data('sort')+'章节';
			var request_url = '/zcjy/'+$(this).data('id')+'/updateSections';
		}
		else{
			var title = '为科目'+$(this).data('subjectname')+'添加第'+$(this).data('nextsec')+'章节';
			var request_url = '/zcjy/createSections';
		}
		layer.open({
            type: 1,
            closeBtn: false,
            shift: 7,
            shadeClose: true,
            title:title,
            content: $('#section_box_update').html()
        	});
		 	$('#section_form_update').attr('action',request_url)
	    	$('input[name=subjectname]').val($(this).data('subjectname'));
			$('input[name=sort]').val($(this).data('sort'));
			$('input[name=name]').val($(this).data('name'));
			$('input[name=subject_id]').val($(this).data('subjectid'));
			$('input[name=get_num]').val($(this).data('num'));
	    
	});

	//提交保存表单
	function saveSectionInfo(){
		if($('input[name=name]:eq(1)').val() == ''){
			alert('请输入章节名称!');
			return;
		}
		$('#section_form_update').submit();
	}

	//输入框输入时保存输入值
	function sectionNameSave(obj){
		$('input[name=name]').val($(obj).val());
	}

	function getNumSave(obj){
		$('input[name=get_num]').val($(obj).val());
	}

	var topicId;
	function update_topics(topic_id){
		topicId = topic_id;
		layer.confirm('请选择批量更新音频类型', {
			  btn: ['轮机英语听力会话','航海英语听力会话'] //按钮
			}, function(){
			  	ajaxUpdate(1);
			}, function(){
				ajaxUpdate(2);
			});
	}

	function ajaxUpdate(type = 1){
			layer.msg('系统正在整理文件中,请耐心等待', {
              icon: 16
             ,shade: 0.01
          	});
			$.zcjyRequest('/ajax/update_topics/'+topicId+'/'+type,function(res){
			   layer.msg(res, {
                        icon: 1,
                        skin: 'layer-ext-moon' 
                        });
			   layer.closeAll();
		});
	}

	$('.delOneSec').click(function(){
			location.href = $(this).data('url'); 
	});
</script>
@endsection