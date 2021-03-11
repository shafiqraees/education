@extends('admin.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Launched Papers</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Launched Papers </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    @if(is_array(session('success')))
                        <ul>
                            @foreach (session('success') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ session('success') }}
                    @endif
                </div>
            @endif
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <section id="basic-form-layouts">
                                        <div class="row match-height">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-content collapse show">
                                                        <div class="card-dashboard filter_hide">
                                                            <table class="table table-striped table-bordered zero-configuration">
                                                                <thead>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Class Name</th>
                                                                    <th>Class Code</th>
                                                                    <th>Paper Name</th>
                                                                    <th>Paper Code</th>
                                                                    <th>Created By</th>
                                                                    <th>No of questions</th>
                                                                    <th>Created Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(!empty($data))
                                                                    @foreach($data as $row)
                                                                        <tr>
                                                                            <td>{{$row->id}} </td>
                                                                            <td>{{isset($row->className->name) ? $row->className->name : ""}} </td>
                                                                            <td>{{isset($row->className->class_code) ? $row->className->class_code : ""}} </td>
                                                                            <td>{{isset($row->questionPaper->name) ? $row->questionPaper->name : "" }} </td>
                                                                            <td>{{isset($row->questionPaper->paper_code) ? $row->questionPaper->paper_code : "" }} </td>
                                                                            <td>{{isset($row->questionPaper->teacher) ? $row->questionPaper->teacher->name : "" }} </td>
                                                                            <td>{{isset($row->questionPaper->question) ? count($row->questionPaper->question) : 0}} </td>
                                                                            <td>{{!empty($row->created_at->diffForHumans()) ? $row->created_at->diffForHumans() : ""}}</td>
                                                                            <td>
                                                                                <a href="javascript:void(0)" class="btn btn-icon bg-dark white papers" data-id="{{$row->id}}" data-url="{{route('paper.destroy')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="delete"><i class="la la-trash"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                            <div class="mt-3" id="xyz"> {{ $data->links() }} </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
