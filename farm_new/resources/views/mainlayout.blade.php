<!DOCTYPE html>
<html lang="en">

@include('common.head')

<body>
<!-- START PAGE CONTAINER -->
<div class="page-container">

    @include('common.sidebar')
    <!-- PAGE CONTENT -->
    <div class="page-content">
        <!-- START X-NAVIGATION VERTICAL -->
        @include('common.header')
        <!-- END X-NAVIGATION VERTICAL -->

        <ul class="breadcrumb">

        @yield('breadcrumb')

        </ul>

        <!-- START BREADCRUMB -->
        <!--<ul class="breadcrumb">-->
        <!--    <li><a href="#">Home</a></li>-->
        <!--    <li class="active">Dashboard</li>-->
        <!--</ul>-->
        <!-- END BREADCRUMB -->

        <div class="page-content-wrap">

        @yield('maincontent')

        </div>


    </div>
    <!-- END PAGE CONTENT -->

</div>
@include('common.alert_logout')
@include('common.js')
@yield('javascript')

</body>
</html>
