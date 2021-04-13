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
                <form id="LoginValidation" action="{{route('question.store')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                            <h4 class="card-title">Create new question</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Name *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="type" id="type" class="form-control">
                                            <option value="Multiple Choice">Multiple Choice</option>
                                            {{--<option value="True/False">True/False</option>
                                            <option value="Short Answer">Short Answer</option>--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="image" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="extrafileds">
                                <div class="col-md-1 MultipleChoice">
                                    <div class="form-group">
                                        <input type="radio" name="answer" value="0" class="form-control" id="name">
                                    </div>
                                </div>
                                <div class="col-md-6 MultipleChoice">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Option </label>
                                        <input type="text" class="form-control" id="name" name="option[]">
                                    </div>
                                </div>
                                <div class="col-md-2 MultipleChoice">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> suggested Question Id *</label>
                                        <input type="number" class="form-control" id="name" name="question_id[]">
                                    </div>
                                </div>
                                <div class="col-md-3 MultipleChoice" >
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="image[]" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 ml-1 More" style="display: block">
                                <a data-toggle="add_extra_field" class="btn btn-rose">Add More Field</a>
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
@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script>
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
</script>
