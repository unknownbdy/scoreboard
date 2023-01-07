<!doctype html>
<html lang="en">
  <head>
    <title>ScoreBoard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      .textalign
      {
        position: absolute;
        margin-top: 36PX;                  
        padding-left: 121px;
      }

    </style>
  </head>
  <body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand">Score Board</a> 
            <button class="btn btn-outline-success" onclick="return show_hide_table()">Show All Matches</button>
        </div>
      </nav>
    
 
        <div class='container'>
            <form action="{{url('/')}}/GetScoreDetail" id="form" method="post">
                {{ csrf_field() }}
            <div class='row'>
              <div class='col-lg-5 my-4 m-auto' >
                <div class="input-group">
                  <input name="match_id" value="{{rand(0,999)}}" type="hidden" />
                    <span class="input-group-text">Team First&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <input type="text" name="team_first" aria-label="First name" placeholder="Enter Team First"  class="form-control"> 
                     
                    <span class="text-danger textalign" >
                      @error('team_first')
                          {{$message}}
                      @enderror
                    </span>
                  </div>
                  <br><br>
                  <div class="input-group">
                    <span class="input-group-text">Team Second</span>
                    <input type="text" name="team_second" aria-label="First name" placeholder="Enter Team Second" class="form-control"> 
                    <span class="text-danger textalign">
                      @error('team_second')
                          {{$message}}
                      @enderror
                    </span>
                  </div>
                  <br><br>
                  <div class="input-group">
                    <span class="input-group-text">Time Duration</span>
                    <input type="text" placeholder="mm:mm" id="time_duration" data-slots="dmyh" name="time_duration" aria-label="First name" class="form-control"> 
                    <span class="text-danger textalign">
                      @error('time_duration')
                          {{$message}}
                      @enderror
                    </span>
                  </div>
                  <br /><br>
                  <div class="input-group" style="text-align: center">
                    <button type="submit" class="btn btn-primary">Start</button>
                  </div>
              </div>
              <div class='col-lg-7 my-8 m-auto' > 
                <table class="table table-hover border" id="history_table" style="display: none">
                   
                    <thead>
                      <tr>
                        <th scope="col">MatchID</th>
                        <th scope="col">Team-A</th>
                        <th scope="col">Team-A Score</th>
                        <th scope="col">Team-B</th>
                        <th scope="col">Team-B Score</th>
                        <th scope="col">Result</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if (!empty($scoreDetail))
                    @foreach ($scoreDetail as $score_values)
                      <tr>
                        <th scope="row">#{{$score_values->match_id}}</th>
                        <td>{{$score_values->team_first}}</td>
                        <td>{{$score_values->team_first_score}}</td>
                        <td>{{$score_values->team_second}}</td>
                        <td>{{$score_values->team_second_score}}</td>
                        @If($score_values->team_first_win=='WON')
                        <td><strong style="color: green">{{$score_values->team_first.' WON'}}</strong></td>
                        @elseif (($score_values->team_second_win=='WON'))
                        <td><strong style="color: green">{{$score_values->team_second.' - WON'}}</strong></td>
                        @else
                        <td><strong style="color: green">DRAW</strong></td>
                        @endif
                      </tr>
                      @endforeach    
                      @endif
                    </tbody>
                  </table>
              </div>
            </div>
        </form>
          </div>


         
  

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
        
    <script>
      document.addEventListener('DOMContentLoaded', () => {
    for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
        const pattern = el.getAttribute("placeholder"),
            slots = new Set(el.dataset.slots || "_"),
            prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
            first = [...pattern].findIndex(c => slots.has(c)),
            accept = new RegExp(el.dataset.accept || "\\d", "g"),
            clean = input => {
                input = input.match(accept) || [];
                return Array.from(pattern, c =>
                    input[0] === c || slots.has(c) ? input.shift() || c : c
                );
            },
            format = () => {
                const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                    i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                    return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                });
                el.value = clean(el.value).join``;
                el.setSelectionRange(i, j);
                back = false;
            };
        let back = false;
        el.addEventListener("keydown", (e) => back = e.key === "Backspace");
        el.addEventListener("input", format);
        el.addEventListener("focus", format);
        el.addEventListener("blur", () => el.value === pattern && (el.value=""));
    }
});

function show_hide_table()
{
  $('#history_table').show();
}

$('#time_duration').change(function(){
  var time_duration = $("#time_duration").val();
  //var time_duration = $("#time_duration").inputmask("mm:mm",{ "clearIncomplete": true });
  var timeArray = time_duration.split(/[:]+/);
  
  var first = timeArray[0];
  var second = timeArray[1];
  var check1 = first.includes("m");
  var check2 = second.includes("m");
  if(check1===true || check2===true)
  {
    alert("Please Enter Proper Formate");
    $("#time_duration").val('');
  }
  
});
    localStorage.removeItem('saved_countdown');
    localStorage.removeItem('count_team_second');
    localStorage.removeItem('count_team_first');
    </script>

  </body>
</html>