<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskStoreRequest;
use App\Jobs\SendTaskNotification;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::where('user_id',Auth::id())->get();
        if ($tasks->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'tasks' => $tasks
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ], 200);
        }
    }

    public function getTasksByStatus($status = null)
    {
        $tasks = ($status !== null)
        ? Task::where([['status', $status],['user_id',Auth::id()]])->get()
        : Task::all();
        
        if ($tasks->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'tasks' => $tasks
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ]);
        }
    }

    public function store(TaskStoreRequest $request)
    {
        try {
            Task::create($request->data());
            SendTaskNotification::dispatch(Auth::user()->email);
            return response()->json([
                'status' => true,
                'message' => 'Task Created Successfully',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Task $task)
    {
        try {
            $task = Task::where('user_id', Auth::id())->where('id',$task->id)->first();
            if ($task != null) {
                $task->update(['status' => 1]);
                SendTaskNotification::dispatch(Auth::user()->email);
                return response()->json([
                    'status' => true,
                    'message' => 'Task Updated Successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found',
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function destroy(Task $task)
    {
        $task = Task::where('user_id', Auth::id())->where('id',$task->id)->first();
        if ($task != null) {
            $task->delete();
            return response()->json([
                'status' => true,
                'message' => 'Task Deleted Successfully',
            ], 204);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ], 200);
        }
    }
}
