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

        ]);
    }
}
