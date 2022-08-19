
@extends('layout.Layout')

@section('body')
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-md-12">
                <h2>Citas</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div id="calendario"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/locales-all.js"></script>

    <script>

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendario');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: 'es',
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
          },
          dateClick: function(info) {

          }
        });
        calendar.render();
    });

       
    </script>
@endsection
