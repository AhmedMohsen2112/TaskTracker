<!DOCTYPE html>
<html>
    <head>
        @include('components/admin/meta')
        @include('components/admin/meta_script')
    </head>
    @if(!$sidebar_close)
    <body class="page-md page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
        @else
        <body class="page-md page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed page-sidebar-closed-hide-logo">
        @endif
        <!-- BEGIN HEADER -->

        <div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
            <!-- BEGIN TOP HEADER INNER -->
            @include('components/admin/top_header')
            <!-- END TOP HEADER INNER -->
        </div>
        <div class="clearfix">
        </div>
        <!-- BEGIN CONTAINER -->

        <div class="page-container">
            @include('components/admin/side_bar')
            <div class="page-content-wrapper">
                <div class="page-content">
                    <!-- here settings -->
                    @yield('breadcrumb')
                    <div id="main-content">
                        @yield('content')
                    </div>

                </div>
            </div>
        </div>
        @include('components/admin/footer')


        @include('components/admin/scripts')

    </body>
</html>