@extends('teacher.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Questions</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('teacher.home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('all.queston')}}">Questions</a> </li>
                                <li class="breadcrumb-item active">Question Create </li>
                            </ol>
                        </div>
                    </div>
                </div>
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
            <div class="content-body">
                <form class="form-horizontal"id="quiz" name="quiz" method="post" action="{{route('save.question')}}"  enctype="multipart/form-data">
                    @csrf
                    <section id="card-bordered-options">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card box-shadow-0 border-dark">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Create Question</h4>
                                        <h4 class="card-title text-white" style="float: right">{{$quiz_number}}</h4>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">

                                            <fieldset class="form-group row" id="extrafileds">
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-
                                                    block" for="sel1">Name</label>
                                                    <input type="text" name="name" class="form-control heightinputs " id="basicInput" required>
                                                </div>

                                                <div class="col-md-6 mt-1">

                                                    <label class="inline-block" for="sel1">Status</label>
                                                    <select class="form-control" aria-invalid="false" name="status" required>
                                                        <option value="Publish">Publish</option>
                                                        <option value="Unpublish">Unpublish</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-1">
                                                    <label class="inline-block" for="sel1">Type</label>
                                                    <select class="form-control" id="test_type" aria-invalid="false" name="type" required>
                                                        <option value="Multiple Choice">Multiple Choice</option>
                                                        <option value="True/False">True/False</option>
                                                        <option value="Short Answer">Short Answer</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-1">
                                                    <div class="form-group ">
                                                        <label class="inline-block" for="sel1">Image</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                            <div class="fonticon-wrap">
                                                                <i class="ft-image"></i>
                                                            </div>
                                                                    </span>
                                                            </div>
                                                            <input type="file" name="photo" class="form-control heightinputs errormessage " accept="image/*">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-1">
                                                    <label class="inline-
                                                    block" for="sel1">Marks</label>
                                                    <input type="text" name="marks" class="form-control heightinputs" placeholder="Please enter marks here" id="basicInput" required>
                                                </div>
                                                <div class="col-md-6 mt-1 ShortAnswer" style="display: none">
                                                    <label class="inline-block" for="sel1">Short Answer</label>
                                                    <textarea name="ShortAnswer" class="form-control"></textarea>
                                                </div>
                                                <div class="col-md-6 mt-1 ShortAnswer" style="display: none">
                                                    <label class="inline-block" for="sel1">suggested Question Id</label>
                                                    <input type="number" name="Short_question_id" class="form-control heightinputs " id="basicInput">
                                                </div>

                                                <div class="col-md-3 mt-1 TrueFalse" style="display: none">
                                                    <label class="inline-block" for="sel1">True</label>
                                                    <input type="radio" name="truefalse" value="true"  class="form-control heightinputs " id="basicInput">
                                                </div>
                                                <div class="col-md-3 mt-1 TrueFalse" style="display: none">
                                                    <label class="inline-block" for="sel1">False</label>
                                                    {{--//<input type="file" name="image[]" class="form-control heightinputs " id="basicInput" required>--}}
                                                    <input type="radio" name="truefalse" value="false" class="form-control heightinputs " id="basicInput">
                                                </div>
                                                <div class="col-md-6 mt-1 TrueFalse" style="display: none">
                                                    <label class="inline-block" for="sel1">suggested Question Id</label>
                                                    <input type="number" name="true_false_question_id" class="form-control heightinputs " id="basicInput" >
                                                </div>
                                                {{--mulriple Options--}}
                                                <div class="col-md-1 mt-1 MultipleChoice">
                                                    <label class="inline-block" for="sel1">Answer</label>
                                                    <input type="radio" name="answer" value="0"  class="form-control heightinputs " id="answerfiled">
                                                </div>
                                                <div class="col-md-4 mt-1 MultipleChoice">
                                                    <label class="inline-block" for="sel1">Option</label>
                                                    <input type="text" name="option[]" class="form-control heightinputs " placeholder="please enter option" id="basicInput">
                                                </div>
                                                <div class="col-md-4 mt-1 MultipleChoice">
                                                    <label class="inline-block" for="sel1">File</label>
                                                    <input type="file" name="image[]" class="form-control heightinputs " id="basicInput">
                                                </div>
                                                <div class="col-md-3 mt-1 MultipleChoice">
                                                    <label class="inline-block" for="sel1">suggested Question Id</label>
                                                    <input type="number" name="question_id[]" placeholder="please enter question Id" class="form-control heightinputs " id="basicInput" >
                                                </div>
                                            </fieldset>
                                            <div class="mt-2 ml-1 More" style="display: block">
                                                <a data-toggle="add_extra_field" class="btn btn-success">Add More Field</a>
                                            </div>
                                            <div class="form-actions float-right mt-0 pt-0 buttonbordertop">
{{--                                                <button type="submit" value="submit" class="btn btn-social btn-dark btn-dark text-center  pr-1"> <span class="la la-check font-medium-3"></span> Create </button>--}}
                                                <input type="submit" value="submit" class="btn btn-social btn-dark btn-dark text-center  pr-1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('public/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var count =  1;
    $(document).on('click','a[data-toggle=add_extra_field]',function (event) {
        event.preventDefault();
        var str = '<div class="col-md-1 MultipleChoice">\n' +
            '                                                <label class="inline-block" for="sel1">Answer</label>\n' +
            '                                                <input type="radio" name="answer" value="'+ (count ++) +'"  class="form-control heightinputs " id="basicInput">\n' +
            '                                            </div>\n' +
            '<div class="col-md-4 MultipleChoice">\n' +
            '                                                <label for="field_name" class="inline-block">Option</label>\n' +
            '                                                <input type="text" name="option[]" class="form-control heightinputs " placeholder="please enter option" id="basicInput" required>\n' +
            '                                            </div>\n' +
            '                                            <div class="col-md-4 MultipleChoice">\n' +
            '                                                <label for="field_name" class="inline-block">File</label>\n' +
            '                                                <input type="file" name="image[]" class="form-control heightinputs " id="basicInput">\n' +
            '                                            </div>\n' +
            '                                            <div class="col-md-3 MultipleChoice">\n' +
            '                                                <label for="field_text" class="col-form-label " style="margin-top: -13px">suggested Question Id</label>\n' +
            '                                                <input type="number" name="question_id[]" class="form-control heightinputs " placeholder="please enter question Id" id="basicInput" required>\n' +
            '                                            </div>';
        $('#extrafileds').append(str);

        //var nameval = $('#field_name').val();
    });
    $(document).on('change','#test_type',function (event) {
       event.preventDefault();
       var type = $(this).val();
       if (type === "Multiple Choice"){
           $(".MultipleChoice").attr("style", "display: block;");
           $(".More").attr("style", "display: block;");
           $(".TrueFalse").attr("style", "display: none;");
           $(".ShortAnswer").attr("style", "display: none;");
       } else if(type === "True/False") {
           $(".MultipleChoice").attr("style", "display: none;");
           $(".More").attr("style", "display: none;");
           $(".TrueFalse").attr("style", "display: block;");
           $(".ShortAnswer").attr("style", "display: none;");
        } else if(type === "Short Answer") {
           $(".MultipleChoice").attr("style", "display: none;");
           $(".More").attr("style", "display: none;");
           $(".TrueFalse").attr("style", "display: none;");
           $(".ShortAnswer").attr("style", "display: block;");
       } else {
           $(".MultipleChoice").attr("style", "display: block;");
           $(".More").attr("style", "display: block;");
           $(".TrueFalse").attr("style", "display: none;");
           $(".ShortAnswer").attr("style", "display: none;");
       }


    });
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
