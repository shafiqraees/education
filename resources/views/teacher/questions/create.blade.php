@extends('teacher.layouts.main')
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
                <form id="LoginValidation" action="{{route('question.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                            <h4 class="card-title">Course Name: {{isset($course->name) ? $course->name : ""}}</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Question #</label>
                                        <input type="text" class="form-control" id="question_number" value="{{$quiz_number}}"  name="question_number" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Enter Question here *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="name">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Points *</label>
                                        <input type="text" class="form-control" id="points" required="true" name="points">
                                    </div>
                                </div>
                                <div class="col-md-2 " style="margin-top: -17px;">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Final question </label>
                                        <input type="checkbox" name="final_question" class="form-control " value="Final question">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 image">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="display: block !important;">
                                            <div class="fileinput-new thumbnail">
                                                <img src="{{asset('public/assets/img/placeholder.jpg')}}" alt="...">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                              <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="photo" accept="image/x-png,image/gif,image/jpeg" />
                                              </span>
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="row" id="extrafileds">
                                <div class="col-md-1 MultipleChoice">
                                    <div class="form-group">
                                        <input type="radio" name="answer" value="0" class="form-control" id="name">
                                    </div>
                                </div>
                                <div class="col-md-4 MultipleChoice">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Option </label>
                                        <input type="text" class="form-control" id="name" name="option[]">
                                    </div>
                                </div>
                                <div class="col-md-4 MultipleChoice">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Go to Question ID *</label>
                                        <input type="number" class="form-control" id="name" name="question_id[]">
                                    </div>
                                </div>
                                <div class="col-md-3 MultipleChoice" >
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="image[]" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>
                                    </div>
                                </div>
                            </div>
                            <fieldset id="option_dorm">

                            </fieldset>
                            {{--<div class="mt-2 ml-1 More" style="display: block">
                                <a data-toggle="add_extra_field" class="btn btn-rose">Add More Field</a>
                            </div>--}}
                            <input type="button" value="Add more options" class="add btn btn-rose" id="addmore" />
                            <input type="hidden" value="{{request('id')}}" name="id" />
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-rose">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">

                            <h4 class="card-title">All Question of <strong>{{isset($course->name) ? $course->name : ""}}</strong></h4>
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
                                        <th>Question ID</th>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Include in Result</th>
                                        <th>Points</th>
                                        <th>Image</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Question ID</th>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Include in Result</th>
                                        <th>Points</th>
                                        <th>Image</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if(!empty($data))
                                        @foreach($data as $row)
                                            <tr>
                                                <td>{{$row->serial_id}} </td>

                                                <td>{{$row->name}} </td>
                                                <td>
                                                    @foreach($row->option as $option)
                                                    <div class="radio d-inline">
                                                        <label class=""><input type="radio" name="{{$option->name}}" {{ ($option->answer != "")? "checked" : "" }} disabled> {{$option->name}}</label>
                                                    </div>
                                                    <br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" value="" {{ ($row->final_question != "")? "checked" : "" }} disabled>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>

                                                </td>
                                                <td>{{ !empty($row->marks) ? $row->marks : "Not Assign" }}</td>
                                                <td><img src="{{Storage::disk('public')->exists('xs/'.$row->image) ? Storage::disk('public')->url('xs/'.$row->image) : Storage::disk('public')->url('default.png')}}" class="rounded-circle  height-150"
                                                         alt="Card image" height="50px"></td>

                                                <td class="text-right">
                                                    <a href="javascript:void(0)" class="btn btn-link btn-info btn-just-icon like editpopup" data-action="{{route('question.edit',$row->id)}}"><i class="material-icons">edit</i></a>
                                                    <a href="javascript:void(0)" class="btn btn-link btn-danger btn-just-icon remove" data-url="{{route('question.destroy',$row->id)}}"><i class="material-icons">close</i></a>
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
    </div>
@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script>
    $(window).on('load', function () {
        $("html, body").animate({ scrollTop: $(document).height() }, 1000);
    });
    var count =  1;
    $(document).on('click','a[data-toggle=add_extra_field]',function (event) {

        event.preventDefault();

        var str = '<div class="col-md-1 MultipleChoice">\n' +
            '<div class="form-group">\n' +
        '<input type="radio" name="answer" value="'+ (count ++) +'" class="form-control" id="name">\n' +
        '</div>\n' +
        '</div>\n' +
        '<div class="col-md-6 MultipleChoice">\n' +
        '<div class="form-group">\n' +
        '<label for="exampleEmails" class="bmd-label-floating"> Option </label>\n' +
        '<input type="text" class="form-control" id="name" name="option[]">\n' +
        '</div>\n' +
        '</div>\n' +
        '<div class="col-md-2 MultipleChoice">\n' +
        '<div class="form-group">\n' +
        '<label for="exampleEmails" class="bmd-label-floating"> suggested Question Id *</label>\n' +
        '<input type="number" class="form-control" id="name" name="question_id[]">\n' +
        '</div>\n' +
        '</div>\n' +
        '<div class="col-md-3 MultipleChoice" >\n' +
        '<div class="form-group">\n' +
        '<input type="file" class="form-control" name="image[]" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>\n' +
        '</div>\n' +
        '</div>';
        $('#extrafileds').append(str);

        //var nameval = $('#field_name').val();
    });
    $(document).ready(function() {
        $("#addmore").click(function() {
            var lastField = $("#option_dorm div:last");
            var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
            var fieldWrapper = $("<div class=\"row\" id=\"field" + intId + "\"/>");
            fieldWrapper.data("idx", intId);
           // var fName = $("<input type=\"text\" class=\"fieldname\" />");
            var fName = '<div class="col-md-1 MultipleChoice">\n' +
                '<div class="form-group">\n' +
                '<input type="radio" name="answer" value="'+ (count ++) +'" class="form-control" id="name">\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-4 MultipleChoice">\n' +
                '<div class="form-group">\n' +
                '<label for="exampleEmails" class="bmd-label-floating"> Option </label>\n' +
                '<input type="text" class="form-control" id="name" name="option[]">\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 MultipleChoice">\n' +
                '<div class="form-group">\n' +
                '<label for="exampleEmails" class="bmd-label-floating"> Go to Question ID *</label>\n' +
                '<input type="number" class="form-control" id="name" name="question_id[]">\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 MultipleChoice" >\n' +
                '<div class="form-group">\n' +
                '<input type="file" class="form-control" name="image[]" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>\n' +
                '</div>\n' +
                '</div>';
            var removeButton = $("<input type=\"button\" class=\"remove btn btn-rose\" value=\"-\" />");
            removeButton.click(function() {
                $(this).parent().remove();
            });
            fieldWrapper.append(fName);
            fieldWrapper.append(removeButton);
            $("#option_dorm").append(fieldWrapper);
        });

    });

</script>
