<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAssignUser extends Model
{
    use HasFactory;

    // public static function get_project($user)
    // {
    //     $project = ProjectAssignUser::where('user_id', $user)->get();
    //     return ProjectAssignUser::whereIn('project_id', $project->pluck('project_id')->toArray())->where('user_id', '!=', $user)->get()->pluck('user_id')->groupBy('project_id');
    // }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
