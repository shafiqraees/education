@extends('authentication.layout.layout')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-8 col-12 mr-auto ml-auto">
                <!--      Wizard container        -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                <div class="wizard-container">
                    <div class="card card-wizard" data-color="rose" id="wizardProfile">
{{--                        <form action="javascript:void(0)" id="my-form" method="post" enctype="multipart/form-data">--}}
                        <form action="{{route('teacher.register.store')}}" id="my-form" method="post" enctype="multipart/form-data">
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
                                            Where You from
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#address" data-toggle="tab" role="tab">
                                            Organization
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
                                                                <option value="Afghanistan" data-capital="AF">Afghanistan</option>
                                                                <option value="Aland Islands" data-capital="AX">Aland Islands</option>
                                                                <option value="Albania" data-capital="AL">Albania</option>
                                                                <option value="Algeria" data-capital="DZ">Algeria</option>
                                                                <option value="American Samoa" data-capital="AS">American Samoa</option>
                                                                <option value="Andorra" data-capital="AD">Andorra</option>
                                                                <option value="Angola" data-capital="AO">Angola</option>
                                                                <option value="Anguilla" data-capital="AI">Anguilla</option>
                                                                <option value="Antigua and Barbuda" data-capital="AG">Antigua and Barbuda</option>
                                                                <option value="Argentina" data-capital="AR">Argentina</option>
                                                                <option value="Armenia" data-capital="AM">Armenia</option>
                                                                <option value="Aruba" data-capital="AW">Aruba</option>
                                                                <option value="Australia" data-capital="Canberra">Australia</option>
                                                                <option value="Austria" data-capital="AT">Austria</option>
                                                                <option value="Azerbaijan" data-capital="AZ">Azerbaijan</option>
                                                                <option value="Bahamas" data-capital="BS">Bahamas</option>
                                                                <option value="Bahrain" data-capital="BH">Bahrain</option>
                                                                <option value="Bangladesh" data-capital="BD">Bangladesh</option>
                                                                <option value="Barbados" data-capital="BB">Barbados</option>
                                                                <option value="Belarus" data-capital="BY">Belarus</option>
                                                                <option value="Belgium" data-capital="BE">Belgium</option>
                                                                <option value="Belize" data-capital="BZ">Belize</option>
                                                                <option value="Benin" data-capital="BJ">Benin</option>
                                                                <option value="Bermuda" data-capital="BM">Bermuda</option>
                                                                <option value="Bhutan" data-capital="BT">Bhutan</option>
                                                                <option value="Bolivia" data-capital="BO">Bolivia</option>
                                                                <option value="Bosnia and Herzegovina" data-capital="BA">Bosnia and Herzegovina</option>
                                                                <option value="Botswana" data-capital="BW">Botswana</option>
                                                                <option value="Brazil" data-capital="BR">Brazil</option>
                                                                <option value="British Indian Ocean Territory" data-capital="IO">British Indian Ocean Territory</option>
                                                                <option value="Brunei Darussalam" data-capital="BN">Brunei Darussalam</option>
                                                                <option value="Bulgaria" data-capital="BG">Bulgaria</option>
                                                                <option value="Burkina Faso" data-capital="BF">Burkina Faso</option>
                                                                <option value="Burundi" data-capital="BI">Burundi</option>
                                                                <option value="Cabo Verde" data-capital="CV">Cabo Verde</option>
                                                                <option value="Cambodia" data-capital="KH">Cambodia</option>
                                                                <option value="Cameroon" data-capital="CM">Cameroon</option>
                                                                <option value="Canada" data-capital="CA">Canada</option>
                                                                <option value="Cayman Islands" data-capital="KY">Cayman Islands</option>
                                                                <option value="Central African Republic" data-capital="CF">Central African Republic</option>
                                                                <option value="Chad" data-capital="TD">Chad</option>
                                                                <option value="Chile" data-capital="CL">Chile</option>
                                                                <option value="China" data-capital="CN">China</option>
                                                                <option value="Christmas Island" data-capital="CX">Christmas Island</option>
                                                                <option value="Cocos (Keeling) Islands" data-capital="CC">Cocos (Keeling) Islands</option>
                                                                <option value="Colombia" data-capital="CO">Colombia</option>
                                                                <option value="Comoros" data-capital="KM">Comoros</option>
                                                                <option value="Cook Islands" data-capital="CK">Cook Islands</option>
                                                                <option value="Costa Rica" data-capital="CR">Costa Rica</option>
                                                                <option value="Croatia" data-capital="HR">Croatia</option>
                                                                <option value="Cuba" data-capital="CU">Cuba</option>
                                                                <option value="Curaçao" data-capital="CW">Curaçao</option>
                                                                <option value="Cyprus" data-capital="CY">Cyprus</option>
                                                                <option value="Czech Republic" data-capital="CZ">Czech Republic</option>
                                                                <option value="Côte d'Ivoire" data-capital="CI">Côte d'Ivoire</option>
                                                                <option value="Democratic Republic of the Congo" data-capital="CD">Democratic Republic of the Congo</option>
                                                                <option value="Denmark" data-capital="DK">Denmark</option>
                                                                <option value="Djibouti" data-capital="DJ">Djibouti</option>
                                                                <option value="Dominica" data-capital="DM">Dominica</option>
                                                                <option value="Dominican Republic" data-capital="DO">Dominican Republic</option>
                                                                <option value="Ecuador" data-capital="EC">Ecuador</option>
                                                                <option value="Egypt" data-capital="EG">Egypt</option>
                                                                <option value="El Salvador" data-capital="SV">El Salvador</option>
                                                                <option value="Equatorial Guinea" data-capital="GQ">Equatorial Guinea</option>
                                                                <option value="Eritrea" data-capital="ER">Eritrea</option>
                                                                <option value="Estonia" data-capital="EE">Estonia</option>
                                                                <option value="Ethiopia" data-capital="ET">Ethiopia</option>
                                                                <option value="Falkland Islands" data-capital="FK">Falkland Islands</option>
                                                                <option value="Faroe Islands" data-capital="FO">Faroe Islands</option>
                                                                <option value="Federated States of Micronesia" data-capital="FM">Federated States of Micronesia</option>
                                                                <option value="Fiji" data-capital="FJ">Fiji</option>
                                                                <option value="Finland" data-capital="FI">Finland</option>
                                                                <option value="Former Yugoslav Republic of Macedonia" data-capital="MK">Former Yugoslav Republic of Macedonia</option>
                                                                <option value="France" data-capital="FR">France</option>
                                                                <option value="French Polynesia" data-capital="PF">French Polynesia</option>
                                                                <option value="Gabon" data-capital="GA">Gabon</option>
                                                                <option value="Gambia" data-capital="GM">Gambia</option>
                                                                <option value="Georgia" data-capital="GE">Georgia</option>
                                                                <option value="Germany" data-capital="DE">Germany</option>
                                                                <option value="Ghana" data-capital="GH">Ghana</option>
                                                                <option value="Gibraltar" data-capital="GI">Gibraltar</option>
                                                                <option value="Greece" data-capital="GR">Greece</option>
                                                                <option value="Greenland" data-capital="GL">Greenland</option>
                                                                <option value="Grenada" data-capital="GD">Grenada</option>
                                                                <option value="Guam" data-capital="GU">Guam</option>
                                                                <option value="Guatemala" data-capital="GT">Guatemala</option>
                                                                <option value="Guernsey" data-capital="GG">Guernsey</option>
                                                                <option value="Guinea" data-capital="GN">Guinea</option>
                                                                <option value="Guinea-Bissau" data-capital="GW">Guinea-Bissau</option>
                                                                <option value="Guyana" data-capital="GY">Guyana</option>
                                                                <option value="Haiti" data-capital="HT">Haiti</option>
                                                                <option value="Holy See" data-capital="VA">Holy See</option>
                                                                <option value="Honduras" data-capital="HN">Honduras</option>
                                                                <option value="Hong Kong" data-capital="HK">Hong Kong</option>
                                                                <option value="Hungary" data-capital="HU">Hungary</option>
                                                                <option value="Iceland" data-capital="IS">Iceland</option>
                                                                <option value="India" data-capital="IN">India</option>
                                                                <option value="Indonesia" data-capital="ID">Indonesia</option>
                                                                <option value="Iran" data-capital="IR">Iran</option>
                                                                <option value="Iraq" data-capital="IQ">Iraq</option>
                                                                <option value="Ireland" data-capital="IE">Ireland</option>
                                                                <option value="Isle of Man" data-capital="IM">Isle of Man</option>
                                                                <option value="Israel" data-capital="IL">Israel</option>
                                                                <option value="Italy" data-capital="IT">Italy</option>
                                                                <option value="Jamaica" data-capital="JM">Jamaica</option>
                                                                <option value="Japan" data-capital="JP">Japan</option>
                                                                <option value="Jersey" data-capital="JE">Jersey</option>
                                                                <option value="Jordan" data-capital="JO">Jordan</option>
                                                                <option value="Kazakhstan" data-capital="KZ">Kazakhstan</option>
                                                                <option value="Kenya" data-capital="KE">Kenya</option>
                                                                <option value="Kiribati" data-capital="KI">Kiribati</option>
                                                                <option value="Kuwait" data-capital="KW">Kuwait</option>
                                                                <option value="Kyrgyzstan" data-capital="KG">Kyrgyzstan</option>
                                                                <option value="Laos" data-capital="LA">Laos</option>
                                                                <option value="Latvia" data-capital="LV">Latvia</option>
                                                                <option value="Lebanon" data-capital="LB">Lebanon</option>
                                                                <option value="Lesotho" data-capital="LS">Lesotho</option>
                                                                <option value="Liberia" data-capital="LR">Liberia</option>
                                                                <option value="Libya" data-capital="LY">Libya</option>
                                                                <option value="Liechtenstein" data-capital="LI">Liechtenstein</option>
                                                                <option value="Lithuania" data-capital="LT">Lithuania</option>
                                                                <option value="Luxembourg" data-capital="LU">Luxembourg</option>
                                                                <option value="Macau" data-capital="MO">Macau</option>
                                                                <option value="Madagascar" data-capital="MG">Madagascar</option>
                                                                <option value="Malawi" data-capital="MW">Malawi</option>
                                                                <option value="Malaysia" data-capital="MY">Malaysia</option>
                                                                <option value="Maldives" data-capital="MV">Maldives</option>
                                                                <option value="Mali" data-capital="ML">Mali</option>
                                                                <option value="Malta" data-capital="MT">Malta</option>
                                                                <option value="Marshall Islands" data-capital="MH">Marshall Islands</option>
                                                                <option value="Martinique" data-capital="MQ">Martinique</option>
                                                                <option value="Mauritania" data-capital="MR">Mauritania</option>
                                                                <option value="Mauritius" data-capital="MU">Mauritius</option>
                                                                <option value="Mexico" data-capital="MX">Mexico</option>
                                                                <option value="Moldova" data-capital="MD">Moldova</option>
                                                                <option value="Monaco" data-capital="MC">Monaco</option>
                                                                <option value="Mongolia" data-capital="MN">Mongolia</option>
                                                                <option value="Montenegro" data-capital="ME">Montenegro</option>
                                                                <option value="Montserrat" data-capital="MS">Montserrat</option>
                                                                <option value="Morocco" data-capital="MA">Morocco</option>
                                                                <option value="Mozambique" data-capital="MZ">Mozambique</option>
                                                                <option value="Myanmar" data-capital="MM">Myanmar</option>
                                                                <option value="Namibia" data-capital="NA">Namibia</option>
                                                                <option value="Nauru" data-capital="NR">Nauru</option>
                                                                <option value="Nepal" data-capital="NP">Nepal</option>
                                                                <option value="Netherlands" data-capital="NL">Netherlands</option>
                                                                <option value="New Zealand" data-capital="NZ">New Zealand</option>
                                                                <option value="Nicaragua" data-capital="NI">Nicaragua</option>
                                                                <option value="Niger" data-capital="NE">Niger</option>
                                                                <option value="Nigeria" data-capital="NG">Nigeria</option>
                                                                <option value="Niue" data-capital="NU">Niue</option>
                                                                <option value="Norfolk Island" data-capital="NF">Norfolk Island</option>
                                                                <option value="North Korea" data-capital="KP">North Korea</option>
                                                                <option value="Northern Mariana Islands" data-capital="MP">Northern Mariana Islands</option>
                                                                <option value="Norway" data-capital="NO">Norway</option>
                                                                <option value="Oman" data-capital="OM">Oman</option>
                                                                <option value="Pakistan" data-capital="PK">Pakistan</option>
                                                                <option value="Palau" data-capital="PW">Palau</option>
                                                                <option value="Panama" data-capital="PA">Panama</option>
                                                                <option value="Papua New Guinea" data-capital="PG">Papua New Guinea</option>
                                                                <option value="Paraguay" data-capital="PY">Paraguay</option>
                                                                <option value="Peru" data-capital="PE">Peru</option>
                                                                <option value="Philippines" data-capital="PH">Philippines</option>
                                                                <option value="Pitcairn" data-capital="PN">Pitcairn</option>
                                                                <option value="Poland" data-capital="PL">Poland</option>
                                                                <option value="Portugal" data-capital="PT">Portugal</option>
                                                                <option value="Puerto Rico" data-capital="PR">Puerto Rico</option>
                                                                <option value="Qatar" data-capital="QA">Qatar</option>
                                                                <option value="Republic of the Congo" data-capital="CG">Republic of the Congo</option>
                                                                <option value="Romania" data-capital="RO">Romania</option>
                                                                <option value="Russia" data-capital="RU">Russia</option>
                                                                <option value="Rwanda" data-capital="RW">Rwanda</option>
                                                                <option value="Saint Barthélemy" data-capital="BL">Saint Barthélemy</option>
                                                                <option value="Saint Kitts and Nevis" data-capital="KN">Saint Kitts and Nevis</option>
                                                                <option value="Saint Lucia" data-capital="LC">Saint Lucia</option>
                                                                <option value="Saint Vincent and the Grenadines" data-capital="VC">Saint Vincent and the Grenadines</option>
                                                                <option value="Samoa" data-capital="WS">Samoa</option>
                                                                <option value="San Marino" data-capital="SM">San Marino</option>
                                                                <option value="Sao Tome and Principe" data-capital="ST">Sao Tome and Principe</option>
                                                                <option value="Saudi Arabia" data-capital="SA">Saudi Arabia</option>
                                                                <option value="Senegal" data-capital="SN">Senegal</option>
                                                                <option value="Serbia" data-capital="RS">Serbia</option>
                                                                <option value="Seychelles" data-capital="SC">Seychelles</option>
                                                                <option value="Sierra Leone" data-capital="SL">Sierra Leone</option>
                                                                <option value="Singapore" data-capital="SG">Singapore</option>
                                                                <option value="Sint Maarten" data-capital="SX">Sint Maarten</option>
                                                                <option value="Slovakia" data-capital="SK">Slovakia</option>
                                                                <option value="Slovenia" data-capital="SI">Slovenia</option>
                                                                <option value="Solomon Islands" data-capital="SB">Solomon Islands</option>
                                                                <option value="Somalia" data-capital="SO">Somalia</option>
                                                                <option value="South Africa" data-capital="ZA">South Africa</option>
                                                                <option value="South Korea" data-capital="KR">South Korea</option>
                                                                <option value="South Sudan" data-capital="SS">South Sudan</option>
                                                                <option value="Spain" data-capital="ES">Spain</option>
                                                                <option value="Sri Lanka" data-capital="LK">Sri Lanka</option>
                                                                <option value="State of Palestine" data-capital="PS">State of Palestine</option>
                                                                <option value="Sudan" data-capital="SD">Sudan</option>
                                                                <option value="Suriname" data-capital="SR">Suriname</option>
                                                                <option value="Swaziland" data-capital="SZ">Swaziland</option>
                                                                <option value="Sweden" data-capital="SE">Sweden</option>
                                                                <option value="Switzerland" data-capital="CH">Switzerland</option>
                                                                <option value="Syrian Arab Republic" data-capital="SY">Syrian Arab Republic</option>
                                                                <option value="Taiwan" data-capital="TW">Taiwan</option>
                                                                <option value="Tajikistan" data-capital="TJ">Tajikistan</option>
                                                                <option value="Tanzania" data-capital="TZ">Tanzania</option>
                                                                <option value="Thailand" data-capital="TH">Thailand</option>
                                                                <option value="Timor-Leste" data-capital="TL">Timor-Leste</option>
                                                                <option value="Togo" data-capital="TG">Togo</option>
                                                                <option value="Tokelau" data-capital="TK">Tokelau</option>
                                                                <option value="Tonga" data-capital="TO">Tonga</option>
                                                                <option value="Trinidad and Tobago" data-capital="TT">Trinidad and Tobago</option>
                                                                <option value="Tunisia" data-capital="TN">Tunisia</option>
                                                                <option value="Turkey" data-capital="TR">Turkey</option>
                                                                <option value="Turkmenistan" data-capital="TM">Turkmenistan</option>
                                                                <option value="Turks and Caicos Islands" data-capital="TC">Turks and Caicos Islands</option>
                                                                <option value="Tuvalu" data-capital="TV">Tuvalu</option>
                                                                <option value="Uganda" data-capital="UG">Uganda</option>
                                                                <option value="Ukraine" data-capital="UA">Ukraine</option>
                                                                <option value="United Arab Emirates" data-capital="AE">United Arab Emirates</option>
                                                                <option value="United Kingdom" data-capital="GB">United Kingdom</option>
                                                                <option value="United States of America" data-capital="US">United States of America</option>
                                                                <option value="Uruguay" data-capital="UY">Uruguay</option>
                                                                <option value="Uzbekistan" data-capital="UZ">Uzbekistan</option>
                                                                <option value="Vanuatu" data-capital="VU">Vanuatu</option>
                                                                <option value="Venezuela" data-capital="VE">Venezuela</option>
                                                                <option value="Vietnam" data-capital="VN">Vietnam</option>
                                                                <option value="Virgin Islands (British)" data-capital="VG">Virgin Islands (British)</option>
                                                                <option value="Virgin Islands (U.S.)" data-capital="VI">Virgin Islands (U.S.)</option>
                                                                <option value="Western Sahara" data-capital="EH">Western Sahara</option>
                                                                <option value="Yemen" data-capital="YE">Yemen</option>
                                                                <option value="Zambia" data-capital="ZM">Zambia</option>
                                                                <option value="Zimbabwe" data-capital="ZW">Zimbabwe</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label for="exampleEmails" class="bmd-label-floating">I agree to the terms and privacy policy </label>
                                                            <input type="checkbox" id="terms_and_conditions" name="terms_and_conditions" class="form-control" value="terms_and_conditions" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <div class="row">
                                                    <div class="col-sm-4 ">
                                                        <label>Organization Type</label>
                                                        <div class="form-group select-wizard">
                                                            <select class="selectpicker" name="organization_type" data-size="7" data-style="select-with-transition" title="Single Select">
                                                                <option value="Primary/Secondary School"> Primary/Secondary School </option>
                                                                <option value="University"> University </option>
                                                                <option value="Corporate"> Corporate </option>
                                                                <option value="Other"> Other </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 ">
                                                        <label>Organization Name</label>
                                                        <div class="form-group select-wizard">
                                                            <input name="organization_name" value="" class="form-control" id="organization_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 ">
                                                        <label>Role</label>
                                                        <div class="form-group select-wizard">
                                                            <select class="selectpicker" name="organization_role" data-size="7" data-style="select-with-transition" title="Single Select">
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
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="mr-auto">
                                    <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Previous">
                                </div>
                                <div class="ml-auto">
                                    <input type="button" class="btn btn-next btn-fill btn-rose btn-wd" name="next" value="Next">
                                    <input type="submit" class="btn btn-finish btn-fill btn-rose btn-wd" name="finish" value="submit" style="display: none;">
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
        $('input[name="finish"]').click(function(event){
            event.preventDefault();
            var formData = document.getElementById("my-form").;
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
                    /*$('.teacher_id').val(result.data['id'])
                    $('input[name="os0"]').val(result.data['id'])
                    $('input[name="item_number"]').val(result.data['id'])*/
                },
                error: function(data)
                {
                    console.log(data);
                    toastr.error(data)
                }
            });
        });
        $('.select2').select2();
    });

</script>
