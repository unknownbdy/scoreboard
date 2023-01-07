<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Match_score_detail;

class ScoreController extends Controller
{
    public function index()
    {
        $scoreDetail = Match_score_detail::all();
        $array = $scoreDetail->toArray(); 
        if(!empty($array))
        {
            $data = compact('scoreDetail');
            return view('matchform')->with($data);
            //return view('matchform');    
        }else
        {
            return view('matchform');
        }
        
    }

    public function GetScoreDetail(Request $request)
    {
        $request->validate([
            'team_first' =>'required',
            'team_second' =>'required',
            'time_duration' =>'required',
           ]);

            $match_id = $request->input('match_id');
            $team_first = $request->input('team_first');
            $team_second = $request->input('team_second');
            $time_duration = $request->input('time_duration');
            
            $data=array(
                'match_id'=>$match_id
                ,'team_first'=>$team_first
                ,"team_second"=>$team_second
                ,"time_duration"=>$time_duration
            );
 
            $lastInsertId = DB::table('match_score_details')->insertGetId($data);
            //echo $lastInsertId; die;
            if($lastInsertId>0)
            {
                return redirect('/startmatch'.'/'.$lastInsertId);
            }else
            {
                return redirect('')->withErrors('Error');
            }
           
    }
    public function StartMatch($id)
    { 
        $scoreDetail = Match_score_detail::find($id);
       // echo "<pre>"; print_r($scoreDetail->toArray()); die;
        $data = compact('scoreDetail');
        return view('startmatch')->with($data);
        //return view('startmatch');
    }

    public function GameOver(Request $request)
    {
        
        $id = $request->input('id');
        $Match_score_detail = Match_score_detail::find($id);
       // print_r($Match_score_detail);
        if(is_null($Match_score_detail))
        {
           return redirect('matchform');
        }

        $time = $request['count_timer'];
        $team_first_score = $request['team_first_score'];
        $team_second_score = $request['team_second_score'];
        if($team_first_score>$team_second_score)
        {
            $team_first_status = 'WON';
            $team_second_status = 'LOST';
        }
        elseif($team_first_score<$team_second_score)
        {
            $team_first_status = 'LOST';
            $team_second_status = 'WON';
        }
        else{
            $team_first_status = 'DRAW';
            $team_second_status = 'DRAW';
        }
        $Match_score_detail->time_duration = $time;
        $Match_score_detail->team_first_score = $team_first_score;
        $Match_score_detail->team_second_score = $team_second_score;
        $Match_score_detail->team_first_win  = $team_first_status;
        $Match_score_detail->team_second_win = $team_second_status;
        $Match_score_detail->save();

        $data = array
        (
            'team_first' => $Match_score_detail->team_first,
            'team_first_score' => $Match_score_detail->team_first_score,
            'team_first_win' => $Match_score_detail->team_first_win,
            'team_second' => $Match_score_detail->team_second,
            'team_second_score' => $Match_score_detail->team_second_score,
            'team_second_win' => $Match_score_detail->team_second_win,
        );

        return json_encode($data);
      
    }
}
