<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;

class TaskController extends Controller
{

    public function index()
    {
        $data = Task::get();
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
            Task::create($request->validated());
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
            $task->update($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Task Updated Successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function destroy(Task $task)
    {
        if ($task->delete() == true) {
            return response()->json([
                'status' => true,
                'message' => 'Task Deleted Successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ], 200);
        }
    }
}
