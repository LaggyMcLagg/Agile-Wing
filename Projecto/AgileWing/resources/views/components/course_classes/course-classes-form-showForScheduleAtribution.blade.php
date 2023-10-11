<style>
  .calendar-container {
    display: flex;
    justify-content: space-between;
  }

  .calendar {
    border-collapse: collapse;
    width: 30%; /* Define a largura do primeiro calendário menor */
    height: 200px;
  }

  .calendar:first-child {
    margin-right: 10px; /* Espaçamento entre os calendários */
  }

  .calendar th,
  .calendar td {
    border: 1px solid #ddd;
    padding: 4px;
    text-align: center;
    width: 28px;
    height: 28px;
  }

  .calendar th {
    background-color: #87CEFA;
  }

  .calendar h2 {
    margin: 0;
  }

  .schedule {
    flex: 1; /* Ocupa todo o espaço restante */
    border-collapse: collapse;
    width: 600px; /* largura do segundo calendário maior */
    height: 600px;
    margin-left: 10px; /* Espaçamento entre os calendários */
  }

  .schedule th,
  .schedule td {
    border: 1px solid #ddd;
    padding: 4px;
    width: 200px;
    height: 60px;
    text-align: center;
  }

  .schedule th {
    background-color: #87CEFA;
  }
</style>
</head>
<body>

<h3>{{ $courseClass->name }} - {{ $courseClass->number }}</h3>

<div class="calendar-container">
    <div class="calendar">
      <div class="calendar-header">
        <button id="prevMonth"><</button>
        <h5 id="currentMonthYear"></h5>
        <button id="nextMonth">></button>
      </div>
      <table id="calendar">

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
</div>
<div class="schedule">
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
    let januaryFourth = new Date(Date.UTC(year, 0, 4));
    let daysToNextSunday = (7 - januaryFourth.getUTCDay()) % 7;
    let firstSunday = new Date(Date.UTC(year, 0, 4 + daysToNextSunday));
    let startDate = new Date(firstSunday);
    startDate.setUTCDate((firstSunday.getUTCDate() + (weekNumber - 1) * 7) - 9);
    let endDate = new Date(startDate);
    endDate.setUTCDate(startDate.getUTCDate() + 8);

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

  function getEventsFromDate(events, date) {
    console.log(events)
    return events.filter(function(event) {
        const eventDate = new Date(event.date);

        const currentDate = new Date(Date.UTC(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
        ));

        return (
            eventDate.getUTCFullYear() === currentDate.getUTCFullYear() &&
            eventDate.getUTCMonth() === currentDate.getUTCMonth() &&
            eventDate.getUTCDate() === currentDate.getUTCDate()
        );
    });
  }

  function calculateSlots(start, end) {
    const startTime = new Date(start);
    const endTime = new Date(end);

    // Caclular diferença de tempo em minutos
    const timeDiff = (endTime - startTime) / (1000 * 60);

    return parseInt(timeDiff / 60);
  }

  function getUfcdById(id) {
    return ufcds.find(ufcd => ufcd.id === id);
  }

  function getUserById(id) {
    return users.find(user => user.id === id);
  }

  function generateSchedule(events) {
  let body = scheduleTable.getElementsByTagName('tbody')[0];
  let rowList = [];

  let hourArray = [];

  for (let i = 0; i < hourBlocks.length; i++) {
    let newRow = body.insertRow(body.rows.length);
    rowList.push(newRow);
    hourArray.push(hourBlocks[i].hour_beginning);
    let cell = newRow.insertCell(0);
    cell.innerHTML = hourBlocks[i].hour_beginning + " - " + hourBlocks[i].hour_end;
  }

  for (let i = 0; i < events.length; i++) {
    for (let j = 0; j < hourArray.length; j++) {
      let startTime = new Date(events[i].hour_start);
      let endTime = new Date(events[i].hour_end);
      let startHours = startTime.getUTCHours().toString();
      let endHours = endTime.getUTCHours().toString();
      let parsedStartTime = "";
      let parsedEndTime = "";
      if (startHours.length === 1) {
        parsedStartTime = "0" + startTime.getUTCHours() + ":" + startTime.getMinutes() + ":00";
      } else {
        parsedStartTime = startTime.getUTCHours() + ":" + startTime.getMinutes() + ":00";
      }

      if (parsedStartTime === hourArray[j]) {
        events[i].startSlot = j;
      }
    }
    events[i].rowSpan = calculateSlots(events[i].hour_start, events[i].hour_end)
    events[i].endSlot = events[i].startSlot + (events[i].rowSpan - 1);
    }

    let currentDay = weekDates.startDate;
  let isoDate = currentDay.toUTCString();
  let datePart = isoDate.split('T')[0];

  let nextDay = currentDay.setUTCDate(currentDay.getUTCDate() + 2);

  for (let currentColumn = 0; currentColumn < 7; currentColumn++) {
    let currentEvents = getEventsFromDate(events, currentDay);
    console.log(currentEvents)
    if (currentEvents.length === 0) {
      for (let i = 0; i <= 6; i++) {
        let td = document.createElement("td");
        rowList[i].appendChild(td);
        console.log(td)
      }
    } else {
        let slotCount = 0;
      for (let j = 0; j < currentEvents.length; j++) {
        let event = currentEvents[j];
        let startSlot = event.startSlot;
        let endSlot = event.endSlot;
        let rowSpan = event.rowSpan;
        let ufcd = getUfcdById(event.ufcd_id);
        let user = getUserById(event.user_id);

        if (startSlot !== 0 && j === 0) {
            for (let x = 0; x < startSlot; x++) {
                let td = document.createElement("td");
                rowList[x].appendChild(td);
                console.log(td)
            }
            let td = document.createElement("td");
            td.rowSpan = rowSpan;
            /*let editLink = document.createElement("a");
            editLink.href = `/editScheduleAtribution/${event.id}`; // tem de colcoar o url correto
            editLink.textContent = ufcd.number + " - " +  user.name;*/

            td.textContent = ufcd.number + " - " +  user.name;

            console.log(td)
            console.log(startSlot)
            console.log(endSlot)
            console.log(ufcd.number);
            console.log(user.name)
            console.log(currentColumn)
            rowList[startSlot].appendChild(td);
            slotCount += endSlot;
        } else {
            let rowSpan = event.rowSpan;
            let ufcd = getUfcdById(event.ufcd_id);
            let user = getUserById(event.user_id);
            let td = document.createElement("td");
            td.rowSpan = rowSpan;
            td.textContent = ufcd.number + " - " +  user.name;
            console.log("Appended: " + startSlot)
            rowList[startSlot].appendChild(td);
            console.log(td)
            console.log(startSlot)
            console.log(endSlot);
            console.log(ufcd.number);
            console.log(user.name)
            console.log(currentColumn)
            slotCount += endSlot;
        }
        }
        if(slotCount < 6) {
            for (let x = slotCount; x < 7; x++) {
                let td = document.createElement("td");
                rowList[x].appendChild(td);
                console.log(td)
            }

        }

    }
    currentDay.setDate(currentDay.getUTCDate() + 1);

    }

/*
    let newCell = rowList[0].insertCell(1);
    newCell.innerHTML = "UFCD1 - Professor"
    let newCell2 = rowList[0].insertCell(3);
    newCell2.innerHTML = "UFCD1 - Professor" */

  }


  let scheduleAtributions = JSON.parse(@json($scheduleAtributions));
  let hourBlocks = JSON.parse(@json($hourBlocks));
  let users = JSON.parse(@json($users));
  let ufcds = JSON.parse(@json($ufcds));

  let currentDate = new Date();
  let currentYear = currentDate.getFullYear();
  let currentMonth = currentDate.getMonth();
  let currentWeek = currentDate.getWeek();

  let weekDates = getStartAndEndDateOfWeek(currentYear, currentWeek);

  let filteredEvents = filterByDateRange(scheduleAtributions, weekDates.startDate, weekDates.endDate);

  filteredEvents.sort(function(a, b) {
        const timeA = new Date(a.hour_start).getTime();
        const timeB = new Date(b.hour_start).getTime();
        return timeA - timeB;
    });

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

</div>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
