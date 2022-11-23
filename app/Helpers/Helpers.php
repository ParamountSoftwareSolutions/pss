<?php

use App\Models\lead;
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
 * get_leads_from_user_auth
 *
 * @return response()
 */
if (!function_exists('get_leads_from_user_auth')) {
    function get_leads_from_user_auth()
    {
        return lead::select('*');
    }
}
