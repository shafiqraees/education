@extends('subadmin.layouts.main')
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
                            <h4 class="card-title">Students</h4>
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Class Name</th>
                                        <th>Teacher Name</th>
                                        <th>Created Date</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Class Name</th>
                                        <th>Teacher Name</th>
                                        <th>Created Date</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $row)
                                            <tr>
                                                <td>{{$row->id}} </td>
                                                <td>{{$row->name}} </td>
                                                <td>{{$row->email}} </td>
                                                <td>{{isset($row->classRoom->name) ? $row->classRoom->name : ""}} </td>
                                                <td>{{isset($row->classRoom->teacher->name) ? $row->classRoom->teacher->name : ""}} </td>
                                                <td>{{ $row->created_at->diffForHumans() }}</td>
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
