@extends('subadmin.layouts.main')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">group_add</i>
                            </div>
                            <p class="card-category">Teacher</p>
                            <h3 class="card-title">{{isset($last_24Hours_Teacher) ? $last_24Hours_Teacher : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 24 Hours
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">group_add</i>
                            </div>
                            <p class="card-category">Teacher</p>
                            <h3 class="card-title">{{ isset($last_7_Days_Teacher) ? $last_7_Days_Teacher : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 7 Days
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">group_add</i>
                            </div>
                            <p class="card-category">Teacher</p>
                            <h3 class="card-title">{{ isset($life_Time_Teacher) ? $life_Time_Teacher : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Life Time
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">note_alt</i>
                            </div>
                            <p class="card-category">Launch Quiz</p>
                            <h3 class="card-title">{{ isset($last_24Hours_test) ? $last_24Hours_test : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 24 Hours
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">note_alt</i>
                            </div>
                            <p class="card-category">Launch Quiz</p>
                            <h3 class="card-title">{{ isset($last_7_Days_test) ? $last_7_Days_test : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 7 Days
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">note_alt</i>
                            </div>
                            <p class="card-category">Launch Quiz</p>
                            <h3 class="card-title">{{ isset($life_Time_test) ? $life_Time_test : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Life Time
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">school</i>
                            </div>
                            <p class="card-category">Class Room</p>
                            <h3 class="card-title">{{ isset($last_24Hours_class) ? $last_24Hours_class : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 24 Hours
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">school</i>
                            </div>
                            <p class="card-category">Class Room</p>
                            <h3 class="card-title">{{ isset($last_7_Days_class) ? $last_7_Days_class : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 7 Days
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">school</i>
                            </div>
                            <p class="card-category">Class Room</p>
                            <h3 class="card-title">{{ isset($life_Time_class) ? $life_Time_class : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Life Time
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_box</i>
                            </div>
                            <p class="card-category">User</p>
                            <h3 class="card-title">{{$last_24Hours_students}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 24 Hours
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_box</i>
                            </div>
                            <p class="card-category">User</p>
                            <h3 class="card-title">{{ isset($last_7_Days_students) ? $last_7_Days_students : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 7 Days
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">account_box</i>
                            </div>
                            <p class="card-category">User</p>
                            <h3 class="card-title">{{ isset($life_Time_students) ? $life_Time_students : 0}}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Life Time
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
