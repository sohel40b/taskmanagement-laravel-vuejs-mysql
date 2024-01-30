<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Jobs\SendTaskNotification;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $data = Task::where('user_id',Auth::id())->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ], 200);
        }
    }

    public function create()
    {
        //
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

    public function show(Task $task)
    {
        //
    }

    public function edit(Task $task)
    {
        //
    }

    public function update(TaskUpdateRequest $request, Task $task)
    {
        try {
            $task = Task::where('user_id', Auth::id())->first();
            if ($task) {
                $task->update($request->validated());
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
        $task = Task::where('user_id', Auth::id())->first();
        if ($task) {
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
