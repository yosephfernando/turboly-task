<?php

namespace Tests\Feature;

use Tests\TestCase;
Use App\User;
Use App\tasks;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Session;

class taskResourceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLogin()
    {
      //test login as admin
      $user = User::first();
      $this->be($user);
      $response = $this->call('GET', '/users-manage');
      $this->assertEquals(200, $response->status());
    }

    public function testAddTasks()
    {
      //test add tasks
      Session::start();
      $user = User::where('role', 'user')->first();
      $this->be($user);
      $data = [
          '_token' => csrf_token(),
          'task_title' => 'title test via php unit',
          'task_desc' => 'task desc test',
          'task_priority' => 'low',
          'task_due_date' => date('Y-m-d'),
      ];

      $response = $this->call('POST', '/tasks', $data);
      $this->assertDatabaseHas('tasks', [
          'task_title' => 'title test via php unit'
      ]);
    }

    public function testUpdateTasks()
    {
      //test update tasks
      Session::start();
      $user = User::where('role', 'user')->first();
      $this->be($user);
      $task_id = tasks::max('task_id');
      $data = [
          '_token' => csrf_token(),
          '_method' => 'PUT',
          'done' => 'done',
      ];

      $response = $this->call('POST', '/tasks/'.$task_id, $data);
      $this->assertDatabaseHas('tasks', [
          'task_title' => 'title test via php unit',
          'task_status' => 'done'
      ]);
    }

    public function testDeleteTasks()
    {
      //test delete tasks
      Session::start();
      $user = User::where('role', 'user')->first();
      $this->be($user);
      $task_id = tasks::max('task_id');

      $data = ['_token' => csrf_token(), '_method' => 'DELETE'];

      $response = $this->call('POST', '/tasks/'.$task_id, $data);
      $this->assertDatabaseMissing('tasks', [
          'task_title' => 'title test via php unit'
      ]);
    }
}
