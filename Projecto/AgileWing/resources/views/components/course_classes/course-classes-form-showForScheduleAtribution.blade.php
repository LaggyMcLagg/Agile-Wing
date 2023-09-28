<style>
  #calendar {
    border-collapse: collapse;
    width: 200px; /* line 4 and 5 defines the height and width of the calendar*/
    height: 200px;
  }

  #calendar th, #calendar td {
    border: 1px solid #ddd;
    padding: 4px;
    text-align: center;
    width: 28px; /* line 12 and 13 defines de size of the cells of the days*/
    height: 28px;
  }

  #calendar th {
    background-color: #87CEFA;
  }


  .calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 200px;
  }

  .calendar-header h2 {
    margin: 0;
    }

    #schedule {
    border-collapse: collapse;
    width: 900px; /* line 4 and 5 defines the height and width of the calendar*/
    height: 600px;
  }

  #schedule th, #schedule td {
    border: 1px solid #ddd;
    padding: 4px;
    text-align: center;
  }

  #schedule th {
    background-color: #87CEFA;
  }


</style>
</head>
<body>

<h3>{{ $courseClass->name }} - {{ $courseClass->number }}</h3>

<div class="calendar-header">
  <button id="prevMonth"><</button>
  <h5 id="currentMonthYear"></h5>
  <button id="nextMonth">></button>
</div>

<table id="calendar">
  <thead>
    <tr>
      <th>D</th>
      <th>S</th>
      <th>T</th>
      <th>Q</th>
      <th>Q</th>
      <th>S</th>
      <th>S</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<br/>
<table id="schedule">
  <thead>
    <tr>
      <th>Hora</th>
      <th>D</th>
      <th>S</th>
      <th>T</th>
      <th>Q</th>
      <th>Q</th>
      <th>S</th>
      <th>S</th>
    </tr>
  </thead>
  <tbody>


  </tbody>
</table>

<script>
  const prevMonthButton = document.getElementById('prevMonth');
  const nextMonthButton = document.getElementById('nextMonth');
  const currentMonthYear = document.getElementById('currentMonthYear');
  const calendarBody = document.querySelector('#calendar tbody');
  const scheduleTable = document.getElementById('schedule');

  Date.prototype.getWeek = function() {
    let date = new Date(this.getTime());
    date.setHours(0, 0, 0, 0);
    date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
    let week1 = new Date(date.getFullYear(), 0, 4);
    return 1 + Math.round(((date - week1) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
  }

  function getStartAndEndDateOfWeek(year, weekNumber) {
    let januaryFourth = new Date(year, 0, 4);
    let daysToNextSunday = (7 - januaryFourth.getDay()) % 7;
    let firstSunday = new Date(year, 0, 4 + daysToNextSunday);
    let startDate = new Date(firstSunday);
    startDate.setDate((firstSunday.getDate() + (weekNumber - 1) * 7) - 7);
    let endDate = new Date(startDate);
    endDate.setDate(startDate.getDate() + 6);

    return {
        startDate: startDate,
        endDate: endDate
    }
  }

  function filterByDateRange(events, startDate, endDate) {
    return events.filter(event => {
        const eventDate = new Date(event.date);
        return eventDate >= startDate && eventDate <= endDate;
    })
  }

  function generateSchedule(events) {
    let body = scheduleTable.getElementsByTagName('tbody')[0];
    let newRow = body.insertRow(body.rows.length);
    console.log(newRow);

    for(let i = 0; i < events.length; i++) {
        console.log("UFCD: " + events[i].ufcd_id);
        console.log("Date: " + events[i].date);
        console.log("Hour Start: " + new Date(events[i].hour_start).toLocaleTimeString('en-US', { hour12: false}));
        console.log("Hour End: " + new Date(events[i].hour_end).toLocaleTimeString('en-US', { hour12: false}));
    }
  }

  let scheduleAtributions = JSON.parse(@json($scheduleAtributions));
  console.log(scheduleAtributions)

  let currentDate = new Date();
  let currentYear = currentDate.getFullYear();
  let currentMonth = currentDate.getMonth();
  let currentWeek = currentDate.getWeek();
  console.log(currentWeek)

  let weekDates = getStartAndEndDateOfWeek(2023, currentWeek);

  console.log(weekDates.startDate.toDateString());
  console.log(weekDates.endDate.toDateString());

  let filteredEvents = filterByDateRange(scheduleAtributions, weekDates.startDate, weekDates.endDate);

  filteredEvents.sort(function(a, b) {
    return new Date(a.date) - new Date(b.date);
  });

  console.log(filteredEvents)

  generateSchedule(filteredEvents);



  function updateCalendar() {
    const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
    const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
    const daysInMonth = lastDayOfMonth.getDate();
    const firstDayOfWeek = firstDayOfMonth.getDay();

    currentMonthYear.textContent = `${firstDayOfMonth.toLocaleDateString('default', { month: 'long' })} ${currentYear}`;

    let dayCounter = 1;
    let html = '';

    for (let i = 0; i < 6; i++) {
      html += '<tr>';

      for (let j = 0; j < 7; j++) {
        if (i === 0 && j < firstDayOfWeek) {
          html += '<td></td>';
        } else if (dayCounter <= daysInMonth) {
          html += `<td>${dayCounter}</td>`;
          dayCounter++;
        } else {
          html += '<td></td>';
        }
      }

      html += '</tr>';
    }

    calendarBody.innerHTML = html;
  }

  prevMonthButton.addEventListener('click', () => {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear--;
    } else {
      currentMonth--;
    }

    updateCalendar();
  });

  nextMonthButton.addEventListener('click', () => {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear++;
    } else {
      currentMonth++;
    }

    updateCalendar();
  });

  updateCalendar();
</script>




<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
