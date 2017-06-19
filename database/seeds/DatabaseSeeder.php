<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('users')->insert([
              [
                'name' => 'Fernando',
                'email' => 'fernandoyoseph6@gmail.com',
                'password' => bcrypt('tes123'),
                'role' => 'admin',
                'notif' => '0',
              ],
              [
                'name' => 'Yoseph',
                'email' => 'yosephyasin@ymail.com',
                'password' => bcrypt('tes123'),
                'role' => 'user',
                'notif' => '0',
              ]
          ]);

          DB::table('tasks')->insert([
            [
              'id' => 2,
              'task_prior' => 'low',
              'task_title' => 'title 1',
              'task_desc' => 'desc 1',
              'task_due_date' => date("Y-m-d"),
              'task_status' => 'ongoing',
            ],
            [
              'id' => 2,
              'task_prior' => 'medium',
              'task_title' => 'title 2',
              'task_desc' => 'desc 2',
              'task_due_date' => date("Y-m-d"),
              'task_status' => 'done',
            ],
            [
              'id' => 2,
              'task_prior' => 'high',
              'task_title' => 'title 3',
              'task_desc' => 'desc 3',
              'task_due_date' => date("Y-m-d"),
              'task_status' => 'ongoing',
            ],
            [
              'id' => 2,
              'task_prior' => 'low',
              'task_title' => 'title 4',
              'task_desc' => 'desc 4',
              'task_due_date' => date("Y-m-d"),
              'task_status' => 'done',
            ],
        ]);
    }
}
