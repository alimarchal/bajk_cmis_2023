


@stack('modals')

@livewireScripts

<!-- jQuery -->
<script src="{{url('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('AdminLTE/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{url('AdminLTE/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
{{--<script src="{{url('AdminLTE/plugins/sparklines/sparkline.js')}}"></script>--}}
<!-- JQVMap -->
<script src="{{url('AdminLTE/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{url('AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('AdminLTE/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('AdminLTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{url('AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{url('AdminLTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{url('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('AdminLTE/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('AdminLTE/dist/js/demo.js')}}"></script>

<!-- Select2 -->
{{--<script src="{{url('AdminLTE/plugins/select2/js/select2.full.min.js')}}"></script>--}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{url('AdminLTE/dist/js/pages/dashboard.js')}}"></script>--}}


<script src="{{url('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Select2 -->
<script src="{{url('AdminLTE/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{url('AdminLTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- InputMask -->
<script src="{{url('AdminLTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{url('AdminLTE/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{url('AdminLTE/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{url('AdminLTE/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{url('AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- BS-Stepper -->
<script src="{{url('AdminLTE/plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
<!-- dropzonejs -->
<script src="{{url('AdminLTE/plugins/dropzone/min/dropzone.min.js')}}"></script>
<!-- AdminLTE App -->
{{--<script src="{{url('AdminLTE/dist/js/adminlte.min.js')}}"></script>--}}
<!-- AdminLTE for demo purposes -->
<script src="{{url('AdminLTE/dist/js/demo.js')}}"></script>

{{--<!-- jQuery -->--}}
{{--<script src="{{url('AdminLTE/plugins/jquery/jquery.min.js')}}"></script>--}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="{{url('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script>
    $('form').submit(function(){
        $(this).find(':submit').attr('disabled','disabled');
    });
</script>

@yield('customFooterScripts')
