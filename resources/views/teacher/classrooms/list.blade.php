@extends('teacher.layouts.main')
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
                            <h4 class="card-title">Trainee Groups</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-actions"> <a href="{{ route('classrooms.create')}}" class="btn btn-primary"> <span class="la la-plus font-medium-3"></span> Add New Trainee Group</a> </div>
                                </div>
                            </div>
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
                                        <th>Title</th>
                                        <th>Trainee Group Code</th>
                                        <th>Status </th>
                                        <th>Created Date</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Trainee Group Code</th>
                                        <th>Status </th>
                                        <th>Created Date</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $row)
                                            <tr>
                                                <td>{{$row->id}} </td>
                                                <td>{{$row->name}} </td>
                                                <td>{{$row->class_code}} </td>
                                                <td>{{$row->status}}</td>
                                                <td>{{ $row->created_at->diffForHumans() }}</td>
                                                <td class="text-right">
                                                    <a href="{{route('classrooms.show',$row->id)}}" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">visibility</i></a>
                                                    <a href="{{route('classrooms.edit',$row->id)}}" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">edit</i></a>
                                                    <a href="javascript:void(0)" class="btn btn-link btn-danger btn-just-icon remove" data-url="{{route('classrooms.destroy',$row->id)}}"><i class="material-icons">close</i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                                <div class="mt-3" id="xyz"> {{ $data->links() }} </div>
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
