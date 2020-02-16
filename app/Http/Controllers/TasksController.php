<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Status;

class TasksController extends Controller
{

    public function get()
    {
        $activeStatus = $this->getActiveStatus();
        return Task::daily()->where('status_id', $activeStatus->id)->get();
    }

    public function create(Request $request)
    {
        $input = $request->validate([
            'name'        => 'required|max:255',
            'description' => 'sometimes'
        ]);
        $task = \DB::transaction(function () use ($input){
            $task = (new Task);
            $task->fill($input);
            $task->user()->associate(auth()->user());
            $task->status()->associate($this->getActiveStatus());
            $task->save();
            return $task;
        });

        return ['success' => true, 'task' => $task];
    }

    public function edit(Request $request)
    {
        $input = $request->validate([
            'id'          => 'required',
            'name'        => 'required|max:255|min:1',
            'description' => 'sometimes'
        ]);

        $task = (new Task)->where('id', $input['id'])->first();

        $task->forceFill($input);
        $task->save();

        return ['success' => true, 'task' => $task];
    }

    public function delete($id)
    {
        $task = (new Task)->where('id', $id)->first();
        $archive = $this->getArchiveStatus();
        $task->status()->associate($archive);
        $task->save();

        return ['success' => true];
    }

    public function getArchiveStatus()
    {
        return Status::where('name', 'Arquivado')->first();
    }

    public function getActiveStatus()
    {
        return Status::where('name', 'Ativo')->first();
    }

    public function getArchived()
    {
        return $this->getArchiveStatus()->with('tasks')->first()->tasks;
    }

    public function getSingle($id)
    {
        $task = (new Task)->where('id', $id)->with(['status', 'category'])->first();

        return response()->json($task, 200);
    }
}
