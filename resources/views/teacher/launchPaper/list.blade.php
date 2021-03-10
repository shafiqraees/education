@extends('teacher.layouts.main')
<style>
    .dataTables_filter{
        display: none;
    }
</style>
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Papers</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('teacher.home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Papers </li>
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
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-actions"> <a href="{{ route('launch.quiz.create')}}" class="btn btn-social btn-dark btn-dark text-center mt-1 pr-1"> <span class="la la-plus font-medium-3"></span> Launch New Quiz</a> </div>
                                        </div>
                                    </div>
                                    <br>
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
                                                                    <th>Method And Settings</th>
                                                                    <th>Created Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(!empty($data))
                                                                    @foreach($data as $row)
                                                                        <tr>
                                                                            <td>{{$row->id}} </td>
                                                                            <td>{{$row->className->name}} </td>
                                                                            <td>{{$row->className->class_code}} </td>
                                                                            <td>{{$row->questionPaper->name}} </td>
                                                                            <td>{{$row->questionPaper->paper_code}} </td>
                                                                            @php
                                                                                $fruitList = '';
                                                                                foreach ($row->methodsAndSettings as $fruit)
                                                                                {
                                                                                    $fruitList .= $fruit->name. ",";
                                                                                    $newarraynama = rtrim($fruitList, ", ");
                                                                                }
                                                                            @endphp
                                                                            <td> {{!empty($newarraynama) ? $newarraynama : ""}}</td>
                                                                            <td>{{!empty($row->created_at->diffForHumans()) ? $row->created_at->diffForHumans() : ""}}</td>
                                                                            <td>
{{--                                                                                <a href="{{route('edit.student',$row->id)}}" class="btn btn-icon bg-dark white" data-toggle="tooltip" data-placement="top" title="" data-original-title="edit"><i class="la la-pencil"></i></a>--}}
                                                                                <a href="javascript:void(0)" class="btn btn-icon bg-dark white launchQuiz" data-id="{{$row->id}}" data-url="{{route('launch.quiz.destroy')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="delete"><i class="la la-trash"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
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
