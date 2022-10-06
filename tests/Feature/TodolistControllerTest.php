<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "iqbal",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Iqbal"
                ],
                [
                    "id" => "2",
                    "todo" => "Syaiful"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Iqbal")
            ->assertSeeText("2")
            ->assertSeeText("Syaiful");
    }
    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "iqbal"
        ])->post("/todolist", [])
            ->assertSeeText("Todo harus di isi");
    }
    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "iqbal"
        ])->post("/todolist", [
            "todo" => "Syaiful"
        ])->assertRedirect("/todolist");
    }
    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "iqbal",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Iqbal"
                ],
                [
                    "id" => "2",
                    "todo" => "Syaiful"
                ]
            ]
        ])->post('/todolist/1/delete')
            ->assertRedirect('/todolist');
    }
}
