<div class="col-md-12">
    <form id="LoginValidation" action="{{route('question.update',$data->id)}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card ">
            <div class="card-header card-header-rose card-header-icon">

                <h4 class="card-title">Edit Question Form</h4>
            </div>
            <div class="card-body ">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleEmails" class="bmd-label-floating"> Name *</label>
                            <input type="text" class="form-control" id="name" required="true" name="name" value="{{$data->name}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="type" id="type" class="form-control">
                                <option value="Multiple Choice" {{ ( $data->type == "Multiple Choice") ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="True/False" {{ ( $data->type == "True/False") ? 'selected' : '' }}>True/False</option>
                                <option value="Short Answer" {{ ( $data->type == "Short Answer") ? 'selected' : '' }}>Short Answer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="file" class="form-control" name="image" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>
                        </div>
                    </div>
                    <div class="col-md-2 " style="margin-top: -17px;">
                        <div class="form-group">
                            <label for="exampleEmails" class="bmd-label-floating"> Final question </label>
                            <input type="checkbox" name="final_question" class="form-control" value="Final question" {{ ($data->final_question == "Final question")? "checked" : "" }}>
                        </div>
                    </div>
                </div>
                <div class="row" id="extrafileds">
                    @if($data->type == "Multiple Choice")
                        @foreach($data->option as $key => $option)
                            <div class="col-md-1 MultipleChoice">
                                <div class="form-group">
                                    <input type="radio" name="answer" value="{{$key}}" {{ ($option->answer == $key)? "checked" : "" }} class="form-control" id="name">
                                </div>
                            </div>
                            <div class="col-md-3 MultipleChoice">
                                <div class="form-group">
                                    <label for="exampleEmails" class="bmd-label-floating"> Option </label>
                                    <input type="text" class="form-control" id="name" name="option[]" value="{{$option->name}}">
                                </div>
                            </div>
                            <div class="col-md-3 MultipleChoice">
                                <div class="form-group">
                                    <label for="exampleEmails" class="bmd-label-floating"> Feedback </label>
                                    <input type="text" class="form-control" id="name" name="Feedback[]">
                                </div>
                            </div>
                            <div class="col-md-2 MultipleChoice">
                                <div class="form-group">
                                    <label for="exampleEmails" class="bmd-label-floating"> suggested Question Id *</label>
                                    <input type="number" class="form-control" id="name" name="question_id[]" value="{{$option->suggested_question_id}}">
                                </div>
                            </div>
                            <div class="col-md-3 MultipleChoice" >
                                <div class="form-group">
                                    <input type="file" class="form-control" name="image[]" accept="image/x-png,image/gif,image/jpeg" style="position: unset;opacity: unset;height: unset;"/>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <fieldset id="buildyourform">

                </fieldset>
                <input type="button" value="Add more options" class="add btn btn-rose addmore" id="addmorer" />
                <input type="hidden" value="{{isset($data->paper->name) ? $data->paper->id : ""}}" name="id" />
            </div>
            <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-rose">Update</button>
            </div>
        </div>
    </form>
</div>
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $(".addmore").click(function(e) {
            e.preventDefault();
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
            var removeButton = $("<input type=\"button\" class=\"remove btn btn-rose\" value=\"-\" style='padding-left: 24px'/ >");
            removeButton.click(function() {
                $(this).parent().remove();
            });
            fieldWrapper.append(fName);
            fieldWrapper.append(removeButton);
            $("#buildyourform").append(fieldWrapper);
        });

    });
</script>
