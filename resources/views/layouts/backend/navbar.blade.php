<div class="header navbar">
    <div class="header-container">
        <div class="nav-logo">
            <a href="{{route('admin.dashboard')}}">
                <b><img src="{{asset('backend')}}/img/logo.png" alt=""></b>
                <span class="logo">
                    <img src="{{asset('backend')}}/img/logo-text.png" alt="">
                </span>
            </a>
        </div>
        <ul class="nav-left">
            <li>
                <a class="sidenav-fold-toggler" href="javascript:void(0);">
                    <i class="lni-menu"></i>
                </a>
                <a class="sidenav-expand-toggler" href="javascript:void(0);">
                    <i class="lni-menu"></i>
                </a>
            </li>
        </ul>
        <ul class="nav-right">
            <li class="search-box">
                <input class="form-control" type="text" placeholder="Type to search...">
                <i class="lni-search"></i>
            </li>
            <li class="user-profile dropdown dropdown-animated scale-left">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img class="profile-img img-fluid" src="{{asset(Auth::guard()->user()->image != '' ? Auth::guard()->user()->image : 'no-userimage.png')}}" alt="{{Auth::guard('admin')->user()->name}}">
                </a>
                <ul class="dropdown-menu dropdown-md">
                    <li>
                        <ul class="list-media">
                            <li class="list-item avatar-info">
                                <div class="media-img">
                                    <img src="{{asset(Auth::guard()->user()->image != '' ? Auth::guard()->user()->image : 'no-userimage.png')}}" alt="{{Auth::guard('admin')->user()->name}}">
                                </div>
                                <div class="info">
                                    <span class="title text-semibold">{{Auth::guard('admin')->user()->name}}</span>
                                    <span class="sub-title">{{Auth::guard('admin')->user()->role->name}}</span>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li>
                        <a href="{{route('admin.profile')}}">
                            <i class="lni-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a href="" onclick="logout(event)">
                            <i class="lni-lock"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>