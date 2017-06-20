<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class loginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
             $browser->visit('/login')
                    ->type('email', 'yosephyasin@ymail.com')
                    ->type('password', 'tes123')
                    ->press('Login')
                    ->assertPathIs('/tasks');
        });
    }

	public function testAddTask()
    {
        $this->browse(function (Browser $browser) {
             $browser->visit('/tasks')
                    ->press('new task')
					->type('task_title', 'title 1')
					->type('task_desc', 'desc 1')
					->select('task_priority', 'medium')
					->type('task_due_date', '2017-06-19')
					->press('add')
					->assertSee('Task added');
        });
    }
}
