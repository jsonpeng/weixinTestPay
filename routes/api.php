<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
		/**
		 * 微信授权登陆
		 */
		$api->group(['middleware' => ['api'] ], function($api){
			### 微信授权
			$api->get('weixin_auth',  'App\Http\Controllers\API\AuthController@weixinAuth');
			### 微信授权callback
		 	$api->get('weixin_auth_callback',  'App\Http\Controllers\API\AuthController@weixinAuthCallback');
		 	### 微信支付通知
		 	$api->any('weixin_notify_pay','App\Http\Controllers\API\CommonController@payWechatNotify');
		 	### 通过token获取解码后的token
		 	$api->get('test_token','App\Http\Controllers\API\CommonController@testToken');
		 	### 支付宝支付通知
	 		$api->any('alipay_notify','App\Http\Controllers\API\CommonController@alipayWebNotify');
		 	### 支付宝支付同步
	 		$api->any('alipay_return','App\Http\Controllers\API\CommonController@alipayWebReturn');
	 	});

		$api->group(['middleware' => ['acces','api'] ], function($api){
		 	### 微信分享
		 	$api->get('weixin_share','App\Http\Controllers\API\AuthController@weixinShare');
		 	### 微信客服信息
		 	$api->get('weixin_ser','App\Http\Controllers\API\CommonController@weixinSer');
			### 测试接口
			$api->get('test_login', 'App\Http\Controllers\API\CommonController@testLoginUser');
			### 横幅
			$api->get('banners/{slug}','App\Http\Controllers\API\CommonController@banners');
			### 热门发现
			$api->get('hot_posts','App\Http\Controllers\API\CommonController@posts');
			### 文章详情
			$api->get('hot_posts/{post_id}','App\Http\Controllers\API\CommonController@postDetail');
			### 通知消息
			$api->get('messages','App\Http\Controllers\API\CommonController@messages');
			### 通知消息详情
			$api->get('message/{id}','App\Http\Controllers\API\CommonController@message');
			### 搜索题目
			$api->get('search_topics','App\Http\Controllers\API\WorkController@searchTopics');

			### 获取纠错信息列表
			$api->get('get_errors','App\Http\Controllers\API\CommonController@getErrorListAction');

			$api->post('uploads','App\Http\Controllers\API\CommonController@uploadsFile');

				$api->group(['middleware' => 'zcjy_api_user'], function ($api) {
					### 获取接口密钥
					$api->get('get_key','App\Http\Controllers\API\CommonController@getKeyByToken');
				});
			
				### 登录后才能使用
				$api->group(['middleware' => ['zcjy_api_user']], function ($api) {

						### 提交反馈信息
						$api->get('submit_feedback','App\Http\Controllers\API\CommonController@submitFeedBack');

						### 提交纠错信息
						$api->get('submit_topic_mistake','App\Http\Controllers\API\CommonController@submitTopicMistake');
						
						### 发送短信验证码
						$api->get('send_code','App\Http\Controllers\API\CommonController@sendCode');
						### 获取用户信息
						$api->get('me', 'App\Http\Controllers\API\CommonController@meInfo');
						
						### 注册为会员
						$api->get('reg_member','App\Http\Controllers\API\CommonController@regMember');

						### 获取所有职位
						$api->get('get_jobs','App\Http\Controllers\API\WorkController@getJobs');

						### 获取科目
						$api->get('get_subject/{job_id}','App\Http\Controllers\API\WorkController@getSubjects');
						
						### 获取科目下的章节
						$api->get('get_sections/{subject_id}','App\Http\Controllers\API\WorkController@getSections');

						### 发起套餐购买
						$api->get('buy_package','App\Http\Controllers\API\CommonController@buyPackage');

						### 发起套餐支付
						$api->get('pay_package/{id}','App\Http\Controllers\API\CommonController@payPackage');
						### 查看题目记录
						$api->get('see','App\Http\Controllers\API\CommonController@seeTopic');
						### 查看对应职位下的考试记录
						$api->get('get_job_test_log/{job_id}','App\Http\Controllers\API\WorkController@getJobRollbackTopics');
						### 根据考试记录id查到习题详情状况 
						$api->get('get_topic_by_exam_id/{exam_id}','App\Http\Controllers\API\WorkController@getTopicsDetailByTestId');

						### 根据科目id和章节序号获取题目总量
						$api->get('get_topics_sum', 'App\Http\Controllers\API\WorkController@getTopicsSum');

						### 绑定手机号和选择职位后才能使用
						$api->group(['middleware' => 'zcjy_api_member'], function ($api) {
				
							### 获取题目 批量
							$api->get('get_topics', 'App\Http\Controllers\API\WorkController@getTopics');

							### 根据序号获取题目
							$api->get('get_sort_topic','App\Http\Controllers\API\WorkController@getSortTopic');

							### 自动组卷
							$api->get('auto_group_topics/{subject_id}','App\Http\Controllers\API\WorkController@autoGroupTopics');
							### 用户提交试卷submitPaper
							$api->get('submit_paper','App\Http\Controllers\API\CommonController@submitPaper');
							$api->post('submit_paper','App\Http\Controllers\API\CommonController@submitPaper');
						});

				});
		});
});