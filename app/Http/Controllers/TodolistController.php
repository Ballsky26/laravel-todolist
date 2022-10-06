<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodolistService $todolistService;
    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }
    public function todoList(Request $request)
    {
        $todolist = $this->todolistService->getTodolist();
        return response()->view("todolist.todolist", [
            "title" => "Todolist",
            "todolist" =>  $todolist
        ]);
    }
    public function addTodo(Request $request)
    {
        $todo = $request->input("todo");
        $todolist = $this->todolistService->getTodolist();
        if (empty($todo)) {
            return response()->view("todolist.todolist", [
                "title" => "Todolist",
                "todolist" =>  $todolist,
                "error" => "Todo harus di isi"
            ]);
        }
        $this->todolistService->saveTodo(uniqid(), $todo);
        return redirect()->action([TodolistController::class, 'todolist']);
    }
    public function removeTodo(Request $request, string $todoId)
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todolist']);
    }
}
