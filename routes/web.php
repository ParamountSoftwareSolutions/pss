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
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\FaqController;
use App\Http\Controllers\User\PrivacyPolicyController;
use App\Http\Controllers\User\TermController;
use App\Http\Controllers\User\BannerController;
use App\Http\Controllers\User\DealerController;
use App\Http\Controllers\User\HolidayController;
use App\Http\Controllers\User\EmployeeController;
use App\Http\Controllers\User\PayrollController;
use App\Http\Controllers\User\LeavesController;
use App\Models\lead;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/updateapp', function () {
    Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
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
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
///plac it into admin middleware

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/permission', [AdminController::class, 'permission'])->name('permission');
    Route::post('/permission_store', [AdminController::class, 'permission_store'])->name('permission_store');
});

Route::group(['prefix' => '{RolePrefix}', 'middleware' => ['auth:user', 'RolePrefix']], function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    //===============================//
    // Hrm    // Payroll
    //===============================//

    Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::post('/getSaleManagers', [EmployeeController::class, 'getSaleManagers'])->name('getSaleManagers');
        Route::get('/index', [EmployeeController::class, 'create'])->name('create');
        Route::post('/add', [EmployeeController::class, 'store'])->name('store');

        Route::get('/permission/{employeeId}', [EmployeeController::class, 'permission']);
        Route::post('permission', [EmployeeController::class, 'updatePermissions']);
        Route::get('/delete/{employeeId}', [EmployeeController::class, 'delete']);
        Route::get('/trash', [EmployeeController::class, 'getTrash']);
        Route::get('/restore/{employeeId}', [EmployeeController::class, 'restore']);
    });


    Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {

        Route::get('form/holidays/new', [HolidayController::class, 'holiday'])->name('form/holidays/new');
        Route::post('form/holidays/save', [HolidayController::class, 'saveRecord'])->name('form/holidays/save');
        Route::post('form/holidays/update', [HolidayController::class, 'updateRecord'])->name('form/holidays/update');

        Route::get('form/leaves/new', [LeavesController::class, 'leaves'])->name('form/leaves/new');
        Route::get('form/leavesemployee/new', [LeavesController::class, 'leavesEmployee'])->name('form/leavesemployee/new');
        Route::post('form/leaves/save', [LeavesController::class, 'saveRecord'])->name('form/leaves/save');
        Route::post('form/leaves/edit', [LeavesController::class, 'editRecordLeave'])->name('form/leaves/edit');
        Route::post('form/leaves/edit/delete', [LeavesController::class, 'deleteLeave'])->name('form/leaves/edit/delete');
    });

    Route::group(['prefix' => 'payroll', 'as' => 'payroll.'], function () {
        Route::get('form/salary/page', [PayrollController::class, 'salary'])->name('form/salary/page');
        Route::post('form/salary/save', [PayrollController::class, 'saveRecord'])->name('form/salary/save');
        Route::post('form/salary/update', [PayrollController::class, 'updateRecord'])->name('form/salary/update');
        Route::post('form/salary/delete', [PayrollController::class, 'deleteRecord'])->name('form/salary/delete');
        Route::get('form/salary/view/{user_id}', [PayrollController::class, 'salaryView'])->name('salary-view');


        Route::get('form/payroll/items', [PayrollController::class, 'payrollItems'])->name('form/payroll/items');

        Route::get('payrollEdit/{id}', [PayrollController::class, 'editPayroll'])->name('editPayroll');
        Route::get('payrollView/{id}', [PayrollController::class, 'viewPayroll'])->name('viewPayroll');
        Route::put('payrollUpdate/{id}', [PayrollController::class, 'updatePayroll'])->name('updatePayroll');
        Route::get('payrollImport', [PayrollController::class, 'importPayroll'])->name('importPayroll');
        Route::get('payrollExport', [PayrollController::class, 'exportPayroll'])->name('exportPayroll');
        Route::post('bulk_import_payroll', [PayrollController::class, 'bulk_import_payroll'])->name('bulk_import_payroll');
    });

    //===============================//
    //  Banner App related Routes    //
    //===============================//

    Route::resource('about', AboutController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('privacy_policy', PrivacyPolicyController::class);
    Route::resource('term', TermController::class);
    Route::resource('banner', BannerController::class);
    Route::post('banner/image/remove', [BannerController::class, 'image_remove']);


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
        Route::get('/{key}', [FeatureController::class, 'index'])->name('index');
        Route::get('{key}/create', [FeatureController::class, 'create'])->name('create');
        Route::post('{key}/store', [FeatureController::class, 'store'])->name('store');
        Route::get('{key}/edit/{id}', [FeatureController::class, 'edit'])->name('edit');
        Route::put('{key}/update/{id}', [FeatureController::class, 'update'])->name('update');
        Route::delete('{key}/destroy/{id}', [FeatureController::class, 'destroy'])->name('destroy');
    });

    //=========================//
    //  Building Management    //
    //=========================//
    Route::resource('building', BuildingController::class);
    Route::resource('floor', FloorController::class);
    Route::resource('building.floor.building_inventory', BuildingInventoryController::class);
    Route::get('extra_detail/{project_type}', [BuildingExtraDetailController::class, 'project_extra_detail'])->name('project_extra_detail');
    Route::resource('project.extra_detail', BuildingExtraDetailController::class);
    Route::post('extra-detail/remove/image', [BuildingExtraDetailController::class, 'image_remove']);
    Route::post('building/inventory/image/remove', [BuildingInventoryController::class, 'image_remove']);

    //=========================//
    //  Society Management    //
    //=========================//
    Route::resource('society', SocietyController::class);
//    Route::resource('block', SocietyBlockController::class);
    Route::resource('society.block.society_inventory', SocietyInventoryController::class);



    // Route::get('state/{id}', [HomeController::class, 'state']);
    // Route::get('city/{id}', [HomeController::class, 'city']);
    Route::get('get-premium/{type}', [PremiumController::class, 'get_premium']);
    Route::get('get-payment-plan/{premium_id}/{project_type_id}', [PaymentPlanController::class, 'get_payment_plan']);
    Route::get('get-project/{project_type_id}', [ProjectController::class, 'get_project']);
    Route::get('get-inventories/{project_id}', [ProjectController::class, 'get_inventories']);
    Route::get('get-floor-block/{project_id}', [ProjectController::class, 'get_floor_block']);
    //Route::post('building/inventory/image/remove', [BuildingInventoryController::class, 'image_remove']);
    Route::post('inventory/change-status/{project_id}', [BuildingInventoryController::class, 'change_status'])->name('inventory.change_status');

    //=========================//
    //  Leads Management    //
    //=========================//

    Route::resource('leads', LeadController::class);
    Route::get('lead/Matured', [LeadController::class, 'matured'])->name('leads.mature');
    Route::get('lead/closed', [LeadController::class, 'closed'])->name('leads.closed');
    Route::get('lead/facebook', [LeadController::class, 'facebook'])->name('leads.facebook');
    Route::post('lead/getInventory', [LeadController::class, 'getInventory'])->name('lead.getInventory');
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
    Route::get('/webhook/lead_assign_to_me/{page_id}/{token}', 'WebHookController@lead_assign_to_me')->name('webhook.lead_assign_to_me');
    Route::get('/webhook/lead_assign_to_both/{page_id}/{token}', 'WebHookController@lead_assign_to_both')->name('webhook.lead_assign_to_both');
    //Dublicate leads
    Route::get('/webhook/dublicate', [WebHookController::class, 'dublicate'])->name('webhook.dublicate');
    Route::get('/webhook/dublicate_store/{id}', [WebHookController::class, 'dublicate_store'])->name('webhook.dublicate_store');

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

    Route::get('client/transfered/{id}', [ClientController::class, 'client_transfered'])->name('client.transfered');
    Route::post('client/transfered_store', [ClientController::class, 'transfered_store'])->name('client.transfered_store');
    Route::get('client/client_active/{id}', [ClientController::class, 'client_active'])->name('client.active');
    Route::post('client/active/{id}', [ClientController::class, 'active'])->name('clients.active');

    Route::post('client/{client_id}/installment/{id}', [ClientController::class, 'installment'])->name('clients.installment');

    Route::get('building_inventory/{id}', [ClientController::class, 'building_inventory']);
    Route::get('societyBlock_inventory/{id}', [ClientController::class, 'societyBlock_inventory']);
    // Route::get('client/building_inventory/{id}', [ClientController::class, 'building_inventory'])->name('client.building_inventory');

    //Inventory historys
    Route::get('sale/history', [ClientController::class, 'history'])->name('sale.history');
    Route::get('sale/history/show/{id}', [ClientController::class, 'history_sale'])->name('sale.show');
    //Inventory historys
    // //=============//
    // /* Clients */
    // //=============//

    //             //End New Routes    Get Payment Plan





    //====================//
    // Task Targets Route //
    //====================//

    Route::group(['prefix' => 'targets', 'as' => 'target.'], function () {
        Route::get('/', [TargetController::class, 'my_targets'])->name('index');
        Route::get('staff-targets', [TargetController::class, 'staff_targets'])->name('staff_targets');
        Route::get('assign-target', [TargetController::class, 'assign_target'])->name('assign_target');
        Route::post('store', [TargetController::class, 'store'])->name('store');
        Route::get('get-role-list/{role}', [TargetController::class, 'get_role_list'])->name('get_role_list');
        Route::get('edit-task/{id}', [TargetController::class, 'edit_task'])->name('edit_task');
        Route::post('update-task/{id}', [TargetController::class, 'update_task'])->name('update_task');
        Route::get('task-reports', [TargetController::class, 'task_reports'])->name('task_reports');
        Route::get('task/get-report/{id}', [TargetController::class, 'get_report'])->name('get_report');
    });




    // //=============//
    // /* Email Routes */
    // //=============//

    Route::group(['prefix' => 'email', 'as' => 'email.'], function () {
        Route::get('compose', [EmailController::class, 'email_compose'])->name('compose');
        Route::post('compose/send', [EmailController::class, 'email_compose_send'])->name('compose.send');
        Route::post('compose/save', [EmailController::class, 'email_compose_save'])->name('compose.save');
        Route::get('sent', [EmailController::class, 'send_email'])->name('sent');
        Route::get('detail/{id}', [EmailController::class, 'email_detail'])->name('detail');
        Route::get('draft', [EmailController::class, 'draft_email'])->name('draft');
        Route::get('view/{id}', [EmailController::class, 'email_view'])->name('view');
        Route::post('forward/{id}', [EmailController::class, 'email_forward'])->name('forward');
        Route::delete('destroy/{id}', [EmailController::class, 'email_destroy'])->name('destroy');
        Route::post('remove/image', [EmailController::class, 'remove_image_email'])->name('remove_image_email');
        Route::post('resend/{id}', [EmailController::class, 'email_resend'])->name('resend');
    });

    // //===============//
    // /* Dealer Routes */
    // //===============//

    Route::resource('dealer', DealerController::class);
    Route::get('dealer/{dealer}/create', [DealerController::class,'add_new'])->name('dealer.add_new');
    Route::post('dealer/{dealer}/store', [DealerController::class,'add_new_store'])->name('dealer.add_new_store');
    Route::get('dealer/{dealer}/project/{project}', [DealerController::class,'dealer_project'])->name('dealer.project');
    Route::get('dealer/{dealer}/project/{project}/generate-pdf', [DealerController::class,'generatePDF'])->name('dealer.generate_pdf');
    Route::group(['prefix' => 'dealer','as'=>'email.'], function () {
        Route::get('compose', [EmailController::class,'email_compose'])->name('compose');
        Route::post('compose/send', [EmailController::class,'email_compose_send'])->name('compose.send');
        Route::post('compose/save', [EmailController::class,'email_compose_save'])->name('compose.save');
        Route::get('sent', [EmailController::class,'send_email'])->name('sent');
        Route::get('detail/{id}', [EmailController::class,'email_detail'])->name('detail');
        Route::get('draft', [EmailController::class,'draft_email'])->name('draft');
        Route::get('view/{id}', [EmailController::class,'email_view'])->name('view');
        Route::post('forward/{id}', [EmailController::class,'email_forward'])->name('forward');
        Route::delete('destroy/{id}', [EmailController::class,'email_destroy'])->name('destroy');
        Route::post('remove/image', [EmailController::class,'remove_image_email'])->name('remove_image_email');
        Route::post('resend/{id}', [EmailController::class,'email_resend'])->name('resend');
    });
});


/////////////////////////////////Accounts///////////////////////////

Route::group(['prefix' => 'accounts'], function () {
    Route::get('C_O_A', [\App\Http\Controllers\AccountsController::class, 'C_O_A']);
    Route::get('show_tree', [\App\Http\Controllers\AccountsController::class, 'show_tree'])->name('accounts.show_tree');
    Route::post('insert_coa2', [\App\Http\Controllers\AccountsController::class, 'insert_coa2'])->name('accounts.insert_coa2');
    Route::post('selectphead', [\App\Http\Controllers\AccountsController::class, 'selectphead']);
    Route::get('selectedform/{id}', [\App\Http\Controllers\AccountsController::class, 'selectedform']);
    Route::get('updatecoa/{id}', [\App\Http\Controllers\AccountsController::class, 'updatecoa']);
    Route::get('deletehead/{id}', [\App\Http\Controllers\AccountsController::class, 'deletehead']);

    Route::get('debit_voucher', [\App\Http\Controllers\AccountsController::class, 'debit_voucher'])->name('accounts.debit_voucher');
    Route::get('debtvouchercode/{id}', [\App\Http\Controllers\AccountsController::class, 'debtvouchercode'])->name('accounts.debtvouchercode');
    Route::post('create_debit_voucher', [\App\Http\Controllers\AccountsController::class, 'create_debit_voucher'])->name('accounts.create_debit_voucher');

    Route::get('credit_voucher', [\App\Http\Controllers\AccountsController::class, 'credit_voucher'])->name('accounts.credit_voucher');
    Route::post('create_credit_voucher', [\App\Http\Controllers\AccountsController::class, 'create_credit_voucher'])->name('accounts.create_credit_voucher');

    Route::get('contra_voucher', [\App\Http\Controllers\AccountsController::class, 'contra_voucher'])->name('accounts.contra_voucher');
    Route::post('update_contra_voucher', [\App\Http\Controllers\AccountsController::class, 'update_contra_voucher'])->name('accounts.update_contra_voucher');
    Route::post('create_contra_voucher', [\App\Http\Controllers\AccountsController::class, 'create_contra_voucher'])->name('accounts.create_contra_voucher');

    Route::get('journal_voucher', [\App\Http\Controllers\AccountsController::class, 'journal_voucher'])->name('accounts.journal_voucher');
    Route::post('create_journal_voucher', [\App\Http\Controllers\AccountsController::class, 'create_journal_voucher'])->name('accounts.create_journal_voucher');
    Route::get('aprove_v', [\App\Http\Controllers\AccountsController::class, 'aprove_v'])->name('accounts.aprove_v');

    Route::get('voucher_update/{id}', [\App\Http\Controllers\AccountsController::class, 'voucher_update'])->name('accounts.voucher_update');
    Route::get('visactive/{id}', [\App\Http\Controllers\AccountsController::class, 'isactive'])->name('accounts.isactive');

    Route::get('trial_balance', [\App\Http\Controllers\AccountsController::class, 'trial_balance'])->name('accounts.trial_balance');
    Route::post('trial_balance_report', [\App\Http\Controllers\AccountsController::class, 'trial_balance_report'])->name('accounts.trial_balance_report');

    Route::get('vouchar_cash/{date}', [\App\Http\Controllers\AccountsController::class, 'vouchar_cash']);
    Route::get('general_ledger', [\App\Http\Controllers\AccountsController::class, 'general_ledger'])->name('accounts.general_ledger');
    Route::get('general_led/{Headid}', [\App\Http\Controllers\AccountsController::class, 'general_led'])->name('accounts.general_led');

    Route::post('accounts_report_search', [\App\Http\Controllers\AccountsController::class, 'accounts_report_search'])->name('accounts.accounts_report_search');
    Route::get('check_status_report', [\App\Http\Controllers\AccountsController::class, 'check_status_report']);
    Route::any('cash_book', [\App\Http\Controllers\AccountsController::class, 'cash_book'])->name('accounts.cash_book');
    Route::any('bank_book', [\App\Http\Controllers\AccountsController::class, 'bank_book'])->name('accounts.bank_book');
    Route::get('voucher_report_print/{id}', [\App\Http\Controllers\AccountsController::class, 'voucher_report_print'])->name('accounts.voucher_report_print');
    Route::get('vouchar_view/{id}', [\App\Http\Controllers\AccountsController::class, 'vouchar_view'])->name('accounts.vouchar_view');
    Route::get('voucher_report', [\App\Http\Controllers\AccountsController::class, 'voucher_report'])->name('accounts.voucher_report');
    Route::post('voucher_report_serach', [\App\Http\Controllers\AccountsController::class, 'voucher_report_serach'])->name('accounts.voucher_report_serach');
    Route::get('coa_print', [\App\Http\Controllers\AccountsController::class, 'coa_print'])->name('accounts.coa_print');
    Route::get('profit_loss_report', [\App\Http\Controllers\AccountsController::class, 'profit_loss_report'])->name('accounts.profit_loss_report');
    Route::post('profit_loss_report_search', [\App\Http\Controllers\AccountsController::class, 'profit_loss_report_search'])->name('accounts.profit_loss_report_search');
    Route::get('cash_flow_report', [\App\Http\Controllers\AccountsController::class, 'cash_flow_report'])->name('accounts.cash_flow_report');
    Route::post('cash_flow_report_search', [\App\Http\Controllers\AccountsController::class, 'cash_flow_report_search'])->name('accounts.cash_flow_report_search');
    Route::get('supplier_headcode/{id}', [\App\Http\Controllers\AccountsController::class, 'supplier_headcode']);
    Route::get('supplier_payments', [\App\Http\Controllers\AccountsController::class, 'supplier_payments'])->name('accounts.supplier_payments');
    Route::post('banklist', [\App\Http\Controllers\AccountsController::class, 'banklist']);
    Route::post('create_supplier_payment', [\App\Http\Controllers\AccountsController::class, 'create_supplier_payment'])->name('accounts.create_supplier_payment');
    Route::get('supplier_paymentreceipt/{supplier_id}/{voucher_no}/{coaid}', [\App\Http\Controllers\AccountsController::class, 'supplier_paymentreceipt'])->name('accounts.supplier_paymentreceipt');
    Route::get('cash_adjustment', [\App\Http\Controllers\AccountsController::class, 'cash_adjustment'])->name('accounts.cash_adjustment');
    Route::post('create_cash_adjustment', [\App\Http\Controllers\AccountsController::class, 'create_cash_adjustment'])->name('accounts.create_cash_adjustment');
    Route::any('balance_sheet', [\App\Http\Controllers\AccountsController::class, 'balance_sheet'])->name('accounts.balance_sheet');

    Route::get('debit_voucher_code/{id}', [\App\Http\Controllers\AccountsController::class, 'debit_voucher_code']);
    Route::post('update_journal_voucher', [\App\Http\Controllers\AccountsController::class, 'update_journal_voucher'])->name('accounts.update_journal_voucher');

    Route::post('update_debit_voucher', [\App\Http\Controllers\AccountsController::class, 'update_debit_voucher'])->name('accounts.update_debit_voucher');
    Route::post('update_credit_voucher', [\App\Http\Controllers\AccountsController::class, 'update_credit_voucher'])->name('accounts.update_credit_voucher');
});
