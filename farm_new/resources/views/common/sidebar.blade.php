@php
    use App\Role;
    //use App\School;
    //use Illuminate\Support\Facades\Cookie;
    //$school = School::all();
    //Cookie::queue('school_name_cookie', $school[0]->name, 1440);
    //Cookie::queue('school_id_cookie', $school[0]->id, 1440);
    //$segment = Request::segment(1);
    
    $userRoles = Auth::user()->roles;
    //dd($userRoles);
    $role_name = $userRoles[0]->name;
    
    $cookiename = 'userlogin_roleid';
    $role_id = Cookie::get($cookiename);
    $role = Role::findorfail($role_id);
    $role_name = $role->name;
    
    if (session()->has('user_priv')) {
        $user_priv = session()->get('user_priv');
    }
    else{
        $user_priv = array();
    }

@endphp
<div class="page-sidebar" style="background: #fff;">
    <!-- START X-NAVIGATION -->
    <ul class="x-navigation">
        <li class="xn-logo">
            <a href="#"><!-- {{Cookie::get('school_name_cookie')}} -->MyFarm</a>
            <a href="#" class="x-navigation-control"></a>
        </li>
        <li class="xn-profile">
            <a href="#" class="profile-mini">
                <img src="{{asset('img/logo.jpg')}}" alt="{{Auth::user()->name}}"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="{{asset('img/logo.jpg')}}" alt="{{Auth::user()->name}}"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{Auth::user()->name}}</div>
                    <div class="profile-data-title">{{$role_name}}</div>
                </div>
                <div class="profile-controls">
                    <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                    <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                </div>
            </div>
        </li>
        <!-- <li class="xn-title">Navigation</li> -->
        <!--<li class="@php if (Request::segment(1) == '') { echo "active"; } @endphp">-->
        <!--    <a href="{{URL::to('/')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>-->
        <!--</li>-->
        
        <li class="@php if (Request::segment(1) == 'dashboard') { echo "active"; } @endphp">
            <a href="{{url('dashboard')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
        </li>
        <li class="@php if (Request::segment(1) == 'dashboardevent') { echo "active"; } @endphp">
            <a href="{{url('dashboardevent')}}"><span class="fa fa-list"></span> <span class="xn-text">Dashboard Event</span></a>
        </li>
        <li class="@php if (Request::segment(1) == 'dashboardfield') { echo "active"; } @endphp">
            <a href="{{url('dashboardfield')}}"><span class="fa fa-list"></span> <span class="xn-text">Dashboard Field</span></a>
        </li>
        <li class="@php if (Request::segment(1) == 'dashboardsetting') { echo "active"; } @endphp">
            <a href="{{url('dashboardsetting')}}"><span class="fa fa-gear"></span> <span class="xn-text">Dashboard Settings</span></a>
        </li>
        @if(in_array("GraphChart", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'graphchart') { echo "active"; } @endphp">
            <a href="{{url('graphchart')}}"><span class="fa fa-list"></span> <span class="xn-text">Graphs and Charts</span></a>
        </li>
        @endif
        
        @if(in_array("List", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'list') { echo "active"; } @endphp">
            <a href="{{url('list')}}"><span class="fa fa-file-o"></span> <span class="xn-text">List</span></a>
        </li>
        @endif
        @if(in_array("Person", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'person') { echo "active"; } @endphp">
            <a href="{{url('person')}}"><span class="fa fa-file-o"></span> <span class="xn-text">Person</span></a>
        </li>
        @endif
        @if(in_array("Field", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'field') { echo "active"; } @endphp">
            <a href="{{url('field')}}"><span class="fa fa-file-o"></span> <span class="xn-text">Field</span></a>
        </li>
        @endif
        @if(in_array("Team", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'team') { echo "active"; } @endphp">
            <a href="{{url('team')}}"><span class="fa fa-file-o"></span> <span class="xn-text">Team</span></a>
        </li>
        @endif
        @if(in_array("AlertRange", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'alertrange') { echo "active"; } @endphp">
            <a href="{{url('alertrange')}}"><span class="fa fa-file-o"></span> <span class="xn-text">Alert Ranges</span></a>
        </li>
        @endif
        
        
        
        
        {{-- @if($role_name == 'admin') --}}
        {{-- @if(Str::contains(strtolower($role_name), 'admin')) --}}
        {{-- @if(in_array("User", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertUser", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditUser", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeleteUser", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("User", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'user') { echo "active"; } @endphp">
            <a href="{{url('user')}}"><span class="fa fa-users"></span> <span class="xn-text">User</span></a>
        </li>
        @endif
        {{-- @if(in_array("CollectActivity", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertCollectActivity", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditCollectActivity", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeleteCollectActivity", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("CollectActivity", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'collectactivity') { echo "active"; } @endphp">
            <a href="{{url('collectactivity')}}"><span class="fa fa-list-ul"></span> <span class="xn-text">Collect Activity</span></a>
        </li>
        @endif
        {{-- @if(in_array("Sensor", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertSensor", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditSensor", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeleteSensor", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("Sensor", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'sensor') { echo "active"; } @endphp">
            <a href="{{url('sensor')}}"><span class="fa fa-magic"></span> <span class="xn-text">Sensors</span></a>
        </li>
        @endif
        @if(in_array("Container", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'container') { echo "active"; } @endphp">
            <a href="{{url('container')}}"><span class="fa fa-magic"></span> <span class="xn-text">Container</span></a>
        </li>
        @endif
        @if(in_array("ArchContainer", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'containerarch') { echo "active"; } @endphp">
            <a href="{{url('containerarch')}}"><span class="fa fa-magic"></span> <span class="xn-text">Arch Container</span></a>
        </li>
        @endif
        @if(in_array("Zone", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'zone') { echo "active"; } @endphp">
            <a href="{{url('zone')}}"><span class="fa fa-magic"></span> <span class="xn-text">Zones</span></a>
        </li>
        @endif
        {{-- @if(in_array("Role", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertRole", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditRole", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeleteRole", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("Role", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'role') { echo "active"; } @endphp">
            <a href="{{url('role')}}"><span class="fa fa-user"></span> <span class="xn-text">Role</span></a>
        </li>
        @endif
        {{-- @if(in_array("CommunityGroup", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertCommunityGroup", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditCommunityGroup", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeleteCommunityGroup", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("CommunityGroup", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'communitygrp') { echo "active"; } @endphp">
            <a href="{{url('communitygrp')}}"><span class="fa fa-sitemap"></span> <span class="xn-text">Community Grp</span></a>
        </li>
        @endif
        {{-- @if(in_array("Unit", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertUnit", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditUnit", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeleteUnit", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("Unit", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'unit') { echo "active"; } @endphp">
            <a href="{{url('unit')}}"><span class="fa fa-th"></span> <span class="xn-text">Units</span></a>
        </li>
        @endif
        {{-- @if(in_array("SensorType", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertSensorType", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditSensorType", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeleteSensorType", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("SensorType", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'sensortype') { echo "active"; } @endphp">
            <a href="{{url('sensortype')}}"><span class="fa fa-magic"></span> <span class="xn-text">Sensor Type</span></a>
        </li>
        @endif
        {{-- @if($role_name == 'admin' || $role_name == 'FARMER') --}}
        {{--@if(Str::contains(strtolower($role_name), 'admin') || Str::contains(strtolower($role_name), 'admin')) --}}

        {{-- @if(in_array("Pack", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertPack", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditPack", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeletePack", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("Pack", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'pack') { echo "active"; } @endphp">
            <a href="{{url('pack')}}"><span class="fa fa-dropbox"></span> <span class="xn-text">Pack</span></a>
        </li>
        @endif
        {{-- @if(in_array("CollectData", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("InsertCollectData", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("EditCollectData", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege')) 
        || in_array("DeleteCollectData", array_column(json_decode(Cookie::get('user_privileges'), true), 'privilege'))) --}}
        @if(in_array("CollectData", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'collectdata') { echo "active"; } @endphp">
            <a href="{{url('collectdata')}}"><span class="fa fa-list-ul"></span> <span class="xn-text">Collect Data</span></a>
        </li>
        @endif
        <li class="@php if (Request::segment(1) == 'notification') { echo "active"; } @endphp">
            <a href="{{url('notification')}}"><span class="fa fa-list-ul"></span> <span class="xn-text">Notification</span></a>
        </li>
        @if(in_array("TaskConfig", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'taskconfig') { echo "active"; } @endphp">
            <a href="{{url('taskconfig')}}"><span class="fa fa-list-ul"></span> <span class="xn-text">Task Config</span></a>
        </li>
        @endif
        @if(in_array("Task", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'task') { echo "active"; } @endphp">
            <a href="{{url('task')}}"><span class="fa fa-list-ul"></span> <span class="xn-text">Task</span></a>
        </li>
        @endif
        @if(in_array("Event", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'event') { echo "active"; } @endphp">
            <a href="{{url('event')}}"><span class="fa fa-list-ul"></span> <span class="xn-text">Event</span></a>
        </li>
        @endif
        @if(in_array("Incident", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'incident') { echo "active"; } @endphp">
            <a href="{{url('incident')}}"><span class="fa fa-list-ul"></span> <span class="xn-text">Incident</span></a>
        </li>
        @endif
        @if(in_array("Report", array_column(json_decode($user_priv, true), 'privilege'))) 
        <li class="@php if (Request::segment(1) == 'report') { echo "active"; } @endphp">
            <a href="{{url('report')}}"><span class="fa fa-file-o"></span> <span class="xn-text">Report</span></a>
        </li>
        @endif
        @if(in_array("Setting", array_column(json_decode($user_priv, true), 'privilege')))
        <li class="@php if (Request::segment(1) == 'resetpassword') { echo "active"; } @endphp">
            <a href="{{url('resetpassword')}}"><span class="fa fa-cogs"></span> <span class="xn-text">Settings</span></a>
        </li>
        @endif
        
        
        
        <!--<li class="@php if (Request::segment(1) == 'list') { echo "active"; } @endphp">-->
        <!--    <a href="{{url('list')}}"><span class="fa fa-file-o"></span> <span class="xn-text">List</span></a>-->
        <!--</li>-->
        <!--<li class="@php if (Request::segment(1) == 'person') { echo "active"; } @endphp">-->
        <!--    <a href="{{url('person')}}"><span class="fa fa-file-o"></span> <span class="xn-text">Person</span></a>-->
        <!--</li>-->
        <!--<li class="@php if (Request::segment(1) == 'field') { echo "active"; } @endphp">-->
        <!--    <a href="{{url('field')}}"><span class="fa fa-file-o"></span> <span class="xn-text">Field</span></a>-->
        <!--</li>-->
        <!--<li class="@php if (Request::segment(1) == 'team') { echo "active"; } @endphp">-->
        <!--    <a href="{{url('team')}}"><span class="fa fa-file-o"></span> <span class="xn-text">Team</span></a>-->
        <!--</li>-->








        <!-- <li class="xn-openable">
            <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Pages</span></a>
            <ul>
                <li><a href="pages-gallery.html"><span class="fa fa-image"></span> Gallery</a></li>
                <li><a href="pages-profile.html"><span class="fa fa-user"></span> Profile</a></li>
                <li><a href="pages-address-book.html"><span class="fa fa-users"></span> Address Book</a></li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-clock-o"></span> Timeline</a>
                    <ul>
                        <li><a href="pages-timeline.html"><span class="fa fa-align-center"></span> Default</a></li>
                        <li><a href="pages-timeline-simple.html"><span class="fa fa-align-justify"></span> Full Width</a></li>
                    </ul>
                </li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-envelope"></span> Mailbox</a>
                    <ul>
                        <li><a href="pages-mailbox-inbox.html"><span class="fa fa-inbox"></span> Inbox</a></li>
                        <li><a href="pages-mailbox-message.html"><span class="fa fa-file-text"></span> Message</a></li>
                        <li><a href="pages-mailbox-compose.html"><span class="fa fa-pencil"></span> Compose</a></li>
                    </ul>
                </li>
                <li><a href="pages-messages.html"><span class="fa fa-comments"></span> Messages</a></li>
                <li><a href="pages-calendar.html"><span class="fa fa-calendar"></span> Calendar</a></li>
                <li><a href="pages-tasks.html"><span class="fa fa-edit"></span> Tasks</a></li>
                <li><a href="pages-content-table.html"><span class="fa fa-columns"></span> Content Table</a></li>
                <li><a href="pages-faq.html"><span class="fa fa-question-circle"></span> FAQ</a></li>
                <li><a href="pages-search.html"><span class="fa fa-search"></span> Search</a></li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-file"></span> Blog</a>

                    <ul>
                        <li><a href="pages-blog-list.html"><span class="fa fa-copy"></span> List of Posts</a></li>
                        <li><a href="pages-blog-post.html"><span class="fa fa-file-o"></span>Single Post</a></li>
                    </ul>
                </li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-sign-in"></span> Login</a>
                    <ul>
                        <li><a href="pages-login.html">App Login</a></li>
                        <li><a href="pages-login-website.html">Website Login</a></li>
                        <li><a href="pages-login-website-light.html"> Website Login Light</a></li>
                    </ul>
                </li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-warning"></span> Error Pages</a>
                    <ul>
                        <li><a href="pages-error-404.html">Error 404 Sample 1</a></li>
                        <li><a href="pages-error-404-2.html">Error 404 Sample 2</a></li>
                        <li><a href="pages-error-500.html"> Error 500</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Layouts</span></a>
            <ul>
                <li><a href="layout-boxed.html">Boxed</a></li>
                <li><a href="layout-nav-toggled.html">Navigation Toggled</a></li>
                <li><a href="layout-nav-top.html">Navigation Top</a></li>
                <li><a href="layout-nav-right.html">Navigation Right</a></li>
                <li><a href="layout-nav-top-fixed.html">Top Navigation Fixed</a></li>
                <li><a href="layout-nav-custom.html">Custom Navigation</a></li>
                <li><a href="layout-frame-left.html">Frame Left Column</a></li>
                <li><a href="layout-frame-right.html">Frame Right Column</a></li>
                <li><a href="layout-search-left.html">Search Left Side</a></li>
                <li><a href="blank.html">Blank Page</a></li>
            </ul>
        </li>
        <li class="xn-title">Components</li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">UI Kits</span></a>
            <ul>
                <li><a href="ui-widgets.html"><span class="fa fa-heart"></span> Widgets</a></li>
                <li><a href="ui-elements.html"><span class="fa fa-cogs"></span> Elements</a></li>
                <li><a href="ui-buttons.html"><span class="fa fa-square-o"></span> Buttons</a></li>
                <li><a href="ui-panels.html"><span class="fa fa-pencil-square-o"></span> Panels</a></li>
                <li><a href="ui-icons.html"><span class="fa fa-magic"></span> Icons</a><div class="informer informer-warning">+679</div></li>
                <li><a href="ui-typography.html"><span class="fa fa-pencil"></span> Typography</a></li>
                <li><a href="ui-portlet.html"><span class="fa fa-th"></span> Portlet</a></li>
                <li><a href="ui-sliders.html"><span class="fa fa-arrows-h"></span> Sliders</a></li>
                <li><a href="ui-alerts-popups.html"><span class="fa fa-warning"></span> Alerts & Popups</a></li>
                <li><a href="ui-lists.html"><span class="fa fa-list-ul"></span> Lists</a></li>
                <li><a href="ui-tour.html"><span class="fa fa-random"></span> Tour</a></li>
            </ul>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Forms</span></a>
            <ul>
                <li>
                    <a href="form-layouts-two-column.html"><span class="fa fa-tasks"></span> Form Layouts</a>
                    <div class="informer informer-danger">New</div>
                    <ul>
                        <li><a href="form-layouts-one-column.html"><span class="fa fa-align-justify"></span> One Column</a></li>
                        <li><a href="form-layouts-two-column.html"><span class="fa fa-th-large"></span> Two Column</a></li>
                        <li><a href="form-layouts-tabbed.html"><span class="fa fa-table"></span> Tabbed</a></li>
                        <li><a href="form-layouts-separated.html"><span class="fa fa-th-list"></span> Separated Rows</a></li>
                    </ul>
                </li>
                <li><a href="form-elements.html"><span class="fa fa-file-text-o"></span> Elements</a></li>
                <li><a href="form-validation.html"><span class="fa fa-list-alt"></span> Validation</a></li>
                <li><a href="form-wizards.html"><span class="fa fa-arrow-right"></span> Wizards</a></li>
                <li><a href="form-editors.html"><span class="fa fa-text-width"></span> WYSIWYG Editors</a></li>
                <li><a href="form-file-handling.html"><span class="fa fa-floppy-o"></span> File Handling</a></li>
            </ul>
        </li>
        <li class="xn-openable">
            <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Tables</span></a>
            <ul>
                <li><a href="table-basic.html"><span class="fa fa-align-justify"></span> Basic</a></li>
                <li><a href="table-datatables.html"><span class="fa fa-sort-alpha-desc"></span> Data Tables</a></li>
                <li><a href="table-export.html"><span class="fa fa-download"></span> Export Tables</a></li>
            </ul>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Charts</span></a>
            <ul>
                <li><a href="charts-morris.html"><span class="xn-text">Morris</span></a></li>
                <li><a href="charts-nvd3.html"><span class="xn-text">NVD3</span></a></li>
                <li><a href="charts-rickshaw.html"><span class="xn-text">Rickshaw</span></a></li>
                <li><a href="charts-other.html"><span class="xn-text">Other</span></a></li>
            </ul>
        </li>
        <li>
            <a href="maps.html"><span class="fa fa-map-marker"></span> <span class="xn-text">Maps</span></a>
        </li>
        <li class="xn-openable">
            <a href="#"><span class="fa fa-sitemap"></span> <span class="xn-text">Navigation Levels</span></a>
            <ul>
                <li class="xn-openable">
                    <a href="#">Second Level</a>
                    <ul>
                        <li class="xn-openable">
                            <a href="#">Third Level</a>
                            <ul>
                                <li class="xn-openable">
                                    <a href="#">Fourth Level</a>
                                    <ul>
                                        <li><a href="#">Fifth Level</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li> -->

    </ul>
    <!-- END X-NAVIGATION -->
</div>
