@extends('mainlayout')

@php
//$cookiename = 'userlogin_roleid';
//echo $value = Cookie::get($cookiename);
@endphp

@section('breadcrumb')
    <li><a href="#">Home</a></li>
    <li class="active">Event Dashboard</li>
@endsection

@section('maincontent')
<style>
    .fc-list-item-title a:link,
    .fc-list-item-title a:visited {
      color: #447af8;
    }
    
    .fc-list-item-title a:hover {
      color: #000000;
      text-decoration: underline;
    }
    
    .red .fc-event-dot,
    a.fc-day-grid-event.red {
      background-color: red;
      border-color: red;
      color: #FFF !important;
    }
    
    .green .fc-event-dot,
    a.fc-day-grid-event.green {
      background-color: green;
      border-color: green;
      color: #FFF !important;
    }
    
    .orange .fc-event-dot,
    a.fc-day-grid-event.orange {
      background-color: orange;
      border-color: orange;
      color: #FFF !important;
    }
    
    .blue .fc-event-dot,
    a.fc-day-grid-event.blue {
      background-color: blue;
      border-color: blue;
      color: #FFF !important;
    }
    
    .gray .fc-event-dot,
    a.fc-day-grid-event.gray {
      background-color: gray;
      border-color: gray;
      color: #FFF !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Event Dashboard</strong></h3>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <label>Responsible</label>
                        <select class="form-control select" name="person" id="person" onChange="viewCalnder();">
                        <option value="">All</option>
                        @foreach($person as $value)<option value="{{$value->id}}">{{$value->fname.' '.$value->lname}}</option>@endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Assigned Team</label>
                        <select class="form-control select" name="team" id="team" onChange="viewCalnder();">
                        <option value="">All</option>
                        @foreach($team as $value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <div id='calendar'></div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">

@endsection

@section('javascript')
<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.css" rel="stylesheet"/>
<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.print.css" rel="stylesheet"  media="print" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/fullcalendar.min.js"></script>

<script type="text/javascript">

    $(function() {
        $('#calendar').fullCalendar({
    	    header: {
        	    left: 'prevYear,prev,today,next,nextYear',
        	    center: 'title',
        	    right: 'listYear,month,agendaWeek,agendaDay'
        	  },
        	  views: {
        	    month: {
        	      buttonText: 'Month'
        	    },
        	    agendaWeek: {
        	      buttonText: 'Week'
        	    },
        	    agendaDay: {
        	      buttonText: 'Day'
        	    },
        	    listYear: {
        	      buttonText: 'List Year'
        	    }
        	  },
            events: [],
    	    defaultView: 'month',
	        navLinks: true, // can click day/week names to navigate views
	        editable: false,
	        eventLimit: true, // allow "more" link when too many events
	     });
	     
	     viewCalnder();
    });
    
    function viewCalnder(){
       
        var token = $('#_token').val();
            person = $('#person').val();
            team = $('#team').val();
            
        jQuery.ajax({
            url: '/getEvents',
            type: 'POST',
            dataType: 'json',
            // data: {
            //     start: start.format(),
            //     end: end.format()
            // },
            data: { _token:token,'person':person, 'team':team },
            success: function(doc) {
                console.log(doc);
                var today_date = doc.today_date;
                var events = [];
                if(!!doc.events){
                    $.map( doc.events, function( r ) {
                        if(r.exp_start_date != null){
                            
                        
                        var className = '';
                            if(today_date == r.exp_start_date && r.actual_start_date == null){
                                className= 'orange';
                            }else if(today_date > r.exp_start_date && r.actual_start_date == null){
                                className= 'red';
                            }else if(today_date < r.exp_start_date && r.actual_start_date == null){
                                className= 'blue';
                            }else if(r.actual_start_date != null){
                                className= 'green';
                            }else if(r.actual_end_date != null){
                                className= 'gray';
                            }
                            var url = '/event/'+r.id+'/edit';
                            if(r.url == 1){
                                url = '/task/'+r.task_id+'/edit';
                            }
                    
                            events.push({
                                id: r.id,
                                title: r.name,
                                start: r.exp_start_date,
                                end: r.exp_end_date,
                                url: url,
                                className: className
                            });
                        }
                    });
                }
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', events);         
                $('#calendar').fullCalendar('rerenderEvents' );
                
            }
        });
        
    }
    </script>
        
@endsection 
