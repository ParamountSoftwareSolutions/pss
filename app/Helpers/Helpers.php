<?php

use App\Models\lead;
use App\Models\ProjectAssignUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('RolePrefix')) {
    function RolePrefix()
    {
        return Auth::user()->roles->pluck('name')[0];
    }
}
/**
 * get_leads_from_user
 *
 * @return response()
 */
if (!function_exists('get_leads_from_user')) {
    function get_leads_from_user($users)
    {
        if (Auth::user()->hasRole('sale_person')) {
            return Lead::with('sale_person', 'building')->where('user_id', Auth::id());
        }
        if (Auth::user()->hasRole('sale_manager')) {
            return Lead::with('sale_person', 'building')->whereIn('user_id', $users);
        }
        if (Auth::user()->hasRole('property_manager')) {
            return  Lead::with('sale_person', 'building')->whereIn('user_id', $users);
        }
        if (Auth::user()->hasRole('property_admin')) {
            return Lead::with('sale_person', 'building');
        }
    }
}
/**
 * get_user_by_projects
 *
 * @return response()
 */
if (!function_exists('get_user_by_projects')) {
    function get_user_by_projects()
    {
        $project = ProjectAssignUser::where('user_id', auth()->user()->id)->get();
        $user = ProjectAssignUser::groupBy('user_id')->whereIn('project_id', $project->pluck('project_id')->toArray())->where('user_id', '!=', auth()->user()->id)->get()->pluck('user_id');
        $a2=array(Auth::user()->id);
        return array_merge($user->toArray(),$a2);
    }
}
/**
 * get_all_projects
 *
 * @return response()
 */
if (!function_exists('get_all_projects')) {
    function get_all_projects()
    {
        return ProjectAssignUser::with('projects')->where('user_id', auth()->user()->id)->get();
    }
}