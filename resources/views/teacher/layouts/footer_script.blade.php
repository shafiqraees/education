<!--   Core JS Files   -->
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/plugins/perfect-scrollbar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/select2.min.js')}}" type="text/javascript"></script>
<!-- Plugin for the momentJs  -->
<script src="{{asset('public/assets/js/plugins/moment.min.js')}}" type="text/javascript"></script>
<!--  Plugin for Sweet Alert -->
<script src="{{asset('public/assets/js/plugins/sweetalert2.js')}}" type="text/javascript"></script>
{{--<script src="{{asset('public/assets/js/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/plugins/sweet-alerts.js')}}" type="text/javascript"></script>--}}
<!-- Forms Validations Plugin -->
<script src="{{asset('public/assets/js/plugins/jquery.validate.min.js')}}" type="text/javascript"></script>
<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="{{asset('public/assets/js/plugins/jquery.bootstrap-wizard.js')}}" type="text/javascript"></script>
<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="{{asset('public/assets/js/plugins/bootstrap-selectpicker.js')}}" type="text/javascript"></script>
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="{{asset('public/assets/js/plugins/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
<script src="{{asset('public/assets/js/plugins/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="{{asset('public/assets/js/plugins/bootstrap-tagsinput.js')}}" type="text/javascript"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="{{asset('public/assets/js/plugins/jasny-bootstrap.min.js')}}" type="text/javascript"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="{{asset('public/assets/js/plugins/fullcalendar.min.js')}}" type="text/javascript"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="{{asset('public/assets/js/plugins/jquery-jvectormap.js')}}" type="text/javascript"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{asset('public/assets/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="{{asset('public/assets/js/plugins/arrive.min.js')}}" type="text/javascript"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Chartist JS -->
<script src="{{asset('public/assets/js/plugins/chartist.min.js')}}" type="text/javascript"></script>
<!--  Notifications Plugin    -->
<script src="{{asset('public/assets/js/plugins/bootstrap-notify.js')}}" type="text/javascript"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{asset('public/assets/js/material-dashboard.js?v=2.2.2')}}" type="text/javascript"></script>

<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "INPUT",
                searchPlaceholder: "Search records",
            }
        });

        var table = $('#datatables').DataTable();

        // Edit record

        /*table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record

        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');

            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record

        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });*/
        // initialise Datetimepicker and Sliders
        md.initFormExtendedDatetimepickers();
        if ($('.slider').length != 0) {
            md.initSliders();
        }
        /*var dateToday = new Date();
        $('#datetime').datepicker({
            minDate: 0,
            format: "yyyy/mm/dd",
        });*/
    });
    function setFormValidation(id) {
        $(id).validate({
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
                $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
            },
            success: function(element) {
                $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
                $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error);
            },
        });
    }

    $(document).ready(function() {
        setFormValidation('#RegisterValidation');
        setFormValidation('#TypeValidation');
        setFormValidation('#LoginValidation');
        setFormValidation('#RangeValidation');
    });
    $(document).on('click','.editpopup',function(e){
        e.preventDefault();
        $('#exampleModal').modal('show');
    });
</script>



