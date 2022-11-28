<?php



use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\WebHookController;
use App\Http\Controllers\User\LeadController;
use App\Models\lead;
use Illuminate\Support\Facades\Route;


Route::get('/fake_leads', function () {
    $faker = Faker\Factory::create();
    $limit = 10000;
    for ($i = 0; $i < $limit; $i++) {
        $data = [
            'name' => $faker->unique()->name,
            'number' => $faker->unique()->phoneNumber,
            'status' => 'new',
            'user_id ' => 10,
            'type' => 'lead'
        ];

        lead::create($data);
    }
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('/');
Route::post('login', [LoginController::class, 'store'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::group(['prefix' => '{RolePrefix}', 'middleware' => ['auth:user', 'RolePrefix']], function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // //=============//
    // /* Leads */
    // //=============//

    Route::resource('leads', LeadController::class);
    Route::get('lead/Matured', [LeadController::class, 'matured'])->name('leads.mature');
    Route::get('lead/closed', [LeadController::class, 'closed'])->name('leads.closed');
    Route::get('lead/facebook', [LeadController::class, 'facebook'])->name('leads.facebook');

    Route::get('lead/change_priority/{priority}/{id}', [LeadController::class, 'changepriority'])->name('lead.change_priority');
    Route::post('lead/change_status', [LeadController::class, 'changestatus'])->name('lead.change_status');
    Route::get('lead/comments/{id}', [LeadController::class, 'comments'])->name('leads.comments');
    Route::post('lead-assign', [LeadController::class, 'lead_assign'])->name('leads.assign');
    Route::get('lead/employee', [LeadController::class, 'employees'])->name('lead.employee');
    Route::post('lead/employee/report', [LeadController::class, 'employees_report'])->name('lead.employee_report');
    //Facebook leads
    Route::get('/webhook', [WebHookController::class, 'index'])->name('webhook.index');
    Route::get('/webhook/show', [WebHookController::class, 'show'])->name('webhook.show');
    Route::get('/webhook/leads_form/{page_id}/{token}', [WebHookController::class, 'leads_form'])->name('webhook.leads_form');
    Route::get('/webhook/leads/{page_id}/{token}', [WebHookController::class, 'leads'])->name('webhook.leads');
    Route::get('/webhook/lead_assign_to_mangers/{page_id}/{token}', [WebHookController::class, 'lead_assign_to_mangers'])->name('webhook.lead_assign_to_mangers');
    Route::get('/webhook/lead_assign_to_sale_person/{page_id}/{token}', [WebHookController::class, 'lead_assign_to_sale_person'])->name('webhook.lead_assign_to_sale_person');

    // //=============//
    // /* Leads */
    // //=============//


    // Route::post('lead/deadlines', [LeadController::class, 'deadlines'])->name('leads.deadlines');

    //             //New Routes Added
    // Route::get('lead/building_info/{building_id}', 'LeadController@buildinginfo')->name('lead.building_info');
    // Route::post('lead/filter', 'LeadController@filter')->name('lead.filter');
    // Route::post('lead/search', 'LeadController@search')->name('lead.search');

    // Route::post('lead/searchbydate', 'LeadController@searchbydate')->name('lead.searchByDate');
    // Route::post('lead/change_status', 'LeadController@changestatus')->name('lead.change_status');

    // Route::get('lead/comments/{id}', 'LeadController@comments')->name('lead.comments');
    // Route::any('lead-assign', 'LeadController@lead_assign')->name('lead.assign');
    // Route::get('is-read/', 'LeadController@isread')->name('lead.isread');
    // Route::get('meeting-read/', 'LeadController@meetingread')->name('lead.meetingread');
    // Route::get('follow-up/', 'LeadController@followup')->name('lead.followup');

    // Route::get('insingleDay/', 'LeadController@insingleDay')->name('lead.insingleDay');
    // Route::get('intwoDay/', 'LeadController@intwoDay')->name('lead.intwoDay');
    // Route::get('overdueDay/', 'LeadController@overdueDay')->name('lead.overdueDay');
    // Route::get('aftertwoDay/', 'LeadController@aftertwoDay')->name('lead.aftertwoDay');
    //             //End New Routes
    // //=============//
    // /* Acccounts */
    // //=============//
});
