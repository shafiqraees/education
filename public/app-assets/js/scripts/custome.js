
$('.confirm-color').on('click',function(e){

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to suspend full profile of this user, Remember by doing this user will no longer have access to his account.",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn-dark",
                closeModal: false,
            },
            confirm: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn-dark",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            var radioval = $(this).attr("data-id");
            var profile_url = $('#user_url').val();

            $.ajax({
                type:'put',
                url:profile_url,
                data:{id:radioval},
                success: function (results) {
                    if (results.data) {
                        if (results.data.is_active === "true"){
                            swal("Unsuspended!", "Full profile been Unsuspended.", "success");
                        } else {
                            swal("Suspended!", "Full profile been suspended.", "success");
                        }

                        location.reload();
                        //swal("Done!", results.message, "success");

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            swal("Cancelled","Your profile is safe.");
        }
    });
});
$(document).ready(function() {
    $('.select2').select2();
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
$(document).on('change','#question',function(e){
    e.preventDefault();
    var id = $(this).val();
    var url = $('#ajaxurl').val();
    var _token =  $('meta[name="csrf-token"]').attr('content');
    ajaxRequest(id,url,_token);
});
$(document).on('click','.nxtbtn',function(e){
    e.preventDefault();
    //var id = $(this).val();
    var dataid = $(this).attr('data-id');
    var url = $('#ajaxurl').val();
    var _token =  $('meta[name="csrf-token"]').attr('content');

    ajaxRequest(dataid,url,_token);
});
function ajaxRequest(id,url,_token) {
    var str = '';
    $.ajax({
        url:url,
        type:"get",
        data:{
            id:id,
            _token: _token
        },
        success:function(response){
            if(response) {
                //console.log(response['data']['name']);
                if (response['data']['type'] === 'Multiple Choice') {
                    var str = '<div class="col-md-6 MultipleChoice">\n' +
                        '                                                <label class="inline-block" for="sel1">Quetion Name</label>\n' +
                        '                                                <input type="text" name="quiz_name[]" value="'+ response['data']['name'] +'" class="form-control heightinputs " id="basicInput">\n' +
                        '                                                <input type="hidden" name="quiz_id[]" value="'+ response['data']['id'] +'" class="form-control heightinputs " id="basicInput">\n' +
                        '                                            </div>\n' +
                        '                                            <div class="col-md-6 MultipleChoice">\n' +
                        '                                                <label for="field_name" class="inline-block">Question Image</label>\n' +
                        '                                                <input type="file" name="image[]" class="form-control heightinputs " id="basicInput">\n' +
                        '                                            </div></br>';
                    $('#newData').append(str);
                    $.each(response['data'].question_options,function (i,item){
                        var str = '<div class="col-md-4 MultipleChoice">\n' +
                            '                                                <label for="field_name" class="inline-block">Option</label>\n' +
                            '                                                <input type="text" name="option[]" value="'+ item.name +'" class="form-control heightinputs " placeholder="please enter option" id="basicInput">\n' +
                            '                                            </div>\n' +
                            '                                            <div class="col-md-4 MultipleChoice">\n' +
                            '                                                <label for="field_name" class="inline-block">File</label>\n' +
                            '                                                <input type="file" name="image[]" class="form-control heightinputs " id="basicInput">\n' +
                            '                                            </div>\n' +
                            '                                            <div class="col-md-4 MultipleChoice">\n' +
                            '                                                <label for="field_text" class="col-form-label ">Next Question</label>\n' +
                            '                                                <a href="javaScript:void(0)"  class="btn btn-social nxtbtn btn-dark btn-dark text-center mt-1 pr-1 ml-1" data-id="'+ item.suggested_question_id +'"><span class="la la-plus font-medium-3"></span>'+ item.suggested_question_id +'</a>\n' +
                            '                                            </div>';

                        $('#newData').append(str);
                    });
                }
                if (response['data']['type'] === 'True/False') {
                    var str = '<div class="col-md-6 MultipleChoice">\n' +
                        '                                                <label class="inline-block" for="sel1">Quetion Name</label>\n' +
                        '                                                <input type="text" name="quiz_name[]" value="'+ response['data']['name'] +'" class="form-control heightinputs " id="basicInput">\n' +
                        '                                                <input type="hidden" name="quiz_id[]" value="'+ response['data']['id'] +'" class="form-control heightinputs " id="basicInput">\n' +
                        '                                            </div>\n' +
                        '                                            <div class="col-md-6 MultipleChoice">\n' +
                        '                                                <label for="field_name" class="inline-block">Question Image</label>\n' +
                        '                                                <input type="file" name="image[]" class="form-control heightinputs " id="basicInput">\n' +
                        '                                            </div>';
                    $('#newData').append(str);
                    $.each(response['data'].question_options,function (i,item){
                        var str = '<div class="col-md-4 MultipleChoice">\n' +
                            '                                                <label for="field_name" class="inline-block">True</label>\n' +
                            '                                                <input type="radio" name="truefalse" value="true" class="form-control heightinputs " id="basicInput" >\n' +
                            '                                            </div>\n' +
                            '                                            <div class="col-md-4 MultipleChoice">\n' +
                            '                                                <label for="field_name" class="inline-block">False</label>\n' +
                            '                                                <input type="radio" name="truefalse" value="False" class="form-control heightinputs "  id="basicInput"">\n' +
                            '                                            </div>\n' +
                            '                                            <div class="col-md-4 MultipleChoice">\n' +
                            '                                                <label for="field_text" class="col-form-label ">Next Question</label>\n' +
                            '                                                <a href="javaScript:void(0)" class="btn btn-social nxtbtn btn-dark btn-dark text-center mt-1 pr-1 ml-1" data-id="'+ item.suggested_question_id +'"><span class="la la-plus font-medium-3"></span>'+ item.suggested_question_id +'</a>\n' +
                            '                                            </div>';

                        $('#newData').append(str);
                    });
                }
                if (response['data']['type'] === 'Short Answer') {
                    var str = '<div class="col-md-4 MultipleChoice">\n' +
                        '                                                <label class="inline-block" for="sel1">Quetion Name</label>\n' +
                        '                                                <input type="text" name="quiz_name[]" value="'+ response['data']['name'] +'" class="form-control heightinputs " id="basicInput">\n' +
                        '                                                <input type="hidden" name="quiz_id[]" value="'+ response['data']['id'] +'" class="form-control heightinputs " id="basicInput">\n' +
                        '                                            </div>';
                    $('#newData').append(str);
                    $.each(response['data'].question_options,function (i,item){
                        var str = '<div class="col-md-6 MultipleChoice">\n' +
                            '                                                <label for="field_name" class="inline-block">Answer</label>\n' +
                            '                                                <textarea name="answer" class="form-control heightinputs">'+ item.answer +'</textarea>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="col-md-2 MultipleChoice">\n' +
                            '                                                <label for="field_text" class="col-form-label ">Next Question</label>\n' +
                            '                                                <a href="javaScript:void(0)" class="btn btn-social nxtbtn btn-dark btn-dark text-center mt-1 pr-1 ml-1" data-id="'+ item.suggested_question_id +'"><span class="la la-plus font-medium-3"></span>'+ item.suggested_question_id +'</a>\n' +
                            '                                            </div>';

                        $('#newData').append(str);
                    });
                }
            }
        },
        error     : function (result){
            alert('sorry reord not found')
        }
    });
}
/**
 * delete class room.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
$('.classroom').on('click',function(e){

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete.",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn-dark",
                closeModal: false,
            },
            confirm: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn-dark",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            var radioval = $(this).attr("data-id");
            var profile_url = $(this).attr("data-url");
            $.ajax({
                type:'delete',
                url:profile_url,
                data:{id:radioval},
                success: function (results) {
                    if (results.data) {
                        if (results.data == true){
                            swal("deleted!", "Class room deleted successfully.", "success");
                        } else {
                            swal("warning!", "Class room not deleted successfully.", "warning");
                        }

                        location.reload();
                        //swal("Done!", results.message, "success");

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            swal("Cancelled","Your profile is safe.");
        }
    });
});
/**
 * delete class room.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
$('.students').on('click',function(e){

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete.",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn-dark",
                closeModal: false,
            },
            confirm: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn-dark",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            var radioval = $(this).attr("data-id");
            var profile_url = $(this).attr("data-url");
            $.ajax({
                type:'delete',
                url:profile_url,
                data:{id:radioval},
                success: function (results) {
                    if (results.data) {
                        if (results.data == true){
                            swal("deleted!", "Student deleted successfully.", "success");
                        } else {
                            swal("warning!", "Student not deleted successfully.", "warning");
                        }

                        location.reload();
                        //swal("Done!", results.message, "success");

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            swal("Cancelled","Your profile is safe.");
        }
    });
});

/**
 * delete class room.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
$('.questions').on('click',function(e){

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete.",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn-dark",
                closeModal: false,
            },
            confirm: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn-dark",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            var radioval = $(this).attr("data-id");
            var profile_url = $(this).attr("data-url");
            $.ajax({
                type:'delete',
                url:profile_url,
                data:{id:radioval},
                success: function (results) {
                    if (results.data) {
                        if (results.data == true){
                            swal("deleted!", "Student deleted successfully.", "success");
                        } else {
                            swal("warning!", "Student not deleted successfully.", "warning");
                        }

                        location.reload();
                        //swal("Done!", results.message, "success");

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            swal("Cancelled","Your profile is safe.");
        }
    });
});
/**
 * delete class room.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
$('.papers').on('click',function(e){

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete.",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn-dark",
                closeModal: false,
            },
            confirm: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn-dark",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            var radioval = $(this).attr("data-id");
            var profile_url = $(this).attr("data-url");
            $.ajax({
                type:'delete',
                url:profile_url,
                data:{id:radioval},
                success: function (results) {
                    if (results.data) {
                        if (results.data == true){
                            swal("deleted!", "Student deleted successfully.", "success");
                        } else {
                            swal("warning!", "Student not deleted successfully.", "warning");
                        }

                        location.reload();
                        //swal("Done!", results.message, "success");

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            swal("Cancelled","Your profile is safe.");
        }
    });
});
/**
 * delete class room.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
$('.launchQuiz').on('click',function(e){

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to delete.",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn-dark",
                closeModal: false,
            },
            confirm: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn-dark",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            var radioval = $(this).attr("data-id");
            var profile_url = $(this).attr("data-url");
            $.ajax({
                type:'delete',
                url:profile_url,
                data:{id:radioval},
                success: function (results) {
                    if (results.data) {
                        if (results.data == true){
                            swal("deleted!", "Student deleted successfully.", "success");
                        } else {
                            swal("warning!", "Student not deleted successfully.", "warning");
                        }

                        location.reload();
                        //swal("Done!", results.message, "success");

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            swal("Cancelled","Your profile is safe.");
        }
    });
});
