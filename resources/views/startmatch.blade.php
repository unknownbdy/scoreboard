<!doctype html>
<html lang="en">
  <head>
    <title>ScoreBoard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
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
          <a class="navbar-brand">ScoreBoard</a>
           
        </div>
      </nav>
    
      {{-- <pre>
        {{print_r($scoreDetail)}}
      </pre> --}}
    
      @php
      if(empty($scoreDetail))
      {
          $id = 0;
          $match_id = 0;
          $count_timer = 0;
          $team_first_name = 0;
          $team_second_name = 0;
          
      }else
      {
        $id = $scoreDetail->id;
        $match_id = $scoreDetail->match_id;
        $count_timer = $scoreDetail->time_duration;
        $team_first_name = $scoreDetail->team_first;
        $team_second_name = $scoreDetail->team_second;
      } 
    @endphp

        <div class='container'>
            {{-- <form action="{{url('/')}}/" class="row g-3" id="form" method="post"> --}}
              <form class="row g-3" id="form">
                <div class="col-12">
                     
                        <label for="inputEmail4" class="form-label">Count-timer</label>
                        <input type="hidden" id="id" name="id" value="{{$id}}" />
                        <input type="hidden" id="match_id" name="match_id" value="{{$match_id}}" />
                        <input type="text" readonly id="timer" class="form-control" name="count_timer" value="{{$count_timer}}" style="width: 120px;"/>
                    </div>
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">{{$team_first_name}} - Score</label>
    <div class="input-group flex-nowrap">
        
        <input type="text" class="form-control" readonly name="team_first_score" id="team_first_score" value="-1" aria-label="Username" aria-describedby="addon-wrapping">
        <span class="input-group-text"  id="addon-wrapping" style="line-height: 1;">
            <button type="button" onclick="return count_value_first_team('first');">+</button>
        </span>
      </div>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">{{$team_second_name}} - Score</label>
    <div class="input-group flex-nowrap">
       
        <input type="text" class="form-control" readonly name="team_second_score" id="team_second_score" value="-1" aria-label="Username" aria-describedby="addon-wrapping">
        <span class="input-group-text" id="addon-wrapping" style="line-height: 1;">
            <button type="button" onclick="return count_value_scond_team('second');">+</button></span>
      </div>
  </div>
 
  
  &nbsp;<br>
  <div class="col-12">
    <button type="button" class="btn btn-danger"  id="btn-gameover">Game Over</button>
  </div>
</form>
        
          </div>  
          <script>
          var presentTime =  document.getElementById('timer').value; // This is the time allowed
          var time = 0;
          var timeArray = presentTime.split(/[:]+/);
          var m = timeArray[0];
          var s = timeArray[1];
        if (m>0 && s>0) {
            time = (eval(m)*60)+(eval(s));  
        }else if(m==0 && s>0){
             time = eval(s);
        }else if(m>0 && s==0)
        {
          time = (eval(m)*60);
        }
        time = eval(time)-2;
            // console.log(time);
          var saved_countdown = localStorage.getItem('saved_countdown');
          
          if(saved_countdown == null) {
              // Set the time we're counting down to using the time allowed
              var new_countdown = new Date().getTime() + (time + 2) * 1000;
          
              time = new_countdown;
              localStorage.setItem('saved_countdown', new_countdown);
          } else {
              time = saved_countdown;
          }
          
          // Update the count down every 1 second
          var x = setInterval(() => {
           
              var now = new Date().getTime();
           
              var distance = time - now;
          
              // Time counter
              var counter = Math.floor((distance % (1000 * time)) / 1000);
            //console.log(counter);
          
          const m = Math.floor(counter % 3600 / 60).toString().padStart(2,'0'),
                s = Math.floor(counter % 60).toString().padStart(2,'0');

             // console.log(m + ':' + s);
              document.getElementById("timer").value = m + ":" + s;
                  
              // If the count down is over, write some text 
              if (counter <= 0) {
                  clearInterval(x);
                  localStorage.removeItem('saved_countdown');
                  localStorage.removeItem('count_team_second');
                  localStorage.removeItem('count_team_first');
                  document.getElementById("btn-gameover").click();
              }
          }, 1000);
          </script>
         

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script> 
    <script>
 function count_value_scond_team(check,reload)
{
    if(check=='second')
    {
      if (localStorage.getItem("count_team_second") === null) 
      {
        var team_second_score = document.getElementById('team_second_score').value;
        team_second_score = eval(team_second_score)+1;
        document.getElementById('team_second_score').value=team_second_score;
        localStorage.setItem('count_team_second', team_second_score); 
      }else
      {  
        var x = localStorage.getItem("count_team_second");
        if(reload=='reload')
        {
           team_second_score = eval(x);
        }else
        {
          team_second_score = eval(x)+1;
        }
        localStorage.setItem('count_team_second', team_second_score); 
        document.getElementById('team_second_score').value=x;
      }
    } 
}
count_value_scond_team('second','reload');


function count_value_first_team(check,reload)
{
    if(check=='first')
    {
      if (localStorage.getItem("count_team_first") === null) 
      {
        var team_first_score = document.getElementById('team_first_score').value;
        team_first_score = eval(team_first_score)+1;
        document.getElementById('team_first_score').value=team_first_score;
        localStorage.setItem('count_team_first', team_first_score); 
      }else
      {  
        var x = localStorage.getItem("count_team_first");
        if(reload=='reload')
        {
           count_team_first = eval(x);
        }else
        {
          count_team_first = eval(x)+1;
        }
        //console.log(count_team_first); //return false;
        localStorage.setItem('count_team_first', count_team_first); 
        document.getElementById('team_first_score').value=x;
      }
    } 
}
count_value_first_team('first','reload');



jQuery(document).ready(function($){
    // CREATE
    $("#btn-gameover").click(function (e) 
    {
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
             }
         });
         e.preventDefault();
        var formData = 
        {
          id: jQuery('#id').val(),    
          match_id: jQuery('#match_id').val(),    
          count_timer: jQuery('#timer').val(),
          team_first_score: jQuery('#team_first_score').val(),
          team_second_score: jQuery('#team_second_score').val(),
        };
         //console.log(formData);
         var state = jQuery('#btn-gameover').val();
         var type = "POST"; 
         var ajaxurl = '/gameover';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) 
            {
                   
                if(data.team_first_score>data.team_second_score)
                {
                  swal('Team - '+data.team_first + "WON", "Team Score Is - "+data.team_first_score);
                }
                else if(data.team_first_score<data.team_second_score)
                {
                  swal('Team - '+data.team_second + "WON", "Team Score Is - "+data.team_second_score);
                }
                else
                {
                  swal("Match Draw");
                }

                localStorage.removeItem('saved_countdown');
                  localStorage.removeItem('count_team_second');
                  localStorage.removeItem('count_team_first');
                  var x = setInterval(() => {
                    window.location = "/";
                    }, 3000);
               
            },
            error: function (data) {
              //  console.log(data);
            }
        });
    });
 
});


    </script>
   
  </body>
</html>