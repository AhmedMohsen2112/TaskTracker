<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar md-shadow-z-2-i  navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        @if(!$sidebar_close)
        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            @else
            <ul class="page-sidebar-menu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                @endif
                <!--<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">-->
                <li class="{{request()->path()=='apanel'?'start active':''}}">
                    <a href="{{route('admin.dashboard')}}">
                        <!--<i class="icon-home"></i>-->
                        <i class="fa fa-home"></i>
                        <span class="title">{{t('dashboard')}}</span>
                    </a>
                </li>
            


                <li class="{{request()->segment(2)=='users'?'start active':''}}">
                    <a href="{{route('admin.users.index')}}">
                        <!--<i class="icon-home"></i>-->
                        <i class="fa fa-users"></i>
                        <span class="title">{{t('users')}}</span>
                    </a>
                </li>
                <li class="{{request()->segment(2)=='profile'?'start active':''}}">
                    <a href="{{route('admin.profile.index')}}">
                        <!--<i class="icon-home"></i>-->
                        <i class="fa fa-user"></i>
                        <span class="title">{{t('profile')}}</span>
                    </a>
                </li>
                <li class="{{request()->segment(2)=='boards'?'start active':''}}">
                    <a href="{{route('admin.boards.index')}}">
                        <!--<i class="icon-home"></i>-->
                        <i class="fa fa-user"></i>
                        <span class="title">{{t('boards')}}</span>
                    </a>
                </li>

            



            </ul>
            <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->