<?php


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
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\SocietyController;
use App\Http\Controllers\User\SocietyInventoryController;
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
Route::get('login', [LoginController::class, 'index'])->name('/');
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
    Route::get('lead/change_priority/{priority}/{id}', [LeadController::class, 'changepriority'])->name('lead.change_priority');
    Route::post('lead/change_status', [LeadController::class, 'changestatus'])->name('lead.change_status');

    //             //New Routes Added
    Route::get('lead/building_info/{building_id}', [LeadController::class, 'buildinginfo'])->name('lead.building_info');
    Route::post('lead/filter', [LeadController::class, 'filter'])->name('lead.filter');
    Route::post('lead/search', [LeadController::class, 'search'])->name('lead.search');
    Route::post('lead/searchbydate', [LeadController::class, 'searchbydate'])->name('lead.searchByDate');
    // Route::post('lead/change_status', [LeadController::class, 'changestatus'])->name('lead.change_status');

    Route::get('lead/comments/{id}', [LeadController::class, 'comments'])->name('lead.comments');
    Route::any('lead-assign', [LeadController::class, 'lead_assign'])->name('lead.assign');
    Route::get('is-read/', [LeadController::class, 'isread'])->name('lead.isread');
    Route::get('meeting-read/', [LeadController::class, 'meetingread'])->name('lead.meetingread');
    Route::get('follow-up/', [LeadController::class, 'followup'])->name('lead.followup');

    Route::get('insingleDay/', 'LeadController@insingleDay')->name('lead.insingleDay');
    Route::get('intwoDay/', 'LeadController@intwoDay')->name('lead.intwoDay');
    Route::get('overdueDay/', 'LeadController@overdueDay')->name('lead.overdueDay');
    Route::get('aftertwoDay/', 'LeadController@aftertwoDay')->name('lead.aftertwoDay');

    //Get Premium By Type // Payment Plan By Premium
    Route::get('get-premium/{type_id}', [PremiumController::class, 'get_premium']);
    Route::get('get-payment-plan/{premium_id}/{project_type_id}', [PaymentPlanController::class, 'get_payment_plan']);

    //             //End New Routes
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
