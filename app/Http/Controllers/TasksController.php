<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{

    public function get()
    {
        return Task::daily()->get();
    }
}
