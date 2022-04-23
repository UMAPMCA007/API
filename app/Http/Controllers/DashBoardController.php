<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class DashBoardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function activities()
    {
        if(Session::get('user')->IsAdmin=='1'){
            $activities = Activity::paginate(5);
        }
       
        else{
            $activities = Activity::where('user_id',Session::get('user')->id)->paginate(3);
        }
        
        return view('activity', compact('activities'));
    }
    public function activities_edit($id)
    {
        $activity=Activity::find($id);
        return response()->json($activity);
    }
    public function activities_save(Request $request,$id)
    {
        $activity=Activity::find($id);
        $activity->activity_type=$request->activity_type;
        $activity->activity_name=$request->activity_name;
        $activity->save();
        return response()->json($activity);
    }
    public function fetch_activity($activity)
    {
        $httpClient = new \GuzzleHttp\Client();
        $request = $httpClient->get("http://www.boredapi.com/api/activity?type=${activity}");

        $response = json_decode($request->getBody()->getContents());
        return response()->json($response);
    }

    public function activity_add(Request $request,$id)
    {
        $activity=Activity::all();
        if($activity){
            $last_add=Activity::all()->pluck('created_at')->last();
            // current date
            $current_date=date('Y-m-d');
            // last add date
            $last_add_date=date('Y-m-d',strtotime($last_add));
            // if current date is not equal to last add date
            $activity=Activity::where('user_id',$id)->get();
            $count=count($activity);
            if($last_add_date!=$current_date)
            {
                    $count+=2;
                    
                if(count($activity)!=$count)
                {
                    $activity=new Activity();
                    $activity->user_id=$id;
                    $activity->activity_type=$request->activity_type;
                    $activity->activity_name=$request->activity_name;
                    $activity->save();
                    return response()->json(['success'=>'activity added successfully']);
                    
                }
                else
                {
                    return response()->json(['error'=>'You have already added 2 activity in one day']);
                }
            }else {
                if(count($activity)<12)
                {
                        $activity=new Activity();
                        $activity->user_id=$id;
                        $activity->activity_type=$request->activity_type;
                        $activity->activity_name=$request->activity_name;
                        $activity->save();
                        return response()->json(['success'=>'activity added successfully']);
                    
                }else{
                    return response()->json(['error'=>'You have already added 2 activity in one day']);
                }
            }
            
        
        }else{
            $activity=new Activity();
            $activity->user_id=$id;
            $activity->activity_type=$request->activity_type;
            $activity->activity_name=$request->activity_name;
            $activity->save();
            return response()->json(['success'=>'activity added successfully']);
        }
        
    }

    public function activity_load($userId)
    {
        $activities=Activity::where('user_id',$userId)->get();
        return response()->json($activities);
    }

    public function activity_delete($id)
    {
        $activity=Activity::find($id);
        $activity->delete();
        return response()->json($activity);
    }
    
}
