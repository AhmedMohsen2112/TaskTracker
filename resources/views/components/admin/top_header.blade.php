<div class="page-header-inner">
    <!-- BEGIN LOGO -->
    <div class="page-logo">
        <a href="{{route('admin.dashboard')}}">
            <!--<img src="{{admin_img('logo.jpg')}}" style="width: 100px;height:40px;margin-top: 15px;" alt="logo" class="logo-default"/>-->
       
        </a>
        <div class="menu-toggler sidebar-toggler">
            <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
        </div>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    </a>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <!-- BEGIN PAGE ACTIONS -->
    <!-- DOC: Remove "hide" class to enable the page header actions -->
    <div class="page-actions">


<!--        <div class="btn-group">
            <button type="button" class="btn btn-circle red-pink dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-adjust"></i>&nbsp;<span class="hidden-sm hidden-xs">{{t('language')}}&nbsp;</span>&nbsp;<i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="" class="change-lang" data-locale="ar"> {{t('arabic')}}</a>
                    <a href="" class="change-lang" data-locale="en"> {{t('english')}}</a>
                </li>



            </ul>
        </div>
    -->
        



    </div>
    <!-- END PAGE ACTIONS -->
    <!-- BEGIN PAGE TOP -->
    <div class="page-top">
        <!-- BEGIN HEADER SEARCH BOX -->
        <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
       
        <!-- END HEADER SEARCH BOX -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-extended dropdown-notification header-noti" id="header_notification_bar" data-all-noti-count="{{$all_noti_count}}">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i>
                        <span class="badge badge-default notfication-counter noti-count"> {{$unread_noti_count}} </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>
                                <span class="bold notfication-counter noti-count">{{$unread_noti_count}}</span> notifications</h3>
                                <a href="{{route('admin.notifications.index')}}">{{t('view_all')}}</a>

                        </li>
                        <style>
                            .un-read-noti{
                                background-color: #f7f7f7;
                            }
                        </style>
                        <li>
                            <ul class="dropdown-menu-list noti-scroller" style="overflow-y: auto;height: 275px;" data-handle-color="#637283">

                                @foreach($notifications as $one)
                                <li class="header-noti-li {{$one->read_status==0?'un-read-noti':''}}">
                                    <a href="{{route('admin.notifications.view',['id'=>$one->noti_object_id])}}" class="noti-li">
                                        <span class="time"> {{$one->created_at}}</span>
                                        <span class="details">
                                            <span class="label label-sm label-icon label-success">
                                                <i class="fa fa-bell-o"></i>
                                            </span>
                                            {{$one->message}} </span>
                                    </a>
                                </li>
                                @endforeach


                            </ul>
                        </li>

                    </ul>
                </li>
                <!-- BEGIN NOTIFICATION DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <!--                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <i class="icon-bell"></i>
                                        <span class="badge badge-default">
                                            7 </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="external">
                                            <h3><span class="bold">12 pending</span> notifications</h3>
                                            <a href="extra_profile.html">view all</a>
                                        </li>
                                        <li>
                                            <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">just now</span>
                                                        <span class="details">
                                                            <span class="label label-sm label-icon label-success">
                                                                <i class="fa fa-plus"></i>
                                                            </span>
                                                            New user registered. </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="time">3 mins</span>
                                                        <span class="details">
                                                            <span class="label label-sm label-icon label-danger">
                                                                <i class="fa fa-bolt"></i>
                                                            </span>
                                                            Server #12 overloaded. </span>
                                                    </a>
                                                </li>
                                              
                                            </ul>
                                        </li>
                                    </ul>
                                </li>-->
                <!-- END NOTIFICATION DROPDOWN -->
                <!-- BEGIN INBOX DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <!--                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <i class="icon-envelope-open"></i>
                                        <span class="badge badge-default">
                                            4 </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="external">
                                            <h3>You have <span class="bold">7 New</span> Messages</h3>
                                            <a href="page_inbox.html">view all</a>
                                        </li>
                                        <li>
                                            <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                                <li>
                                                    <a href="inbox.html?a=view">
                                                        <span class="photo">
                                                            <img src="../../assets/admin/layout3/img/avatar2.jpg" class="img-circle" alt="">
                                                        </span>
                                                        <span class="subject">
                                                            <span class="from">
                                                                Lisa Wong </span>
                                                            <span class="time">Just Now </span>
                                                        </span>
                                                        <span class="message">
                                                            Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="inbox.html?a=view">
                                                        <span class="photo">
                                                            <img src="../../assets/admin/layout3/img/avatar3.jpg" class="img-circle" alt="">
                                                        </span>
                                                        <span class="subject">
                                                            <span class="from">
                                                                Richard Doe </span>
                                                            <span class="time">16 mins </span>
                                                        </span>
                                                        <span class="message">
                                                            Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                                    </a>
                                                </li>
                                               
                                            </ul>
                                        </li>
                                    </ul>
                                </li>-->
                <!-- END INBOX DROPDOWN -->
                <!-- BEGIN TODO DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <!--                <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <i class="icon-calendar"></i>
                                        <span class="badge badge-default">
                                            3 </span>
                                    </a>
                                    <ul class="dropdown-menu extended tasks">
                                        <li class="external">
                                            <h3>You have <span class="bold">12 pending</span> tasks</h3>
                                            <a href="page_todo.html">view all</a>
                                        </li>
                                        <li>
                                            <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="task">
                                                            <span class="desc">New release v1.2 </span>
                                                            <span class="percent">30%</span>
                                                        </span>
                                                        <span class="progress">
                                                            <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">40% Complete</span></span>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <span class="task">
                                                            <span class="desc">Application deployment</span>
                                                            <span class="percent">65%</span>
                                                        </span>
                                                        <span class="progress">
                                                            <span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">65% Complete</span></span>
                                                        </span>
                                                    </a>
                                                </li>
                
                                            </ul>
                                        </li>
                                    </ul>
                                </li>-->
                <!-- END TODO DROPDOWN -->
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src=""/>
                        <span class="username">
                            {{$User->username}} </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        </li>

                        <li>
                            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-arrow-circle-o-left"></i> {{t('logout')}} 
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END PAGE TOP -->
</div>
<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
     {{ csrf_field() }}
</form>