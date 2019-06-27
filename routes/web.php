<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function () {
    return redirect('/zcjy');
});

Route::any('/wechat', 'Admin\Wechat\WechatController@serve');

//刷新缓存
Route::post('/clearCache','Controller@clearCache');

//测试路由
Route::get('/test',function(){
	dd(app('zcjy')->autoWropTopic());
 		 // dd(chkurl('https://houtai.sdyh.top/lunji_sounds/第1章/21109.mp3'));
	//dd(public_path().'/excel/截止到2018-08-01 18-40-18预约记录.xls');
	//dd(app('zcjy')->loadExcels(public_path().'\excel\a.xls'));
	//dd(carbon_parse('2018-8-7')->lt(carbon_parse('2018-8-8')));
	//app('zcjy')->setTopicResult();
	//return app('zcjy')->TopicRepo()->manyDealTopicType();
});

//开启认证
Auth::routes();
//后台ajax操作
Route::group([ 'middleware' => ['auth.admin:admin'], 'prefix' => 'ajax'], function () {
	//上传文件
	Route::post('upload_file','AppBaseController@uploadFile');
	//自动从excel中读取信息并且生成题目
	Route::get('auto_generate_topic','AppBaseController@autoGenerateTopic');
	Route::get('update_topics/{subject_id}/{type?}','AppBaseController@doSubjectTopics');
	Route::get('reset_user/{user_id}','AppBaseController@resetUserPackage');
});
/**
 * 认证路由
 */
Route::group([ 'prefix' => 'zcjy', 'namespace' => 'Admin\Auth'], function () {
	Route::get('login', 'AdminAuthController@showLoginForm');
	Route::post('login', 'AdminAuthController@login');
	Route::get('logout', 'AdminAuthController@logout');
});



Route::group([ 'middleware' => ['auth.admin:admin'], 'prefix' => 'zcjy', 'namespace' => 'Admin'], function () {
	//首页
	Route::get('/', 'SettingController@setting');
	/**
	 * 网站设置
	 */
	Route::get('settings/setting', 'SettingController@setting')->name('settings.setting');
	Route::post('settings/setting', 'SettingController@update')->name('settings.setting.update');
	//修改密码
	Route::get('setting/edit_pwd','SettingController@edit_pwd')->name('settings.edit_pwd');
    Route::post('setting/edit_pwd/{id}','SettingController@edit_pwd_api')->name('settings.pwd_update');
    //批量导出用户
    Route::post('users/reportMany','UserController@reportMany')->name('users.reports');
    //用户管理
    Route::get('users','UserController@index')->name('users.index');
    //用户管理
    Route::get('users/edit/{id}','UserController@edit')->name('users.edit');
	//更新用户
	Route::patch('users/{id}/update','UserController@update')->name('users.update');
	
    //职位管理
	Route::resource('jobs', 'JobController');
	//职位套餐管理
	Route::resource('{job_id}/jobPackages', 'JobPackageController');
	//添加章节信息
	Route::post('createSections','JobSubjectController@createSection')->name('sections.create');
	//更新章节信息
	Route::post('{id}/updateSections','JobSubjectController@updateSection')->name('sections.update');
	//职位科目
	Route::resource('{job_id}/jobSubjects', 'JobSubjectController');
	//批量删除单个章节的所有题目
	Route::get('topic/del/{job_id}','TopicController@clearOneSecTopics')->name('topic.delonesec');
	//题目回收站 & 批量删除
	Route::get('topics/action','TopicController@action');
	//题目回收站 & 批量删除 操作 actionUpdate
	Route::post('topics/action','TopicController@actionUpdate');
	//更新题目为组题
	Route::get('topic/{id}/updateGroup/{action?}','TopicController@updateGroupType');
	//题目组
	Route::get('topic/group','TopicController@group');
	//加入为题组
	Route::get('topic/{id}/joinGroup','TopicController@joinGroup');
	//科目下的题目
	Route::resource('topics', 'TopicController');
	//题目选项管理
	Route::resource('selections', 'SelectionsController');
	//用户购买记录
	Route::resource('userBuyLogs', 'UserBuyLogController');
	//用户考试记录
	Route::resource('examLogs', 'ExamLogController');
	//提交记录
	Route::resource('feedBack', 'FeedBackController');
	//纠错记录
	Route::resource('topicMistakes', 'TopicMistakeController');

	/**
	 * 内容管理
	 */
	//横幅
	Route::resource('banners', 'BannerController');
	Route::resource('{banner_id}/bannerItems', 'BannerItemController');
	//文章
	Route::resource('posts', 'PostController');
	//通知消息
	Route::resource('messages', 'MessagesController');
    /**
     * 微信公众号功能
     */
    Route::group([ 'prefix' => 'wechat'], function () {
    	Route::group([ 'prefix' => 'menu'], function () {
			Route::get('menu', 'Wechat\MenuController@getIndex')->name('wechat.menu');
			Route::get('lists', 'Wechat\MenuController@getLists');
			Route::get('create', 'Wechat\MenuController@getCreate');
			Route::get('delete/{id}', 'Wechat\MenuController@getDelete');
			Route::get('update/{id}', 'Wechat\MenuController@getUpdate');
			Route::get('single/{id}', 'Wechat\MenuController@getSingle');
			Route::post('store', 'Wechat\MenuController@postStore');
			Route::get('update-menu-event', 'Wechat\MenuController@getUpdateMenuEvent');
		});

		Route::group([ 'prefix' => 'reply'], function () {
			Route::get('/', 'Wechat\ReplyController@getIndex');
			Route::get('index', 'Wechat\ReplyController@getIndex')->name('wechat.reply');
			Route::get('rpl-follow', 'Wechat\ReplyController@getRplFollow');
			Route::get('rpl-no-match', 'Wechat\ReplyController@getRplNoMatch');
			Route::get('follow-reply', 'Wechat\ReplyController@getFollowReply');
			Route::get('no-match-reply', 'Wechat\ReplyController@getNoMatchReply');
			Route::get('lists', 'Wechat\ReplyController@getLists');
			Route::get('save-event-reply', 'Wechat\ReplyController@getSaveEventReply');
			Route::post('store', 'Wechat\ReplyController@postStore');
			Route::get('edit/{id}', 'Wechat\ReplyController@getEdit');
			Route::post('update/{id}', 'Wechat\ReplyController@postUpdate');
			Route::get('delete/{id}', 'Wechat\ReplyController@getDelete');
			Route::get('single/{id}', 'Wechat\ReplyController@getSingle');
			Route::get('delete-event/{type}', 'Wechat\ReplyController@getDeleteEvent');
		});

		Route::group([ 'prefix' => 'material'], function () {
			Route::get('by-event-key/{key}', 'Wechat\MaterialController@getByEventKey');
		});
	});
   }
);







// Route::resource('sections', 'SectionController');




// Route::resource('userSeeLogs', 'UserSeeLogsController');



// Route::resource('userPackages', 'UserPackagesController');



// Route::resource('examTopicDetails', 'ExamTopicDetailController');


