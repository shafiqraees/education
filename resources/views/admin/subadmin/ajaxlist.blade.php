@extends('admin.layouts.main')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">assignment</i>
                            </div>
                            <h4 class="card-title">Sub Admin</h4>
                        </div>
                        <div class="card-body">
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            @if (session()->has('success'))
                                <div class="alert alert-success"> @if(is_array(session('success')))
                                        <ul>
                                            @foreach (session('success') as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ session('success') }}
                                    @endif </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="material-datatables">
                                <table id="subadminindex" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Created Date</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end content-->
                    </div>
                    <!--  end card  -->
                </div>
                <!-- end col-md-12 -->
            </div>
            <!-- end row -->
        </div>
    </div>
@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script>
    $(document).on('click','.remove',function (event) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete.",
            icon: "warning",
            showCancelButton: true,
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn-dark",
                    closeModal: false,
                },
                confirm: {
                    text: "Ok",
                    value: true,
                    visible: true,
                    className: "btn-dark",
                    closeModal: false
                }
            }
        }).then(isConfirm => {
            if (isConfirm) {

                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });
                var profile_url = $(this).attr("data-url");
                $.ajax({
                    type:'delete',
                    url:profile_url,
                    success: function (results) {
                        if (results.data) {
                            if (results.data == true){
                                swal("deleted!", "Class room deleted successfully.", "success");
                            } else {
                                swal("warning!", "Class room not deleted successfully.", "warning");
                            }

                            location.reload();
                            //swal("Done!", results.message, "success");

                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });

            } else {
                swal("Cancelled","Your profile is safe.");
            }
        });
    });
</script>
