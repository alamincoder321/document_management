<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin- @yield('title')</title>
    @include('layouts.backend.style')
</head>

<body>
    <div class="app header-default side-nav-dark">
        <div class="layout">
            <!-- Header START -->
            @include('layouts.backend.navbar')
            <!-- Header END -->

            <!-- Side Nav START -->
            @include('layouts.backend.sidebar')
            <!-- Side Nav END -->

            <!-- Page Container START -->
            <div class="page-container">
                <!-- Content Wrapper START -->
                <div class="main-content">
                    <div class="container-fluid">
                        <!-- Breadcrumb Start -->
                        <div class="breadcrumb-wrapper row">
                            <div class="col-12 col-md-4">
                                <h4 class="page-title">@yield('bread_crumb_title')</h4>
                            </div>
                            <div class="col-md-2">
                                <ul>
                                    @foreach(App\Models\Branch::get() as $item)
                                    <li class="{{session('branch')->id == $item->id ? 'bg-primary':''}} px-2"><a class="text-dark" href="{{url('admin/branch-access', $item->id)}}">{{$item->title}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-12 col-md-6">
                                <ol class="breadcrumb float-right">
                                    <li><a href="index.html">Home</a></li>
                                    <li class="active">/ @yield('bread_crumb_subtitle')</li>
                                </ol>
                            </div>
                        </div>
                        <!-- Breadcrumb End -->
                    </div>
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                <!-- Content Wrapper END -->

                <!-- Footer START -->
                <footer class="content-footer">
                    <div class="footer">
                        <div class="copyright">
                            <span>Copyright © {{date('Y')}}. All Right Reserved</span>
                            <span class="go-right">
                                <!-- <a href="" class="text-gray">Term &amp; Conditions</a>
                                <a href="" class="text-gray">Privacy &amp; Policy</a> -->
                            </span>
                        </div>
                    </div>
                </footer>
                <!-- Footer END -->

            </div>
            <!-- Page Container END -->
        </div>
    </div>

    @include('layouts.backend.script')

</body>

</html>