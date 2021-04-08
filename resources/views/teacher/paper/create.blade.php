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
                <form id="LoginValidation" action="{{route('quiz.store')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                            <h4 class="card-title">Create Quiz Form</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Name *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="paper_name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Paper Code *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="paper_code">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="quizselect" id="question" class="form-control select2 quiz">
                                            <option value="">Select first Question</option>
                                            @foreach($data as $room)
                                                <option value="{{$room->serial_id}}">{{$room->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="extrafileds">

                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-rose">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="ajaxurl" name="url" value="{{route('getoption')}}">
    <input type="hidden" id="teacher_id" name="teacher_id" value="{{Auth::guard('teacher')->user()->id}}">
@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script>
    var count = 1;
    $(document).on('change','.quiz',function(e){
        e.preventDefault();
        var id = $(this).val();
        var url = $('#ajaxurl').val();
        var teacher_id = $('#teacher_id').val();
        var _token =  $('meta[name="csrf-token"]').attr('content');
        ajaxOnChangeRequest(id,url,_token, teacher_id);
    });
    $(document).on('click','.nxtbtn',function(e){
        e.preventDefault();
        //var id = $(this).val();
        var dataid = $(this).attr('data-id');
        var url = $('#ajaxurl').val();
        var teacher_id = $('#teacher_id').val();
        var _token =  $('meta[name="csrf-token"]').attr('content');
        ajaxOnChangeRequest(dataid,url,_token,teacher_id);
    });
    function ajaxOnChangeRequest(id,url,_token, teacher_id) {
        var str = '';
        $.ajax({
            url:url,
            type:"get",
            data:{
                id:id,
                teacher_id:teacher_id,
                _token: _token
            },
            success:function(response){
                if(response) {
                    if (response['data']['type'] === 'Multiple Choice') {
                        var question =
                            '<div class="col-md-6 MultipleChoice">\n' +
                            '<div class="form-group">\n' +
                            '<label for="exampleEmails" class="bmd-label-floating"> Name *</label>\n' +
                            '<input type="text" name="quiz_name[]" value="'+ response['data']['name'] +'" class="form-control" id="name">\n' +
                            '<input type="hidden" name="quiz_id[]" value="'+ response['data']['id'] +'" class="form-control" id="name">\n' +
                            '</div>\n' +
                            '</div>\n' +
                            '<div class="col-md-6 MultipleChoice">\n' +
                            '<div class="form-group">\n' +
                            '<input type="file" class="form-control" name="image[]" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>\n' +
                            '</div>\n' +
                            '</div>';
                        $('#extrafileds').append(question);
                        $.each(response['data'].question_options,function (i,item){
                            var str =
                                '<div class="col-md-1 MultipleChoice">\n' +
                                '<div class="form-group">\n' +
                                '<input type="radio" name="answer" value="'+ (count ++) +'" class="form-control" id="name">\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '<div class="col-md-6 MultipleChoice">\n' +
                                '<div class="form-group">\n' +
                                '<label for="exampleEmails" class="bmd-label-floating"> Option </label>\n' +
                                '<input type="text" class="form-control" id="name" name="option[]"  value="'+ item.name +'">\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '<div class="col-md-2 MultipleChoice">\n' +
                                '<div class="form-group pt-3">\n' +
                                '<label for="exampleEmails" class="bmd-label-floating"> Next Question id </label>\n' +
                                '<a href="javascript:void(0)"> <span class="nxtbtn" style="border: 1px solid; border-color: #bdaaaa; padding: 1px 6px;" data-id="'+ item.suggested_question_id +'">'+ item.suggested_question_id +'</span></a>\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '<div class="col-md-3 MultipleChoice" >\n' +
                                '<div class="form-group">\n' +
                                '<input type="file" class="form-control" name="image[]" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '</div>';
                            $('#extrafileds').append(str);
                        });
                    }

                }
            },
            error     : function (result){
                alert('sorry record not found')
            }
        });
    }
</script>
