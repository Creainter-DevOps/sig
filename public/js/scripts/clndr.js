// Call this from the developer console and you can control both instances
var calendars = {};

$(document).ready(function () {

    // Assuming you've got the appropriate language files,
    // clndr will respect whatever moment's language is set to.
    moment.locale('es');

    // Here's some magic to make sure the dates are happening this month.
    var thisMonth = moment().format('YYYY-MM');

    // Events to load into calendar
    var eventArray = [
        {
            title: 'Multi-Day Event',
            endDate: thisMonth + '-14',
            startDate: thisMonth + '-10'
        },
        {
            endDate: thisMonth + '-23',
            startDate: thisMonth + '-21',
            title: 'Another Multi-Day Event'
        },
        {
            date: thisMonth + '-27',
            title: 'Single Day Event'
        }
    ];
    var currentMonth = moment().format('YYYY-MM');
    var nextMonth = moment().add('month', 1).format('YYYY-MM');

    /*var events = [
        { date: currentMonth + '-' + '10', title: 'Persian Kitten Auction', location: 'Center for Beautiful Cats' },
        { date: currentMonth + '-' + '10', title: 'Persian Kitten Auction', location: 'Center for Beautiful Cats' },
        { date: currentMonth + '-' + '10', title: 'Persian Kitten Auction', location: 'Center for Beautiful Cats' },

        { date: currentMonth + '-' + '19', title: 'Cat Frisbee', location: 'Jefferson Park' },
        { date: currentMonth + '-' + '23', title: 'Kitten Demonstration', location: 'Center for Beautiful Cats' },
        { date: nextMonth + '-' + '07', title: 'Small Cat Photo Session', location: 'Center for Cat Photography' }
    ];*/


    
    // there are a lot of options. the rabbit hole is deep.
  //    

      $('.calendar').clndr({
          template: $("#calendar-template").html(),
          daysOfTheWeek: ['L', 'M', 'M', 'J', 'V', 'S','D'],
          moment: moment,
          events : events,
          weekOffset: 0,
          startWithMonth: moment(),
          clickEvents: {
              click: function (target) {
                  console.log('clicked', target.events);
                  if (target.events.length) {
                      var daysContainer = $('#mini-clndr').find('.days-container');
                      daysContainer.toggleClass('show-events', true);
                      $('#mini-clndr').find('.x-button').click(function () {
                          daysContainer.toggleClass('show-events', false);
                      });
                  }
              }
          },
          doneRendering: function () {
              console.log('this would be a fine place to attach custom event handlers.');
          },
      });
});
