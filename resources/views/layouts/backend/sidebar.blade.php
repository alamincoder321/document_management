<div class="side-nav expand-lg">
    <div class="side-nav-inner">
        <ul class="side-nav-menu">
            <li class="side-nav-header">
                <span>Navigation</span>
            </li>
            <li class="nav-item dropdown {{Route::is('admin.dashboard') ? 'open' : ''}}">
                <a href="{{route('admin.dashboard')}}">
                    <span class="icon-holder"> <i class="lni-dashboard"></i> </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown {{Route::is('admin.user.create') || Route::is('admin.user.permission') ? 'open' : ''}}">
                <a href="{{route('admin.user.create')}}">
                    <span class="icon-holder"> <i class="lni-user"></i> </span>
                    <span class="title">User Create</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="" onclick="logout(event)">
                    <span class="icon-holder"> <i class="lni-lock"></i> </span>
                    <span class="title">Logout</span>
                </a>
            </li>
            <!-- <li class="nav-item dropdown open">
                <a href="#" class="dropdown-toggle">
                    <span class="icon-holder">
                        <i class="lni-dashboard"></i>
                    </span>
                    <span class="title">Dashboard</span>
                    <span class="arrow">
                        <i class="lni-chevron-right"></i>
                    </span>
                </a>
                <ul class="dropdown-menu sub-down">
                    <li class="active">
                        <a href="index.html">Dashboard 1</a>
                    </li>
                    <li><span class="badge badge-primary badge-pro float-right">Pro</span>
                        <a href=#"#">Dashboard 2</a>
                    </li>
                </ul>
            </li> -->
        </ul>
    </div>
</div>