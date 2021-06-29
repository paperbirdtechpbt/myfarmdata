<!-- START PRELOADS -->
<audio id="audio-alert" src="{{asset('audio/alert.mp3')}}" preload="auto"></audio>
<audio id="audio-fail" src="{{asset('audio/fail.mp3')}}" preload="auto"></audio>
<!-- END PRELOADS -->

<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="{{asset('js/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/jquery/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap.min.js')}}"></script>
<!-- END PLUGINS -->

{{--crop image js--}}
<script type="text/javascript" src="{{asset('crop/croppie.js')}}"></script>
<script type="text/javascript" src="{{asset('crop/upload.js')}}"></script>

<!-- START THIS PAGE PLUGINS-->
<script type='text/javascript' src='{{asset('js/plugins/icheck/icheck.min.js')}}'></script>
<script type="text/javascript" src="{{asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/scrolltotop/scrolltopcontrol.js')}}"></script>

{{--Data table script--}}
<script type="text/javascript" src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>

{{--Two column form script--}}
<script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/bootstrap/bootstrap-select.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>

{{--JS validation--}}
<script type='text/javascript' src='{{asset('js/plugins/validationengine/languages/jquery.validationEngine-en.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/validationengine/jquery.validationEngine.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/jquery-validation/jquery.validate.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/maskedinput/jquery.maskedinput.min.js')}}'></script>

{{--notyConfirm js--}}
<script type='text/javascript' src='{{asset('js/plugins/noty/jquery.noty.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/noty/layouts/topCenter.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/noty/layouts/topLeft.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/noty/layouts/topRight.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/noty/themes/default.js')}}'></script>

{{--file handling js--}}
<script type="text/javascript" src="{{asset('js/plugins/dropzone/dropzone.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/fileinput/fileinput.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/filetree/jqueryFileTree.js')}}"></script>

{{--Dashboard js--}}
<script type="text/javascript" src="{{asset('js/plugins/morris/raphael-min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/morris/morris.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/rickshaw/d3.v3.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/rickshaw/rickshaw.min.js')}}"></script>
<script type='text/javascript' src='{{asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}'></script>
<script type='text/javascript' src='{{asset('js/plugins/bootstrap/bootstrap-datepicker.js')}}'></script>
<script type="text/javascript" src="{{asset('js/plugins/owl/owl.carousel.min.js')}}"></script>

{{--<script type="text/javascript" src="../js/plugins/moment.min.js"></script>--}}
<!--<script type="text/javascript" src="{{asset('js/plugins/moment.min.js')}}"></script>-->
<!--<script type="text/javascript" src="{{asset('js/plugins/fullcalendar/fullcalendar.min.js')}}"></script>-->
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>-->
<script type="text/javascript" src="{{asset('js/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- END THIS PAGE PLUGINS-->

{{--Google Map js--}}
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUP0E9g90ZFFzilcdyOhl0mjZv_hvqSQU&sensor=false&amp;callback=initialize&libraries=places" type="text/javascript"></script>--><!--original-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUP0E9g90ZFFzilcdyOhl0mjZv_hvqSQU&callback=initMap&libraries=places&v=weekly" async ></script>-->
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUP0E9g90ZFFzilcdyOhl0mjZv_hvqSQU&sensor=false&amp;callback=GetLocation&libraries=places" type="text/javascript"></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUP0E9g90ZFFzilcdyOhl0mjZv_hvqSQU&sensor=false&amp;callback=initialize&libraries=drawing" type="text/javascript"></script>-->
<!--<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=drawing"></script>-->
<!--<script async defer src="https://maps.googleapis.com/maps/api/js?callback=GetLocation">-->

<!-- START TEMPLATE -->
<script type="text/javascript" src="{{asset('js/settings.js')}}"></script>

<script type="text/javascript" src="{{asset('js/plugins.js')}}"></script>
<script type="text/javascript" src="{{asset('js/actions.js')}}"></script>

<!--<script type="text/javascript" src="../js/demo_dashboard.js"></script>-->
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->

<script type="text/javascript">
	$('.number').bind('keypress',function(e){
        return ( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)) ? false : true ;
    });
    
    $( ".email" ).keyup(function() {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,3})$/;
        if (reg.test(this.value) == false) {
            $( this ).css( "border-color", "#E04B4A" );
            return false;
        }
        if ($( this ).val() != '') { $( this ).css( "border-color", "#95b75d" ); }
        else { $( this ).css( "border-color", "#D5D5D5" ); }
        return true;
    });
</script>