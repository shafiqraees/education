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
                <form id="LoginValidation" action="{{route('quiz.update',$course->id)}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Name *</label>
                                        <input type="text" class="form-control" id="name" value="{{$course->name}}" name="paper_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Course Code *</label>
                                        <input type="text" class="form-control" id="name" value="{{$course->paper_code}}" required="true" name="paper_code">
                                    </div>
                                </div>
                            </div>

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
                        <h4 class="card-title">All Question of {{isset($course->name) ? $course->name : ""}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="form-actions"> <a href="{{ route('question.create',['id'=>$course->id])}}" class="btn btn-rose"> <span class="la la-plus font-medium-3"></span> Add New Question</a> </div>
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
                                    <th>Question Type</th>
                                    <th>Image</th>
                                    <th>Created Date</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Question Type</th>
                                    <th>Image</th>
                                    <th>Created Date</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @if(!empty($data))
                                    @foreach($data as $row)
                                        <tr>
                                            <td>{{$row->serial_id}} </td>
                                            <td>{{$row->name}} </td>
                                            <td>{{$row->type}}</td>
                                            <td><img src="{{Storage::disk('public')->exists('xs/'.$row->image) ? Storage::disk('public')->url('xs/'.$row->image) : Storage::disk('public')->url('default.png')}}" class="rounded-circle  height-150"
                                                     alt="Card image" height="50px"></td>
                                            <td>{{ $row->created_at->diffForHumans() }}</td>
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
        $("#add").click(function() {
            var lastField = $("#buildyourform div:last");
            var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
            var fieldWrapper = $("<div class=\"row\" id=\"field" + intId + "\"/>");
            fieldWrapper.data("idx", intId);
            // var fName = $("<input type=\"text\" class=\"fieldname\" />");
            var fName = '<div class="col-md-1 MultipleChoice">\n' +
                '<div class="form-group">\n' +
                '<input type="radio" name="answer" value="'+ (count ++) +'" class="form-control" id="name">\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 MultipleChoice">\n' +
                '<div class="form-group">\n' +
                '<label for="exampleEmails" class="bmd-label-floating"> Option </label>\n' +
                '<input type="text" class="form-control" id="name" name="option[]">\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-3 MultipleChoice">\n' +
                '<div class="form-group">\n' +
                '<label for="exampleEmails" class="bmd-label-floating"> Feedback </label>\n' +
                '<input type="text" class="form-control" id="Feedback" name="Feedback[]">\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-2 MultipleChoice">\n' +
                '<div class="form-group">\n' +
                '<label for="exampleEmails" class="bmd-label-floating"> suggested Question Id *</label>\n' +
                '<input type="number" class="form-control" id="name" name="question_id[]">\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="col-md-2 MultipleChoice" >\n' +
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
            $("#buildyourform").append(fieldWrapper);
        });

    });

</script>
