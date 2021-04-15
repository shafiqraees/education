@extends('authentication.layout.layout')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-8 col-12 mr-auto ml-auto">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card card-wizard" data-color="rose" id="wizardProfile">
                        <form action="javascript:void(0)" id="my-form" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="teacher_id" id="teacher_id" name="teacher_id" value="">
                            <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                            <div class="card-header text-center">
                                <h3 class="card-title">
                                    Trainer Register
                                </h3>
                                {{--                                <h5 class="card-description">This information will let us know more about you.</h5>--}}
                            </div>
                            <div class="wizard-navigation">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                                            Profile
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#account" data-toggle="tab" role="tab">
                                            Demographic
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#address" data-toggle="tab" role="tab">
                                            Demographic
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="about">
{{--                                        <h5 class="info-text"> Let's start with the basic information (with validation)</h5>--}}
                                        <div class="row justify-content-center">
                                            <div class="col-sm-4">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        <img src="{{asset('public/assets/img/default-avatar.png')}}" class="picture-src" id="wizardPicturePreview" title="" />
                                                        <input type="file"  id="wizard-picture" name="image" accept="image/x-png,image/gif,image/jpeg">
                                                    </div>
                                                    <h6 class="description">Choose Picture</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">

                                <span class="input-group-text">
                                  <i class="material-icons">face</i>
                                </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">First Name (required)</label>
                                                        <input type="text" class="form-control" id="exampleInput1" name="firstname" required>
                                                    </div>
                                                </div>
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="material-icons">record_voice_over</i>
                                </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput11" class="bmd-label-floating">Second Name</label>
                                                        <input type="text" class="form-control" id="exampleInput11" name="lastname" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="material-icons">email</i>
                                                    </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">Email (required)</label>
                                                        <input type="email" class="form-control" id="exampleemalil" name="email" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="material-icons"> email</i>
                                                    </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">Confirm Email (required)</label>
                                                        <input type="email" class="form-control" id="exampleemalil" name="confirm_email" required>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="material-icons">lock_outline</i>
                                                    </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">Password (required)</label>
                                                        <input type="password" class="form-control" id="examplePasswords" name="password" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 mt-3">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="material-icons">lock_outline</i>
                                                    </span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInput1" class="bmd-label-floating">Confirm Password (required)</label>
                                                        <input type="password" class="form-control" id="examplePasswords" name="password_confirmation" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="account">
{{--                                        <h5 class="info-text"> What are you doing? (checkboxes) </h5>--}}
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <label>Country</label>
                                                        <div class="form-group select-wizard">
                                                            <select class="selectpicker" name="country" data-size="7" data-style="select-with-transition" title="Single Select" required>
                                                                <option value="Afghanistan"> Afghanistan </option>
                                                                <option value="Albania"> Albania </option>
                                                                <option value="Algeria"> Algeria </option>
                                                                <option value="American Samoa"> American Samoa </option>
                                                                <option value="Andorra"> Andorra </option>
                                                                <option value="Angola"> Angola </option>
                                                                <option value="Anguilla"> Anguilla </option>
                                                                <option value="Antarctica"> Antarctica </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="exampleEmails" class="bmd-label-floating">I agree to the terms and privacy policy </label>
                                                            <input type="checkbox" id="terms_and_conditions" name="terms_and_conditions" class="form-control" value="terms_and_conditions" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 dependent">
                                                        <label>Organization Type</label>
                                                        <div class="form-group select-wizard">
                                                            <select class="selectpicker" name="organization_type" data-size="7" data-style="select-with-transition" title="Single Select" required>
                                                                <option value="Primary/Secondary School"> Primary/Secondary School </option>
                                                                <option value="University"> University </option>
                                                                <option value="Corporate"> Corporate </option>
                                                                <option value="Other"> Other </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 dependent">
                                                        <label>Organization Name</label>
                                                        <div class="form-group select-wizard">
                                                            <input name="organization_name" value="" class="form-control" id="organization_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 dependent">
                                                        <label>Role</label>
                                                        <div class="form-group select-wizard">
                                                            <select class="selectpicker" name="organization_role" data-size="7" data-style="select-with-transition" title="Single Select" required>
                                                                <option value="Teacher"> Teacher </option>
                                                                <option value="Administrator"> Administrator </option>
                                                                <option value="IT/Technology"> IT/Technology </option>
                                                                <option value="Other"> Other </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row justify-content-center">
                                            <div class="col-sm-2" style="display: none">
                                                <div class="form-group">
                                                    <span class="excerpt d-block">Premium</span>
                                                    <span class="price"><sup>$</sup> <span class="number">120</span></span>
                                                    <div class="p-4 px-lg-5">
                                                        <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>Price per month<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>$ 97 yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong></span>1 user<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√</span>&nbsp; </strong>Unlimited<strong>&nbsp;</strong>courses<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>100 students</p>
                                                            <p><span style="color: #ff6600;"><strong>√</strong></span>&nbsp; Full product use</p></div>
                                                    </div>
                                                    <input id="amount" type="hidden" class="form-control" name="amount" value="120.0" autofocus>
                                                    <input id="name" type="hidden" class="form-control" name="name" value="Premium package" autofocus>
                                                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                                        <input type="hidden" name="cmd" value="_s-xclick">
                                                        <input type="hidden" name="hosted_button_id" value="6VVYMDGAY94J2">
                                                        <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                                        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <span class="excerpt d-block">Basic Plan</span>
                                                    <span class="price"><sup>$</sup> <span class="number">72</span></span>
                                                    <div class="p-4 px-lg-5">
                                                        <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>Price per month<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>$ 59 yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong></span>1 user<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>5 courses<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>10 students</p>
                                                            <p><span style="color: #ff6600;"><strong>√</strong></span>&nbsp; Full product use</p></div>
                                                    </div>
                                                    <input id="amount" type="hidden" class="form-control" name="amount" value="72.0" autofocus>
                                                    <input id="name" type="hidden" class="form-control" name="name" value="Basic Plan" autofocus>
                                                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                                        <input type="hidden" name="cmd" value="_s-xclick">
                                                        <input type="hidden"class="teacher_id" name="id" value="">
                                                        <input type="hidden" name="hosted_button_id" value="9FMVMHKBNJUVY">
                                                        <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                                        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <span class="excerpt d-block">Premium</span>
                                                    <span class="price"><sup>$</sup> <span class="number">120</span></span>
                                                    <div class="p-4 px-lg-5">
                                                        <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>Price per month<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>$ 97 yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong></span>1 user<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√</span>&nbsp; </strong>Unlimited<strong>&nbsp;</strong>courses<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>100 students</p>
                                                            <p><span style="color: #ff6600;"><strong>√</strong></span>&nbsp; Full product use</p></div>
                                                    </div>
                                                    <input id="amount" type="hidden" class="form-control" name="amount" value="120.0" autofocus>
                                                    <input id="name" type="hidden" class="form-control" name="name" value="Premium package" autofocus>

                                                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                                        <input type="hidden" name="cmd" value="_s-xclick">
                                                        <input type="hidden" name="hosted_button_id" value="6VVYMDGAY94J2">
                                                        <table>
                                                            <tr style="display: none"><td><input type="hidden" name="on0" value="teacher_id">teacher_id</td></tr><tr><td><input type="text" name="os0" maxlength="200" style="display: none"></td></tr>
                                                        </table>
                                                        <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                                        <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="mr-auto">
                                    <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Previous">
                                </div>
                                <div class="ml-auto">
                                    <input type="button" class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Next">
                                    <input type="button" class="btn btn-finish btn-fill btn-rose btn-wd" name="finish" value="Finish" style="display: none;">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- wizard container -->
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        $('.dependent').hide();
        $('input[type="checkbox"]').click(function(){
            if($(this).is(":checked")){
                console.log("Checkbox is checked.");
                $('.dependent').show();
            }
            else if($(this).is(":not(:checked)")){
                console.log("Checkbox is unchecked.");
                $('.dependent').hide();
            }
        });
        $('input[name="next"]').click(function(event){
            event.preventDefault();
            var formData = new FormData(document.getElementById("my-form"));
           // console.log(formData);
            $.ajax({
                url: '{{ route('teacher.register.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result)
                {
                    //location.reload();
                    console.log(result);
                    $('.teacher_id').val(result.data['id'])
                },
                error: function(data)
                {
                    console.log(data);
                    toastr.error(data)
                }
            });
        });
    });

</script>
