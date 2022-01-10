@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@section('title','Dashboard Ecommerce')
{{-- vendor css --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/tui-time-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/tui-date-picker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/calendars/tui-calendar.min.css')}}">
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-ecommerce.css')}}">
@endsection

@section('content')
<section id="dashboard-ecommerce">
  <div class="card marketing-campaigns">
    <div class="card-header d-flex justify-content-between align-items-center pb-1">
      <h4 class="card-title">Reporte01</h4>
    </div>
    <div id="calendar" class="calendar-content"></div>
  </div>
</section>
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/calendar/tui-code-snippet.min.js')}}"></script>
<script src="{{asset('vendors/js/calendar/tui-dom.js')}}"></script>
<script src="{{asset('vendors/js/calendar/tui-time-picker.min.js')}}"></script>
<script src="{{asset('vendors/js/calendar/tui-date-picker.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/calendar/chance.min.js')}}"></script>
<script src="{{asset('vendors/js/calendar/tui-calendar.min.js')}}"></script>
@endsection

@section('page-scripts')
<script>
(function (window, Calendar) {
  var primaryColor = "#5A8DEE",
  primaryLight = "#E2ECFF",
  secondaryColor = "#475F7B",
  secondaryLight = "#E6EAEE",
  successColor = "#39DA8A",
  successLight = "#D2FFE8",
  dangercolor = "#FF5B5C",
  dangerLight = "#FFDEDE",
  warningColor = "#FDAC41",
  warningLight = "#FFEED9",
  infoColor = "#00CFDD",
  infoLight = "#CCF5F8 ",
  lightColor = "#b3c0ce",
  veryLightBlue = "#e7edf3",
  cloudyBlue = "#b3c0ce";

  var cal, resizeThrottled;
  var useCreationPopup = true;
  var useDetailPopup = true;

  var themeConfig = {
    'common.border': '1px solid #DFE3E7',
    'common.backgroundColor': 'white',
    'common.holiday.color': '#FF5B5C',
    'common.saturday.color': '#304156',
    'common.dayname.color': '#304156',
    'month.dayname.borderLeft': '1px solid transparent',
    'month.dayname.fontSize': '1rem',
    'week.dayGridSchedule.borderRadius': '4px',
    'week.timegridSchedule.borderRadius': '4px',
  };

  cal = new Calendar('#calendar', {
    defaultView: 'month',
    calendars: data,
    theme: themeConfig,
    template: {
      milestone: function (model) {
        return '<span class="bx bx-flag align-middle"></span> <span style="background-color: ' + model.bgColor + '">' + model.title + '</span>';
      },
    }
  });
  cal.createSchedules([
    {
        id: '1',
        calendarId: '1',
        title: 'my schedule',
        category: 'time',
        dueDateClass: '',
        start: '2022-01-04T22:30:00+09:00',
        end: '2022-01-06T02:30:00+09:00'
    },
    {
        id: '2',
        calendarId: '1',
        title: 'second schedule',
        category: 'time',
        dueDateClass: '',
        start: '2022-01-18T17:30:00+09:00',
        end: '2022-01-19T17:31:00+09:00',
        isReadOnly: true
    }
  ]);
})(window, tui.Calendar);
</script>
@endsection

