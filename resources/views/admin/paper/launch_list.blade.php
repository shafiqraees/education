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
                            <h4 class="card-title">Launched Courses</h4>
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
                                        <th>Created By</th>
                                        <th>No of questions</th>
                                        <th>Created Date</th>
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
                                        <th>Created By</th>
                                        <th>No of questions</th>
                                        <th>Created Date</th>
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
                                                <td>{{isset($row->questionPaper->name) ? $row->questionPaper->name : "" }} </td>
                                                <td>{{isset($row->questionPaper->paper_code) ? $row->questionPaper->paper_code : "" }} </td>
                                                <td>{{isset($row->questionPaper->teacher) ? $row->questionPaper->teacher->name : "" }} </td>
                                                <td>{{isset($row->questionPaper->question) ? count($row->questionPaper->question) : 0}} </td>
                                                <td>{{!empty($row->created_at->diffForHumans()) ? $row->created_at->diffForHumans() : ""}}</td>
                                                <td class="text-right">
                                                    <a href="#" class="btn btn-link btn-danger btn-just-icon remove" data-id="{{$row->id}}" data-url="{{route('admin.paper.destroy')}}"><i class="material-icons">close</i></a>
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
