<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }
    public function testLoginPageForMember()
    {
        $this->withSession([
            "user" => "iqbal"
        ])->get('/login')
            ->assertRedirect("/");
    }
    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "iqbal",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "iqbal");
    }
    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "iqbal"
        ])->post('/login', [
            "user" => "iqbal",
            "password" => "rahasia"
        ])->assertRedirect("/");
    }
    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User atau Password harus di isi");
    }
    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User atau Password Salah");
    }
    public function testLogout()
    {
        $this->withSession([
            "user" => "iqbal"
        ])->post("/logout")
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }
    public function testLogoutGuest()
    {
        $this->post("/logout")
            ->assertRedirect("/");
    }
}
