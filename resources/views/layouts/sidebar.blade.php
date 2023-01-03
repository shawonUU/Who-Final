<?php
$admin = Auth::guard('admin')->user();
?>

<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            {{-- <div class="user-box">
                
                            <div class="float-left">
                                <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-md rounded-circle">
                            </div>
                            <div class="user-info">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            John Doe <i class="mdi mdi-chevron-down"></i>
                                                    </a>
                                    <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 29px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-face-profile mr-2"></i> Profile<div class="ripple-wrapper"></div></a></li>
                                        <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-settings mr-2"></i> Settings</a></li>
                                        <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-lock mr-2"></i> Lock screen</a></li>
                                        <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-power-settings mr-2"></i> Logout</a></li>
                                    </ul>
                                </div>
                                <p class="font-13 text-muted m-0">Administrator</p>
                            </div>
                        </div> --}}

            <ul class="metismenu" id="side-menu">

                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li {{ request('type') == 'admin' ? 'mm-active' : ''}}>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-email"></i>
                        <span> Roles </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        @if ($admin && $admin->type == 'admin')
                            <li class="{{ request('type') == 'admin' ? 'mm-active' : ''}}"><a href="{{ route('admin.list', ['type' => 'admin']) }}" class="{{ request('type') == 'admin' ? 'active' : '' }}">Admins</a></li>
                        @endif
                        {{-- <li><a href="{{ route('admin.list', ['type' => 'viewer']) }}">Viewers</a></li> --}}
                    </ul>
                </li>



                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-palette"></i>
                        <span> Users </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{ route('admin.user.list', ['type' => 'Active']) }}">
                                {{ __('Active') }}
                            </a>
                        </li>
                        <li><a href="{{ route('admin.user.list', ['type' => 'Hybernates']) }}">
                                {{ __('Hybernates') }}
                            </a>
                        </li>
                        <li><a href="{{ route('admin.user.list', ['type' => 'Completed']) }}">
                                {{ __('Completed') }}
                            </a>
                        </li>
                        <li><a href="{{ route('admin.user.list', ['type' => 'Inactive']) }}">
                                {{ __('Inactive') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.course.index') }}" class="waves-effect">
                        <i class=" mdi mdi-calendar"></i>
                        <span> Course </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi-invert-colors"></i>
                        <span> Master Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{ route('admin.course_faq.index') }}">FAQ</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
