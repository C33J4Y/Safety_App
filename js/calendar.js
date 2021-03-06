    mobiscroll.settings = {
        theme: 'ios',
        themeVariant: 'light',
        lang: 'en'
    };

    // Load the SDK asynchronously
    function loadGoogleSDK() {
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//apis.google.com/js/client.js?onload=onGoogleLoad";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'google-jssdk'));
    }
    
    function onGoogleLoad() {
        gapi.auth.init(function () {});
    }
    
    function getEventProps(event, calId) {
        return {
            start: event.start.date || event.start.dateTime,
            end: ((new Date(event.end.date) - new Date(event.start.date)) / 86400000 == 1 ? '' : event.end.date) || event.end.dateTime,
            text: event.summary || 'No Title',
            calendarId: calId,
            color: eventColors[event.colorId] || calColors[calId]
        };
    }
    // Client ID Goes below
    var clientId = '603156260115-dec5cqlr0ri5uu3rdsceuoa1kqaec5q1.apps.googleusercontent.com',
        eventColors = {},
        calColors = {},
        calIds = {},
        calInst,
        formInst,
        calApiLoaded,
        firstDay,
        lastDay;

    loadGoogleSDK();
    
    formInst = mobiscroll.form('#demo-google-cal-form');
    
    calInst = mobiscroll.eventcalendar('#demo-google-cal', {
        theme: 'ios',                      // Specify theme like: theme: 'ios' or omit setting to use default
        themeVariant: 'light',             // More info about themeVariant: https://docs.mobiscroll.com/4-10-3/javascript/eventcalendar#opt-themeVariant
        lang: 'en',                        // Specify language like: lang: 'pl' or omit setting to use default
        display: 'inline',                 // Specify display mode like: display: 'bottom' or omit setting to use default
        view: {                            // More info about view: https://docs.mobiscroll.com/4-10-3/javascript/eventcalendar#opt-view
            calendar: {
                labels: true               // More info about labels: https://docs.mobiscroll.com/4-10-3/javascript/eventcalendar#opt-labels
            }
        },
        data: [],                          // More info about data: https://docs.mobiscroll.com/4-10-3/javascript/eventcalendar#opt-data
        onPageLoading: function (event) {  // More info about onPageLoading: https://docs.mobiscroll.com/4-10-3/javascript/eventcalendar#event-onPageLoading
            var year = event.firstDay.getFullYear(),
                month = event.firstDay.getMonth();
    
            firstDay = new Date(year, month - 1, -7);
            lastDay = new Date(year, month + 2, 14);
    
            if (calApiLoaded) {
                var batch = gapi.client.newBatch();
                for (var id in calIds) {
                    batch.add(gapi.client.calendar.events.list({
                        'calendarId': id,
                        'timeMin': firstDay.toISOString(),
                        'timeMax': lastDay.toISOString()
                    }), { id: id });
                }
                if (Object.getOwnPropertyNames(calIds).length !== 0) {
                    batch.then(function (resp) {
                        var eventList = [],
                            res = resp.result;
                        for (var r in res) {
                            var events = res[r].result.items;
                            for (var i = 0; i < events.length; ++i) {
                                eventList.push(getEventProps(events[i], r));
                            }
                        }
                        calInst.setEvents(eventList);
                    });
                }
            }
        }
    });
    
    // Google auth
    document.getElementById('demo-google-auth')
        .addEventListener('click', function (ev) {
            if (!calApiLoaded) {
                gapi.auth.authorize({
                    client_id: clientId,
                    scope: 'https://www.googleapis.com/auth/calendar',
                    immediate: false
                }).then(function (authResult) {
                    // Load the calendar API
                    if (authResult) {
                        return gapi.client.load('calendar', 'v3');
                    }
                }).then(function () {
                    calApiLoaded = true;
                    ev.target.style.display = 'none';
                    // Load calendar colors
                    return gapi.client.calendar.colors.get({
                        'fields': 'event'
                    });
                }).then(function (resp) {
                    var ev = resp.result.event;
                    for (var i = 0; i < ev.length; ++i) {
                        eventColors[i] = ev[i].color.background;
                    }
                    // Load calendar list
                    return gapi.client.calendar.calendarList.list({
                        'fields': 'items(backgroundColor,colorId,description,id,summary)'
                    });
                }).then(function (resp) {
                    // Populate the calendar list
                    var html = '',
                        cals = resp.result.items;
                    for (var i = 0; i < cals.length; ++i) {
                        var cal = cals[i];
                        calColors[cal.id] = cal.backgroundColor;
                        html += '<label>' +
                            '<input data-role="switch" type="checkbox" class="md-cal-sync" data-calendar-id="' + cal.id + '">' +
                            cal.summary +
                            '<span class="mbsc-desc">' +
                            (cal.description || 'No description') + '</span>' +
                            '</label>';
                    }
                    document.getElementById('demo-google-cal-list').innerHTML = html;
                    document.getElementById('calendarSettings').style.display ='block';
                    formInst.refresh();
                }).catch(function (err) {
                    // TODO test for more errors
                    mobiscroll.toast({
                        
                        message: err.error
                    });
                });
            }
        });
    
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('md-cal-sync')) {
    
            var calId = event.target.getAttribute('data-calendar-id');
    
            if (e.target.checked) {
                // Add events from this calendar
                calIds[calId] = true;
                gapi.client.calendar.events.list({
                    'calendarId': calId,
                    'timeMin': firstDay.toISOString(),
                    'timeMax': lastDay.toISOString()
                }).then(function (resp) {
                    var eventList = [],
                        events = resp.result.items;
                    for (var i = 0; i < events.length; ++i) {
                        eventList.push(getEventProps(events[i], calId));
                    }
                    calInst.addEvent(eventList);
                });
            } else {
                // Remove events from this calendar
                var i,
                    eventList = calInst.getEvents(),
                    eventsToRemove = [];
    
                for (i = 0; i < eventList.length; i++) {
                    if (eventList[i].calendarId == calId) {
                        eventsToRemove.push(eventList[i]._id);
                    }
                }
    
                calInst.removeEvent(eventsToRemove);
    
                delete calIds[calId];
            }
            return false;
        }
    });