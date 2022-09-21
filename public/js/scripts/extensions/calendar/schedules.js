'use strict';

/*eslint-disable*/
var ScheduleList = [];

var SCHEDULE_CATEGORY = [
  'task'
];
// constructor
function ScheduleInfo() {
  this.id = null;
  this.calendarId = null;

  this.title = null;
  this.body = null;
  this.isAllday = false;
  this.start = null;
  this.end = null;
  this.category = '';
  this.dueDateClass = '';

  this.color = null;
  this.bgColor = null;
  this.dragBgColor = null;
  this.borderColor = null;
  this.customStyle = '';

  this.isFocused = false;
  this.isPending = false;
  this.isVisible = true;
  this.isReadOnly = false;
  this.goingDuration = 0;
  this.comingDuration = 0;
  this.recurrenceRule = '';

  this.raw = {
    memo: '',
    hasToOrCc: false,
    hasRecurrenceRule: false,
    location: null,
    class: 'public', // or 'private'
    creator: {
      name: '',
      avatar: '',
      company: '',
      email: '',
      phone: ''
    }
  };
}
//time generate and create schedule
function generateTime(schedule, renderStart, renderEnd) {
  var startDate = moment(renderStart.getTime())
  var endDate = moment(renderEnd.getTime());
  var diffDate = endDate.diff(startDate, 'days');

  schedule.isAllday = chance.bool({ likelihood: 30 });
  if (schedule.isAllday) {
    schedule.category = 'allday';
  } else if (chance.bool({ likelihood: 30 })) {
    schedule.category = SCHEDULE_CATEGORY[chance.integer({ min: 0, max: 1 })];
    if (schedule.category === SCHEDULE_CATEGORY[1]) {
      schedule.dueDateClass = 'morning';
    }
  } else {
    schedule.category = 'time';
  }

  startDate.add(chance.integer({ min: 0, max: diffDate }), 'days');
  startDate.hours(chance.integer({ min: 0, max: 23 }))
  startDate.minutes(chance.bool() ? 0 : 30);
  schedule.start = startDate.toDate();

  endDate = moment(startDate);
  if (schedule.isAllday) {
    endDate.add(chance.integer({ min: 0, max: 3 }), 'days');
  }
  schedule.end = endDate
    .add(chance.integer({ min: 1, max: 4 }), 'hour')
    .toDate();

  if (!schedule.isAllday && chance.bool({ likelihood: 20 })) {
    schedule.goingDuration = chance.integer({ min: 30, max: 120 });
    schedule.comingDuration = chance.integer({ min: 30, max: 120 });

    if (chance.bool({ likelihood: 50 })) {
      schedule.end = schedule.start;
    }
  }
}
// randome name generate
function generateNames() {
  var names = [];
  var i = 0;
  var length = chance.integer({ min: 1, max: 10 });

  for (i; i < length; i += 1) {
    names.push(chance.name({ nationality: 'en' }));
  }
  return names;
}
// generate randome schedule
function generateRandomSchedule(calendar, renderStart, renderEnd) {
  var schedule = new ScheduleInfo();

  schedule.id = chance.guid();
  schedule.calendarId = calendar.id;

  schedule.title = chance.name({ nationalty: 'en' });
  schedule.body = chance.bool({ likelihood: 20 }) ? chance.sentence({ words: 10 }) : '';
  schedule.isReadOnly = chance.bool({ likelihood: 20 });
  generateTime(schedule, renderStart, renderEnd);

  schedule.isPrivate = chance.bool({ likelihood: 10 });
  schedule.location = chance.address();
  schedule.attendees = chance.bool({ likelihood: 70 }) ? generateNames() : [];
  schedule.recurrenceRule = chance.bool({ likelihood: 20 }) ? 'repeated events' : '';

  schedule.color = calendar.color;
  schedule.bgColor = calendar.bgColor;
  schedule.dragBgColor = calendar.dragBgColor;
  schedule.borderColor = calendar.borderColor;

  if (schedule.category === 'milestone') {
    schedule.color = schedule.bgColor;
    schedule.bgColor = 'transparent';
    schedule.dragBgColor = 'transparent';
    schedule.borderColor = 'transparent';
  }

  schedule.raw.memo = chance.sentence();
  schedule.raw.creator.name = chance.name();
  schedule.raw.creator.avatar = chance.avatar();
  schedule.raw.creator.company = chance.company();
  schedule.raw.creator.email = chance.email();
  schedule.raw.creator.phone = chance.phone();

  if (chance.bool({ likelihood: 20 })) {
    var travelTime = chance.minute();
    schedule.goingDuration = travelTime;
    schedule.comingDuration = travelTime;
  }

  ScheduleList.push(schedule);
}
// random schedule created
function generateSchedule(viewName, renderStart, renderEnd, callback) {
  ScheduleList = [];
  console.log('DESDE', renderStart);
  Fetchx({
    url: '/actividades/calendario/json',
    type: 'POST',
    data: {
      desde: moment(renderStart.getTime()).format("YYYY-MM-DD"),
      hasta: moment(renderEnd.getTime()).format("YYYY-MM-DD"),
    },
    dataType: 'json',
    headers : {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    },
    success: function(res) {
      console.log('DATA', res);
      for(var index in res.data) {

        var schedule = new ScheduleInfo();

        schedule.id = res.data[index].id;
        schedule.calendarId = res.data[index].calendario_id;

        schedule.title = res.data[index].descripcion;//chance.name({ nationalty: 'en' });
        schedule.body = chance.bool({ likelihood: 20 }) ? chance.sentence({ words: 10 }) : '';
        schedule.isReadOnly = true;//chance.bool({ likelihood: 20 });



        schedule.isAllday = res.data[index].todo_dia;
        if (schedule.isAllday) {
          schedule.category = 'allday';
        } else {
          schedule.category = 'time';
        }

        schedule.start = moment(res.data[index].preparada_desde).toDate();
        //schedule.end   = moment(res.data[index].preparada_hasta).toDate();
        //generateTime(schedule, renderStart, renderEnd);

        schedule.isPrivate = chance.bool({ likelihood: 10 });
        schedule.location = chance.address();
        schedule.attendees = chance.bool({ likelihood: 70 }) ? generateNames() : [];

        schedule.color = calendar.color;
        schedule.bgColor = calendar.bgColor;
        schedule.dragBgColor = calendar.dragBgColor;
        schedule.borderColor = calendar.borderColor;

        if (schedule.category === 'milestone') {
          schedule.color = schedule.bgColor;
          schedule.bgColor = 'transparent';
          schedule.dragBgColor = 'transparent';
          schedule.borderColor = 'transparent';
        }

        schedule.raw.memo = chance.sentence();
        schedule.raw.creator.name = chance.name();
        schedule.raw.creator.avatar = chance.avatar();
        schedule.raw.creator.company = chance.company();
        schedule.raw.creator.email = chance.email();
        schedule.raw.creator.phone = chance.phone();

        ScheduleList.push(schedule);
      }
      callback();
    },
  });
}
