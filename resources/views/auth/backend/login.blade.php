<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Page</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{asset('backend')}}/css/toastr.min.css" rel="stylesheet" />

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .form-outline .form-control.form-control-lg~.form-label {
            padding-top: .58rem !important;
        }
    </style>
</head>
<!--Coded with love by Mutiullah Samim-->

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <h2 class="m-0">
                <Marquee>{{$setting->name}}, ({{$setting->address}})</Marquee>
            </h2>
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form onsubmit="AdminLogin(event)">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="text" name="username" id="username" class="form-control form-control-lg" />
                            <label class="form-label error-username" for="username">Username/Email</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" name="password" id="password" class="form-control form-control-lg" />
                            <label class="form-label error-password" for="password">Password</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                                <label class="form-check-label" for="form1Example3"> Remember me </label>
                            </div>
                            <a href="#!">Forgot password?</a>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="{{asset('backend')}}/js/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function AdminLogin(event) {
            event.preventDefault();
            var formdata = new FormData(event.target)
            $.ajax({
                url: "/admin",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $(".error-username").text("Username/email").removeClass("text-danger")
                    $(".error-password").text("Password").removeClass("text-danger")
                },
                success: res => {
                    if (res.status) {
                        toastr.success(res.message);
                        setTimeout(() => {
                            location.href = "/admin/dashboard"
                        }, 1000)
                    }
                },
                error: err => {
                    $.each(err.responseJSON.errors, (index, value) => {
                        $(".error-" + index).text(value).addClass("text-danger")
                    })
                }
            })
        }
    </script>
</body>

</html>