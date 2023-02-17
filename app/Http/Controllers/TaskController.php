<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MTask;

class TaskController extends Controller
{
    public function index()
    {
        $task           = MTask::with('user')->get();
       
        return response()->json($task);
    }

    public function store(Request $request)
    {
        $newTask            = new MTask;
        $newTask->name      = $request->item['name'];
        $newTask->user_id   = $request->item['assigned_to'];
        $newTask->save();

        $task               = MTask::where('_id', $newTask->id)->with('user')->first();
        $emailto            = $task->user['email'];
        \Mail::to($emailto)->send(new \App\Mail\Reminder($task));

        return response()->json($task);
    }
    public function update(Request $request, $id)
    {
        $lastTask = MTask::find($id);
        if($lastTask){
           $lastTask->name = $request->item['name'];
           $lastTask->completed = $request->item['completed'] ? true : false;
           $lastTask->updated_at = \Carbon\Carbon::now() ;
           $lastTask->save();
           return response()->json($lastTask);

        } 
        return response()->json('no data found !');
    }
    public function destroy($id)
    {
        $existingTask = MTask::find($id);
        if($existingTask){
           $existingTask->delete();
           return response()->json('Task deleted !');
        }
    return response()->josn('Task not found !');
    }
}
