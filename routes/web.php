<?php

use App\Http\Controllers\User\ClientController;
use App\Http\Controllers\User\WebHookController;

use App\Http\Controllers\User\BuildingController;
use App\Http\Controllers\User\BuildingInventoryController;
use App\Http\Controllers\User\PremiumController;
use App\Http\Controllers\User\BlockController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\ProjectController;
use App\Http\Controllers\User\SizeController;
use App\Http\Controllers\User\UnitController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\FarmhouseInventoryController;
use App\Http\Controllers\User\LeadController;
use App\Http\Controllers\User\TypeController;
use App\Http\Controllers\User\FarmhouseController;
use App\Http\Controllers\User\PropertyController;
use App\Http\Controllers\User\PaymentPlanController;
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

Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'index'])->name('/');
Route::post('login', [LoginController::class, 'store'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::group(['prefix' => '{RolePrefix}', 'middleware' => ['auth:user', 'RolePrefix']], function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    //=========================//
    //  Project Management    //
    //=========================//
    Route::resource('block', BlockController::class);
    Route::resource('premium', PremiumController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('size', SizeController::class);
    Route::resource('type', TypeController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('project', ProjectController::class);
    Route::resource('property', PropertyController::class);
    Route::resource('farmhouse', FarmhouseController::class);
    Route::resource('farmhouse.inventory', FarmhouseInventoryController::class);
    Route::resource('payment_plan', PaymentPlanController::class);

    //=========================//
    //  Building Management    //
    //=========================//
    Route::resource('building', BuildingController::class);
    Route::resource('building.building_inventory', BuildingInventoryController::class);
    /*Route::post('building/banner/remove', 'BuildingController@remove_image_banner');
    Route::get('building-detail-form', 'BuildingController@detail_form')->name('building.detail_form');
    Route::get('building_detail/{id}', 'FloorController@index')->name('building_detail.index');
    Route::get('building/{building_id}/floor/{floor_id}/index', 'FloorDetailController@index')->name('building.inventory.index');
    Route::get('building/{building_id}/floor/{floor_id}/create', 'FloorDetailController@create')->name('building.inventory.create');
    Route::post('building/{building_id}/floor/{floor_id}/store', 'FloorDetailController@store')->name('building.inventory.store');
    Route::get('building/{building_id}/floor/{floor_id}/edit/{id}', 'FloorDetailController@edit')->name('building.inventory.edit');
    Route::post('building/{building_id}/floor/{floor_id}/update/{id}', 'FloorDetailController@update')->name('building.inventory.update');
    Route::post('building/{building_id}/floor/{floor_id}/delete/{id}', 'FloorDetailController@destroy')->name('building.inventory.destroy');
    Route::post('building/{building_id}/floor/{floor_id}/index/filter', 'FloorDetailController@filter')->name('building.inventory.filter');*/

    //=========================//
    //  Leads Management    //
    //=========================//

    Route::resource('leads', LeadController::class);
    Route::get('lead/Matured', [LeadController::class, 'matured'])->name('leads.mature');
    Route::get('lead/closed', [LeadController::class, 'closed'])->name('leads.closed');
    Route::get('lead/facebook', [LeadController::class, 'facebook'])->name('leads.facebook');
    Route::get('lead/getInventory', [LeadController::class, 'facebook'])->name('lead.getInventory');
    Route::get('lead/refer', [LeadController::class, 'refer'])->name('lead.refer');
    Route::post('lead/refer_lead', [LeadController::class, 'refer_lead'])->name('leads.refer_lead');
    Route::get('lead/accept/{id}', [LeadController::class, 'refer_lead_accept'])->name('lead.accept');
    Route::get('lead/reject/{id}', [LeadController::class, 'refer_lead_reject'])->name('lead.reject');

    Route::get('lead/change_priority/{priority}/{id}', [LeadController::class, 'changepriority'])->name('lead.change_priority');
    Route::post('lead/change_status', [LeadController::class, 'changestatus'])->name('lead.change_status');
    Route::get('lead/comments/{id}', [LeadController::class, 'comments'])->name('leads.comments');
    Route::post('lead-assign', [LeadController::class, 'lead_assign'])->name('leads.assign');
    Route::get('lead/employee', [LeadController::class, 'employees'])->name('lead.employee');
    Route::post('lead/employee/report', [LeadController::class, 'employees_report'])->name('lead.employee_report');

    Route::get('state/{country_id}',  [UserController::class, 'state'])->name('state');
    Route::get('city/{state_id}',  [UserController::class, 'city'])->name('city');
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
    // //=============//
    // /* Clients */
    // //=============//

    Route::resource('clients', ClientController::class);
    Route::get('client/change_priority/{priority}/{id}', [ClientController::class, 'changepriority'])->name('client.change_priority');
    Route::post('client/change_status', [ClientController::class, 'changestatus'])->name('client.change_status');
    Route::get('client/comments/{id}', [ClientController::class, 'comments'])->name('client.comments');
    Route::get('client/active/{id}', [ClientController::class, 'active'])->name('clients.active');
    // //=============//
    // /* Clients */
    // //=============//

    //             //End New Routes
    // //=============//
    // /* Acccounts */
    // //=============//
});
