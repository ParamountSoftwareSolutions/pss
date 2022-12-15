<?php

use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\SocietyBlockController;
use App\Http\Controllers\User\SocietyController;
use App\Http\Controllers\User\SocietyInventoryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ClientController;
use App\Http\Controllers\User\WebHookController;
use App\Http\Controllers\User\BuildingController;
use App\Http\Controllers\User\BuildingInventoryController;
use App\Http\Controllers\User\FloorController;
use App\Http\Controllers\User\PremiumController;
use App\Http\Controllers\User\BlockController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\ProjectController;
use App\Http\Controllers\User\SizeController;
use App\Http\Controllers\User\UnitController;
use App\Http\Controllers\User\FarmhouseInventoryController;
use App\Http\Controllers\User\LeadController;
use App\Http\Controllers\User\TypeController;
use App\Http\Controllers\User\FarmhouseController;
use App\Http\Controllers\User\PropertyController;
use App\Http\Controllers\User\PaymentPlanController;
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\BuildingExtraDetailController;
use App\Http\Controllers\User\FeatureController;
use App\Http\Controllers\User\TargetController;
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
    Route::resource('society', SocietyController::class);
    Route::resource('society.inventory', SocietyInventoryController::class);

    //=========================//
    //  Building Features      //
    //=========================//
    Route::group(['prefix' => 'building/feature', 'as' => 'feature.'], function () {
        Route::get('/{key}', [FeatureController::class,'index'])->name('index');
        Route::get('{key}/create', [FeatureController::class,'create'])->name('create');
        Route::post('{key}/store', [FeatureController::class,'store'])->name('store');
        Route::get('{key}/edit/{id}', [FeatureController::class,'edit'])->name('edit');
        Route::put('{key}/update/{id}', [FeatureController::class,'update'])->name('update');
        Route::delete('{key}/destroy/{id}', [FeatureController::class,'destroy'])->name('destroy');
    });

    //=========================//
    //  Building Management    //
    //=========================//
    Route::resource('building', BuildingController::class);
    Route::resource('floor', FloorController::class);
    Route::resource('building.floor.building_inventory', BuildingInventoryController::class);
    Route::get('building_extra_detail', [BuildingExtraDetailController::class,'building_extra_detail'])->name('building_extra_detail');
    Route::resource('building.extra_detail', BuildingExtraDetailController::class);
    Route::post('building/inventory/image/remove', [BuildingInventoryController::class, 'image_remove']);

    //=========================//
    //  Society Management    //
    //=========================//
    Route::resource('society', SocietyController::class);
    Route::resource('block', SocietyBlockController::class);
    Route::resource('society.block.society_inventory', SocietyInventoryController::class);



    Route::get('state/{id}', [HomeController::class, 'state']);
    Route::get('city/{id}', [HomeController::class, 'city']);
    Route::get('get-premium/{type}', [PremiumController::class, 'get_premium']);
    //Route::post('building/inventory/image/remove', [BuildingInventoryController::class, 'image_remove']);

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
    Route::get('lead/bulk/import/view', [LeadController::class, 'bulk_import_view'])->name('lead.bulk_import.view');
    Route::post('lead/bulk/import', [LeadController::class, 'bulk_import'])->name('lead.bulk_import');
    Route::get('lead/bulk/export', [LeadController::class, 'bulk_export'])->name('lead.bulk_export');

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
    Route::post('client/{client_id}/installment/{id}', [ClientController::class, 'installment'])->name('clients.installment');
    // //=============//
    // /* Clients */
    // //=============//

    //             //End New Routes    Get Payment Plan

    Route::get('get-payment-plan/{premium_id}/{project_type_id}', [PaymentPlanController::class, 'get_payment_plan']);




    //====================//
    // Task Targets Route //
    //====================//

    Route::group(['prefix' => 'targets', 'as' => 'target.'], function () {
        Route::get('/', [TargetController::class,'my_targets'])->name('index');
        Route::get('staff-targets', [TargetController::class,'staff_targets'])->name('staff_targets');
        Route::get('assign-target', [TargetController::class,'assign_target'])->name('assign_target');
        Route::post('store', [TargetController::class,'store'])->name('store');
        Route::get('get-role-list/{role}', [TargetController::class,'get_role_list'])->name('get_role_list');
        Route::get('edit-task/{id}', [TargetController::class,'edit_task'])->name('edit_task');
        Route::post('update-task/{id}', [TargetController::class,'update_task'])->name('update_task');
        Route::get('task-reports', [TargetController::class,'task_reports'])->name('task_reports');
        Route::get('task/get-report/{id}', [TargetController::class,'get_report'])->name('get_report');
    });




    // //=============//
    // /* Email Routes */
    // //=============//

    Route::group(['prefix' => 'email','as'=>'email.'], function () {
        Route::get('compose', [EmailController::class,'email_compose'])->name('compose');
        Route::post('compose/send', [EmailController::class,'email_compose_send'])->name('compose.send');
        Route::post('compose/save', [EmailController::class,'email_compose_save'])->name('compose.save');
        Route::get('sent', [EmailController::class,'send_email'])->name('send_email');
        Route::get('detail/{id}', [EmailController::class,'email_detail'])->name('detail');
        Route::get('draft', [EmailController::class,'draft_email'])->name('draft_email');
        Route::get('view/{id}', [EmailController::class,'email_view'])->name('view');
        Route::post('forward/{id}', [EmailController::class,'email_forward'])->name('forward');
        Route::delete('destroy/{id}', [EmailController::class,'email_destroy'])->name('email_destroy');
        Route::post('remove/image', [EmailController::class,'remove_image_email'])->name('remove_image_email');
        Route::post('resend/{id}', [EmailController::class,'email_resend'])->name('resend');
    });
});
