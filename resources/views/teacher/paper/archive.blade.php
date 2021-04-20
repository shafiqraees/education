@extends('teacher.layouts.main')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">bookmark</i>
                            </div>
                            <h4 class="card-title">Archive</h4>
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
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Trainee Group Name</th>
                                        <th>Trainee Group Code</th>
                                        <th>Course Name</th>
                                        <th>Course Code</th>
                                        <th>Status</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Trainee Group Name</th>
                                        <th>Trainee Group Code</th>
                                        <th>Course Name</th>
                                        <th>Course Code</th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $row)
                                            <tr>
                                                <td>{{$row->id}} </td>
                                                <td>{{isset($row->classRoom->name) ? $row->classRoom->name : ""}} </td>
                                                <td>{{isset($row->classRoom->class_code) ? $row->classRoom->class_code : ""}} </td>
                                                <td>{{isset($row->questionPaper->name) ? $row->questionPaper->name : ""}} </td>
                                                <td>{{isset($row->questionPaper->paper_code) ? $row->questionPaper->paper_code : ""}} </td>
                                                <td>{{!empty($row->status) ? $row->status : ""}}</td>
                                                <td class="text-right">
                                                    <a href="{{route('trainee.result',$row->id)}}" class="btn btn-link btn-danger btn-just-icon"><i class="material-icons">preview</i></a>
                                                    <a href="javascript:void(0)" class="btn btn-link btn-danger btn-just-icon remove" data-url="{{route('launch.destroy',$row->id)}}"><i class="material-icons">close</i></a>
                                                    <a href="javascript:void(0)" class="btn btn-link btn-danger btn-just-icon archive" data-url="{{route('archive.revert',$row->id)}}"><i class="material-icons">unarchive</i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

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
                                swal("deleted!", "Launch Course deleted successfully.", "success");
                            } else {
                                swal("warning!", "Launch Course not deleted successfully.", "warning");
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
    $(document).on('click','.archive',function (event) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to archive.",
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
                    type:'post',
                    url:profile_url,
                    success: function (results) {
                        if (results.data) {
                            if (results.data == true){
                                swal("deleted!", "Record archived successfully.", "success");
                            } else {
                                swal("warning!", "Record are not archived successfully.", "warning");
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
