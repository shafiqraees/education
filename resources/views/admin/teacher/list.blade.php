@extends('admin.layouts.main')
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
                    <h3 class="content-header-title mb-0 d-inline-block">Teachers</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Teacher </li>
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
                                            <div class="form-actions"> <a href="{{ route('admin.teacher.create')}}" class="btn btn-social btn-dark btn-dark text-center mt-1 pr-1"> <span class="la la-plus font-medium-3"></span> Add New Teacher</a> </div>
                                        </div>
                                    </div>
                                    <br>
                                    <section id="basic-form-layouts">
                                        <div class="row match-height">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-content collapse show">
                                                        {{--<form name="search" action="{{route('all.queston')}}"method="get">
                                                            <div class="row">
                                                                <div class="col-md-10 mb-1">
                                                                    <fieldset>
                                                                        <div class="input-group">
                                                                            <input type="text" name="keyword" value="{{old('keyword', request('keyword'))}}" class="form-control heightinputs" placeholder="Search" aria-describedby="button-addon4">
                                                                        </div>
                                                                    </fieldset>
                                                                </div>

                                                                <div class="col-xl-2 col-md-2">
                                                                    <button type="submit" class="btn btn-dark heightinputs"> <i class="fonticon-classname"></i> Filter </button>
                                                                </div>

                                                            </div>
                                                        </form>--}}
                                                        <div class="card-dashboard filter_hide">
                                                            <table class="table table-striped table-bordered zero-configuration">
                                                                <thead>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Name</th>
                                                                    <th>Email</th>
                                                                    <th>Phone</th>
                                                                    <th>Gender</th>
                                                                    <th>Status</th>
                                                                    <th>Created Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(!empty($data))
                                                                    @foreach($data as $row)
                                                                        <tr>
                                                                            <td>{{$row->id}} </td>
                                                                            <td>{{$row->name}} </td>
                                                                            <td>{{$row->email}} </td>
                                                                            <td>{{$row->phone}} </td>
                                                                            <td>{{$row->gender}} </td>
                                                                            <td>
                                                                                @if($row->is_active=="true")
                                                                                    <span class="badge badge-default badge-success">Actice</span>
                                                                                @elseif($row->is_active=="false")
                                                                                    <span class="badge badge-default badge-warning">DeActive </span>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{!empty($row->created_at->diffForHumans()) ? $row->created_at->diffForHumans() : ""}}</td>
                                                                            <td>
                                                                                <a href="{{route('edit.admin.teacher',$row->id)}}" class="btn btn-icon bg-dark white" data-toggle="tooltip" data-placement="top" title="" data-original-title="edit"><i class="la la-pencil"></i></a>
                                                                                <a href="javascript:void(0)" class="btn btn-icon bg-dark white students" data-id="{{$row->id}}" data-url="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="delete"><i class="la la-trash"></i></a>
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
