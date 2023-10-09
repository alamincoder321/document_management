@extends("layouts.backend_master")

@section('title', 'User Create')
@section('bread_crumb_title', 'User Create')
@section('bread_crumb_subtitle', 'User Create')

@section("content")
<div class="row">
    <!-- user list -->
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User List</h5>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>UserName</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- user create form -->
    <div class="col-md-3 col-12 pl-md-0">
        <div class="card">
            <div class="card-body">
                <form id="addUser" onsubmit="addUser(event)">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" autocomplete="off" placeholder="Name">
                        <span class="error-name error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="username">User Name</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="User Name" autocomplete="off">
                        <span class="error-username error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                        <span class="error-email error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select id="role_id" name="role_id" class="form-control shadow-none">
                            <option value="">Select Role</option>
                            @foreach($roles as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-role_id error text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                        <span class="error-password error text-danger"></span>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success px-3 shadow-none changeBtn">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    @if(Session::has('success'))
    toastr.success("{{Session::get('success')}}");
    @endif
    @if(Session::has('error'))
    toastr.error("{{Session::get('error')}}");
    @endif
    //get Data
    var table = $('#datatable').DataTable({
        ajax: "/admin/get-user",
        dataType: 'JSON',
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: null,
            },
            {
                data: 'name',
            },
            {
                data: 'username',
            },
            {
                data: 'email',
            },
            {
                data: null,
                render: data => {
                    let dataTxt;
                    if (data.role.id == 1) {
                        dataTxt = `<span class="badge bg-success text-white">${data.role.name}</span>`;
                    }else if(data.role.name == 'Admin'){
                        dataTxt = `<span class="badge bg-info text-white">${data.role.name}</span>`;
                    }else{
                        dataTxt = `<span class="badge bg-secondary text-white">${data.role.name}</span>`;
                    }
                    return dataTxt;
                }
            },
            {
                data: null,
                render: data => {
                        let dataTxt;
                        let userId = "{{Auth::guard('admin')->user()->id}}";
                        if(data.role.id == 1 && userId == 1){
                            dataTxt = `
                                <a style="font-size:18px;" href="" onclick="Edit(event,${data.id})" class="text-info lni-pencil-alt"></a>
                            `;
                        }else if(data.role.id == 1 && userId != 1){
                            dataTxt = "";
                        }else{
                            dataTxt = `
                                <a style="font-size:18px;" href="/admin/user/permission/${data.id}" class="text-warning lni-users"></a>
                                <a style="font-size:18px;" href="" onclick="Edit(event,${data.id})" class="text-info lni-pencil-alt"></a>            
                                <a style="font-size:18px;" href="" onclick="Delete(event, '/admin/user/delete' ,${data.id})" class="text-danger lni-trash"></a>
                            `;
                        }
                        return dataTxt;
                }
            }
        ],
    });
    table.on('order.dt search.dt', function() {
        table.column(0).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    // store user
    function addUser(event) {
        event.preventDefault();

        var formdata = new FormData(event.target)
        let url;
        if ($("#addUser").find("#id").val() == '') {
            url = '/admin/user'
        } else {
            url = '/admin/update/user'
        }
        $.ajax({
            url: url,
            method: "POST",
            data: formdata,
            processData: false,
            contentType: false,
            beforeSend: () => {
                $("#addUser").find(".error").text("");
            },
            success: res => {
                table.ajax.reload()
                $("#addUser").trigger('reset')
                $("#addUser").find("#id").val('')
                $(".changeBtn").text("Save User").removeClass("btn-primary").addClass("btn-success");
                toastr.success(res.message);
            },
            error: err => {
                $.each(err.responseJSON.errors, (index, value) => {
                    $("#addUser").find(".error-" + index).text(value);
                })
            }
        })
    }

    // edit fetch data
    function Edit(event, id) {
        event.preventDefault();
        $(".changeBtn").text("Update User").removeClass("btn-success").addClass("btn-primary");
        $.ajax({
            url: "/admin/get-user/" + id,
            method: "GET",
            dataType: "JSON",
            success: res => {
                $.each(res.data, (index, value) => {
                    $("#addUser").find("#" + index).val(value);
                })
                // if (res.data.image != null) {
                //     document.querySelector('.img').src = "/" + res.data.image
                // } else {
                //     document.querySelector('.img').src = "/noImage.jpg"
                // }
            }
        })
    }
</script>
@endpush