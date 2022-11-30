<?php


use App\Http\Controllers\User\PremiumController;
use App\Http\Controllers\User\BlockController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\ProjectController;
use App\Http\Controllers\User\SizeController;
use App\Http\Controllers\User\UnitController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\WebHookController;
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

Route::get('/', [LoginController::class, 'index'])->name('/');
Route::get('login', [LoginController::class, 'index'])->name('/');
Route::post('login', [LoginController::class, 'store'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

Route::group(['prefix' => '{RolePrefix}', 'middleware' => ['auth:user', 'RolePrefix']], function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    // //=============//
    // /* Project Management */
    // //=============//
    Route::resource('block', BlockController::class);
    Route::resource('premium', PremiumController::class);
    Route::resource('unit', UnitController::class);
    Route::resource('size', SizeController::class);
    Route::resource('type', TypeController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('project', ProjectController::class);
    Route::resource('property', PropertyController::class);
    Route::resource('farmhouse', FarmhouseController::class);
    Route::resource('payment_plan', PaymentPlanController::class);

    // //=============//
    // /* Leads */
    // //=============//

    Route::resource('leads', LeadController::class);
    Route::get('lead/change_priority/{priority}/{id}', [LeadController::class, 'changepriority'])->name('lead.change_priority');
    Route::post('lead/change_status', [LeadController::class, 'changestatus'])->name('lead.change_status');

    //             //New Routes Added
    Route::get('lead/building_info/{building_id}', 'LeadController@buildinginfo')->name('lead.building_info');
    Route::post('lead/filter', 'LeadController@filter')->name('lead.filter');
    Route::post('lead/search', 'LeadController@search')->name('lead.search');
    Route::post('lead/searchbydate', 'LeadController@searchbydate')->name('lead.searchByDate');
    // Route::post('lead/change_status', 'LeadController@changestatus')->name('lead.change_status');

    Route::get('lead/comments/{id}', 'LeadController@comments')->name('lead.comments');
    Route::any('lead-assign', 'LeadController@lead_assign')->name('lead.assign');
    Route::get('is-read/', 'LeadController@isread')->name('lead.isread');
    Route::get('meeting-read/', 'LeadController@meetingread')->name('lead.meetingread');
    Route::get('follow-up/', 'LeadController@followup')->name('lead.followup');

    Route::get('insingleDay/', 'LeadController@insingleDay')->name('lead.insingleDay');
    Route::get('intwoDay/', 'LeadController@intwoDay')->name('lead.intwoDay');
    Route::get('overdueDay/', 'LeadController@overdueDay')->name('lead.overdueDay');
    Route::get('aftertwoDay/', 'LeadController@aftertwoDay')->name('lead.aftertwoDay');
    //             //End New Routes
    // //=============//
    // /* Acccounts */
    // //=============//
});