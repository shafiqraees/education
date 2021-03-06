@extends('teacher.layouts.main')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@section('content')
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-md-12">
                <form id="LoginValidation" action="{{route('launch.store')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                            <h4 class="card-title">Course specifics</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">

                                <input type="hidden" name="class_room" value="" id="trianee_group_name">
                                <input type="hidden" name="paper_id" value="" id="paper_id">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="start_datetime" placeholder="start date and time" class="form-control datetimepicker">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="end_datetime" placeholder="Expire date and time" class="form-control datetimepicker">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Require Name </label>
                                        <input type="checkbox" name="setting[]" class="form-control" value="Require Name">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4" >
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Shuffle Questions </label>
                                        <input type="checkbox" name="setting[]" class="form-control" value="Shuffle Questions">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Shuffle Answers </label>
                                        <input type="checkbox" name="setting[]" class="form-control " value="Shuffle Answers">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Show Feedback </label>
                                        <input type="checkbox" name="setting[]" class="form-control " value="Show Question Feedback">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Show Final Score </label>
                                        <input type="checkbox" name="setting[]" class="form-control " value="Show Final Score">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Re Attempt </label>
                                        <input type="checkbox" name="setting[]" class="form-control " value="Re Attempt">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="classroomurl" id="classroomurl" value="{{route('get.traine')}}">
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-rose">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary exampleModal" data-toggle="modal" data-target="#exampleModal" style="display: none">
        Trainee Group
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trainee Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control ClassRoom" id="class_room_id" aria-invalid="false" name="class_room_id">
                                @foreach($data as $room)
                                    <option value="{{$room->id}}">{{$room->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary nextbutton" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary traineeModel" data-toggle="modal" data-target="#courses" style="display: none">
        Course
    </button>
    <!-- Modal -->
    <div class="modal fade" id="courses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Courses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <select class="form-control ClassRoom" id="courses" aria-invalid="false" name="courses">
                                @foreach($papers as $paper)
                                    <option value="{{$paper->id}}">{{$paper->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary coursebutton" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('#exampleModal').modal('show');
    });
    $(document).on('click','.nextbutton',function(e){
        e.preventDefault();
        var class_room_id =  $( "#class_room_id option:selected" ).val();
        var trianee_group_name =  $( "#trianee_group_name" ).val(class_room_id);
        if (trianee_group_name) {
            $('#courses').modal('show');
        } else {
            toastr.warning('Please select Trainee group!')
        }
    });
    $(document).on('click','.coursebutton',function(e){
        e.preventDefault();
        var courses_id =  $( "#courses option:selected" ).val();
        var paper_id =  $( "#paper_id" ).val(courses_id);
    });
</script>


