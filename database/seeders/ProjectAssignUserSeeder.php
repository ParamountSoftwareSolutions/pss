<?php

namespace Database\Seeders;

use App\Models\ProjectAssignUser;
use Illuminate\Database\Seeder;

class ProjectAssignUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectAssignUser::insert([
            //admin
            [
                'project_id' => 1,
                'user_id' => 9,
            ],
            [
                'project_id' => 2,
                'user_id' => 9,
            ],
            [
                'project_id' => 3,
                'user_id' => 9,
            ],
            [
                'project_id' => 4,
                'user_id' => 10,
            ],
            [
                'project_id' => 5,
                'user_id' => 10,
            ],
            [
                'project_id' => 6,
                'user_id' => 10,
            ],
            [
                'project_id' => 7,
                'user_id' => 9,
            ],
            [
                'project_id' => 8,
                'user_id' => 10,
            ],
            [
                'project_id' => 9,
                'user_id' => 10,
            ],
            //manager
            [
                'project_id' => 1,
                'user_id' => 11
            ],
            [
                'project_id' => 2,
                'user_id' => 11,
            ],
            [
                'project_id' => 3,
                'user_id' => 11,
            ],
            //Employee 7 id
            [
                'project_id' => 4,
                'user_id' => 11,
            ],

        ]);
    }
}
