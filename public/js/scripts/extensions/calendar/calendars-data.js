'use strict';

var CalendarList = [],
  primaryColor = "#5A8DEE",
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
// contructor to create event
function CalendarInfo() {
  this.id = null;
  this.name = null;
  this.alias = null;
  this.checked = true;
  this.color = null;
  this.bgColor = null;
  this.borderColor = null;
}

function addCalendar(calendar) {
  CalendarList.push(calendar);
}
function findCalendar(id) {
  var found;
  CalendarList.forEach(function (calendar) {
    if (calendar.id === id) {
      found = calendar;
    }
  });
  return found || CalendarList[0];
}
function processProjects(renderStart, renderEnd, callback) {
  CalendarList = [];
  var calendar;
  Fetchx({
    url: '/actividades/calendario/proyectos/json',
    type: 'POST',
    data: {
      desde: moment(renderStart.getTime()).format("YYYY-MM-DD"),
      hasta: moment(renderEnd.getTime()).format("YYYY-MM-DD"),
    },
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    dataType: 'json',
    success: function(res) {
      for(var index in res.data) {
        calendar = new CalendarInfo();
        calendar.id = res.data[index].calendario_id;
        calendar.name = res.data[index].codigo;
        calendar.alias = res.data[index].rotulo;
        calendar.color = infoColor;
        calendar.bgColor = infoLight;
        calendar.dragBgColor = infoColor;
        calendar.borderColor = infoColor;
        addCalendar(calendar);
      }
      callback();
    },
  });
};
