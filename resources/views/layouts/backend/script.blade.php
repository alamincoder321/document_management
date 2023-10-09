    <!-- Preloader -->
    <div id="preloader">
        <div class="loader" id="loader-1"></div>
    </div>
    <!-- End Preloader -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('backend')}}/js/jquery-min.js"></script>
    <script src="{{asset('backend')}}/js/popper.min.js"></script>
    <script src="{{asset('backend')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('backend')}}/js/jquery.app.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
    <script src="{{asset('backend')}}/js/datatable.min.js"></script>

    <!-- sweet alert js -->
    <script src="{{asset('backend')}}/js/sweetalert.min.js"></script>
    <script src="{{asset('backend')}}/js/toastr.min.js"></script>

    @stack('js')
    <script src="{{asset('backend')}}/js/main.js"></script>

    <script>
        function logout(event) {
            event.preventDefault();

            $.ajax({
                url: '/admin/logout',
                method: 'POST',
                data: {},
                success: res => {
                    if (res.status) {
                        toastr.success(res.message);
                        setTimeout(() => {
                            location.href = '/admin';
                        }, 1000)
                    }
                }
            })
        }

        function Delete(event, url, id) {
            event.preventDefault();
            swal({
                    title: "Are you sure?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Delete it!",
                    closeOnConfirm: false
                },
                function() {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            id: id
                        },
                        success: res => {
                            if (res.status) {
                                swal("Deleted!", res.message, "success");
                                table.ajax.reload();
                            }
                        }
                    })
                });
        }
    </script>