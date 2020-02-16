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
        $doneStatus = $this->getDoneStatus();
        return Task::daily()->with('status')->whereIn('status_id', [$activeStatus->id, $doneStatus->id])->get();
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

        $task = (new Task)->with('status')->getFirstById($input['id']);

        $task->forceFill($input);
        $task->save();

        return ['success' => true, 'task' => $task];
    }

    public function delete($id)
    {
        $task = (new Task)->getFirstById($id);
        $archive = $this->getArchiveStatus()->first();
        $task->status()->associate($archive);
        $task->save();

        return ['success' => true];
    }

    public function getArchiveStatus()
    {
        return Status::where('name', 'Arquivado');
    }

    public function getActiveStatus()
    {
        return Status::where('name', 'Ativo')->first();
    }

    public function getDoneStatus()
    {
        return Status::where('name', 'Concluído')->first();
    }

    public function getStatusByName($name)
    {
        return Status::where('name', $name)->first();
    }

    public function getArchived()
    {
        return $this->getArchiveStatus()->with('tasks')->first()->tasks;
    }

    public function getSingle($id)
    {
        $task = (new Task)->getById($id)->with(['status', 'category'])->first();

        return response()->json($task, 200);
    }

    public function changeStatus(Request $request)
    {
        $input = $request->only('id', 'status_name');

        $status = $this->getStatusByName($input['status_name']);

        $task = Task::getFirstById($input['id']);

        $task->status()->associate($status);
        $task->save();
        return response()->json($task, 200);

    }
}
