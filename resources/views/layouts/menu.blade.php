
<li class="header">系统</li>
  <li class="treeview @if(Request::is('zcjy/settings/setting*') || Request::is('zcjy')  || Request::is('zcjy/wechat/menu*') || Request::is('zcjy/wechat/reply*') || Request::is('zcjy/users*') || Request::is('zcjy/cities*')) active @endif " >
    <a href="#">
      <i class="fa fa-cog"></i>
      <span>系统管理</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

        <li class="{{ Request::is('zcjy/settings/setting*') || Request::is('zcjy') ? 'active' : '' }}">
            <a href="{!! route('settings.setting') !!}"><i class="fa fa-cog"></i><span>系统设置</span></a>
        </li>
        
        <li class="{{ Request::is('zcjy/wechat/menu*') || Request::is('zcjy/wechat/reply*') ? 'active' : '' }}">
            <a href="{!! route('wechat.menu') !!}"><i class="fa fa-commenting"></i><span>微信设置</span></a>
        </li>

        <li class="{{ Request::is('zcjy/users*') ? 'active' : '' }}">
            <a href="{!! route('users.index') !!}"><i class="fa fa-user"></i><span>用户管理</span></a>
        </li>

    </ul>
</li>
<li class="header">职位课程管理</li>
<li class="{{ Request::is('zcjy/jobs*') || Request::is('zcjy/*/jobPackages*') || Request::is('zcjy/*/jobSubjects*') || Request::is('zcjy/topics*') ? 'active' : '' }}">
    <a href="{!! route('jobs.index') !!}"><i class="fa fa-edit"></i><span>职位课程管理</span></a>
</li>
<li class="header">记录管理</li>
<li class="{{ Request::is('zcjy/userBuyLogs*') ? 'active' : '' }}">
    <a href="{!! route('userBuyLogs.index') !!}"><i class="fa fa-check-circle-o"></i><span>用户购买记录</span></a>
</li>
<li class="{{ Request::is('zcjy/examLogs*') ? 'active' : '' }}">
    <a href="{!! route('examLogs.index') !!}"><i class="fa fa-area-chart"></i><span>用户考试记录</span></a>
</li>
<li class="{{ Request::is('zcjy/feedBack*') ? 'active' : '' }}">
    <a href="{!! route('feedBack.index') !!}"><i class="fa fa-edit"></i><span>意见反馈记录</span></a>
</li>
<li class="{{ Request::is('zcjy/topicMistakes*') ? 'active' : '' }}">
    <a href="{!! route('topicMistakes.index') !!}"><i class="fa fa-edit"></i><span>题目纠错记录</span></a>
</li>

 <li class="header">内容管理</li>
<li class="treeview @if(Request::is('zcjy/categories*') || Request::is('zcjy/posts*') || Request::is('zcjy/customPostTypes') || Request::is('zcjy/*/customPostTypeItems*') || Request::is('zcjy/banners*') || Request::is('zcjy/*/bannerItems') || Request::is('zcjy/messages*')) active @endif " >
  <a href="#">
    <i class="fa fa-pie-chart"></i>
    <span>内容管理</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li class="{{ Request::is('zcjy/banners*') || Request::is('zcjy/*/bannerItems') ? 'active' : '' }}">
        <a href="{!! route('banners.index') !!}"><i class="fa fa-object-group"></i><span>横幅管理</span></a>
    </li> 
    <li class="{{ Request::is('zcjy/posts*') ? 'active' : '' }}">
        <a href="{!! route('posts.index') !!}"><i class="fa fa-newspaper-o"></i><span>热门发现</span></a>
    </li>
    <li class="{{ Request::is('zcjy/messages*') ? 'active' : '' }}">
        <a href="{!! route('messages.index') !!}"><i class="fa fa-commenting"></i><span>通知消息</span></a>
    </li>
  </ul>
</li>
{{-- <li class="header">统计</li>
<li class="{{ Request::is('zcjy/statics*') ? 'active' : '' }}">
    <a href="{!! route('statics.errand') !!}"><i class="fa fa-pie-chart"></i><span>校购统计</span></a>
</li>



<li class="header">校购</li>
  <li class="treeview @if(Request::is('zcjy/taskTems*') || Request::is('zcjy/errandTasks*') || Request::is('zcjy/schools*') || Request::is('zcjy/errandErrors*')) active @endif " >
    <a href="#">
      <i class="fa fa-cog"></i>
      <span>校购管理</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li class="{{ Request::is('zcjy/taskTems*') ? 'active' : '' }}">
          <a href="{!! route('taskTems.index') !!}"><i class="fa fa-edit"></i><span>任务模板描述管理</span></a>
      </li>
      <li class="{{ Request::is('zcjy/errandTasks*') ? 'active' : '' }}">
          <a href="{!! route('errandTasks.index') !!}"><i class="fa fa-edit"></i><span>跑腿任务管理</span></a>
      </li>
      <li class="{{ Request::is('zcjy/schools*') ? 'active' : '' }}">
          <a href="{!! route('schools.index') !!}"><i class="fa fa-edit"></i><span>使用校购的学校</span></a>
      </li>
      <li class="{{ Request::is('zcjy/errandErrors*') ? 'active' : '' }}">
          <a href="{!! route('errandErrors.index') !!}"><i class="fa fa-commenting-o"></i><span>投诉列表</span></a>
      </li>
     </ul>
   </li>

<li class="{{ Request::is('zcjy/withDrawalLogs*') ? 'active' : '' }}">
    <a href="{!! route('withDrawalLogs.index') !!}"><i class="fa fa-archive"></i><span>用户提现记录</span></a>
</li>

<li class="{{ Request::is('zcjy/feedBack*') ? 'active' : '' }}">
    <a href="{!! route('feedBack.index') !!}"><i class="fa fa-commenting-o"></i><span>意见反馈</span></a>
</li> --}}

<li class="">
    <a href="javascript:;" id="refresh"><i class="fa fa-refresh"></i><span>清理缓存</span></a>
</li>


{{-- <li class="{{ Request::is('jobPackages*') ? 'active' : '' }}">
    <a href="{!! route('jobPackages.index') !!}"><i class="fa fa-edit"></i><span>Job Packages</span></a>
</li> --}}

{{-- <li class="{{ Request::is('jobSubjects*') ? 'active' : '' }}">
    <a href="{!! route('jobSubjects.index') !!}"><i class="fa fa-edit"></i><span>Job Subjects</span></a>
</li> --}}

{{-- <li class="{{ Request::is('sections*') ? 'active' : '' }}">
    <a href="{!! route('sections.index') !!}"><i class="fa fa-edit"></i><span>Sections</span></a>
</li> --}}

{{-- <li class="{{ Request::is('topics*') ? 'active' : '' }}">
    <a href="{!! route('topics.index') !!}"><i class="fa fa-edit"></i><span>Topics</span></a>
</li>
 --}}
{{-- <li class="{{ Request::is('selections*') ? 'active' : '' }}">
    <a href="{!! route('selections.index') !!}"><i class="fa fa-edit"></i><span>Selections</span></a>
</li> --}}

{{-- <li class="{{ Request::is('userSeeLogs*') ? 'active' : '' }}">
    <a href="{!! route('userSeeLogs.index') !!}"><i class="fa fa-edit"></i><span>User See Logs</span></a>
</li>
 --}}


{{-- <li class="{{ Request::is('userPackages*') ? 'active' : '' }}">
    <a href="{!! route('userPackages.index') !!}"><i class="fa fa-edit"></i><span>User Packages</span></a>
</li>
 --}}

{{-- 
<li class="{{ Request::is('examTopicDetails*') ? 'active' : '' }}">
    <a href="{!! route('examTopicDetails.index') !!}"><i class="fa fa-edit"></i><span>Exam Topic Details</span></a>
</li> --}}





