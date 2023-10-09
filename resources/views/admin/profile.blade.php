@extends("layouts.backend_master")

@section('title', 'Admin Profile Update')
@section('bread_crumb_title', 'Admin Profile Update')
@section('bread_crumb_subtitle', 'Admin Profile Update')

@section("content")
<!-- Column -->
<div class="row">
    <div class="col-md-6 col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="form-group ImageBackground">
                            <img src="{{asset($data->image != null ? $data->image : 'noImage.jpg')}}" class="imageShow" />
                            <label for="image">Image</label>
                            <input type="file" id="image" class="form-control shadow-none" onchange="imageUpdate(event)" />
                        </div>
                        <span class="text-danger error error-image"></span>
                    </div>
                    <div class="col-lg-8">
                        <form onsubmit="Update(event)">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{$data->name}}" autocomplete="off" class="form-control shadow-none">
                                <span class="text-danger error error-name"></span>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" value="{{$data->username}}" autocomplete="off" class="form-control shadow-none">
                                <span class="text-danger error error-username"></span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value="{{$data->email}}" autocomplete="off" class="form-control shadow-none">
                                <span class="text-danger error error-email"></span>
                            </div>
                            <div class="form-group">
                                <label for="old_password">Current Password</label>
                                <input type="password" name="old_password" id="old_password" autocomplete="off" class="form-control shadow-none">
                                <span class="text-danger error error-old_password"></span>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" id="new_password" autocomplete="off" class="form-control shadow-none">
                                <span class="text-danger error error-new_password"></span>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" class="form-control shadow-none">
                                <span class="text-danger error error-confirm_password"></span>
                            </div>

                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-sm px-3 shadow-none">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function Update(event) {
        event.preventDefault();
        var formdata = new FormData(event.target);
        $.ajax({
            url: location.origin + "/admin/profile",
            method: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: () => {
                $(".error").text("")
            },
            success: res => {
                if (!res.error) {
                    if (res.errors) {
                        $("form").find(".error-old_password").text(res.errors)
                    } else {
                        $("form").find("#old_password").val("")
                        $("form").find("#new_password").val("")
                        $("form").find("#confirm_password").val("")
                        toastr.success(res.message);
                    }
                }
            },
            error: err => {
                $.each(err.responseJSON.errors, (index, value) => {
                    $(".error-" + index).text(value);
                })
            }
        })
    }

    function imageUpdate(event) {
        event.preventDefault();

        var formdata = new FormData()
        formdata.append("image", event.target.files[0]);
        $.ajax({
            url: location.origin + "/admin/profileImage",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".error").text("")
            },
            success: res => {
                if (!res.error) {
                    document.querySelector('.imageShow').src = window.URL.createObjectURL(event.target.files[0])
                    $("#image").val("")
                    toastr.success(res.message);
                }
            },
            error: err => {
                $.each(err.responseJSON.errors, (index, value) => {
                    $(".error-" + index).text(value);
                })
            }
        })
    }
</script>
@endpush