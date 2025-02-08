<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(
    Tests\TestCase::class,
    RefreshDatabase::class
)->in(__DIR__);

uses()->beforeEach(function () {
    $this->user = new User([
        'id' => Ramsey\Uuid\Uuid::uuid4()->toString(),
        'name' => 'adson',
        'email' => '2fTqA@example.com',
        'password' => '123456',
    ]);
    Auth::setUser($this->user);
})->in(__DIR__);

uses()->afterEach(
    fn () =>\Mockery::close()
)->in(__DIR__);

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});
