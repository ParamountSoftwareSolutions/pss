<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('/')}}/assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown">Geneva Kennedy</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings mr-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock mr-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Admin Head</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li class="menu-title">Navigation</li>
                <li>
                    <a href="{{route('dashboard', ['RolePrefix' => RolePrefix()])}}">
                        <i data-feather="airplay"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li class="menu-title mt-2">Apps</li>

                <li>
                    <a href="#sidebarEcommerce" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Leads </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarEcommerce">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('leads.create', ['RolePrefix' => RolePrefix()])}}">Add Lead</a>
                            </li>
                            <li>
                                <a href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">All Lead</a>
                            </li>
                            <li>
                                <a href="{{route('leads.mature', ['RolePrefix' => RolePrefix()])}}">Matured</a>
                            </li>
                            <li>
                                <a href="{{route('leads.closed', ['RolePrefix' => RolePrefix()])}}">Closed</a>
                            </li>
                            <li>
                                <a href="{{route('webhook.index', ['RolePrefix' => RolePrefix()])}}">Facebook leads</a>
                            </li>
                            <li>
                                <a href="{{route('lead.employee', ['RolePrefix' => RolePrefix()])}}">Employee Reports</a>
                            </li>
                            <li>
                                <a href="{{route('lead.refer', ['RolePrefix' => RolePrefix()])}}">Refer Leads</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clear-fix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
























{{--
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('property_manager.dashboard')  }}">
                <img alt="image" src="{{ asset('public/panel/assets/img/logo.png') }}" class="header-logo" style="height:150px !important;margin-top: -20px !important;" />
            </a>
        </div>
        <ul class="sidebar-menu">

            <li class="menu-header">Main</li>
            @if(Helpers::isPropertyManager())
            <li class="dropdown @if (request()->routeIs('property_manager.dashboard')) active @endif">
                <a href="{{ route('property_manager.dashboard') }}" class="nav-link"><i class="fa-solid fa-tv"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @elseif(Helpers::isPropertyAdmin())

            @elseif(Helpers::isEmployee())
            <li class="dropdown @if (request()->routeIs('sale_person.dashboard')) active @endif">
                <a href="{{ route('sale_person.dashboard') }}" class="nav-link"><i class="fa-solid fa-tv"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @elseif(Helpers::isSaleManager())
            <li class="dropdown @if (request()->routeIs('sale_manager.dashboard')) active @endif">
                <a href="{{ route('sale_manager.dashboard') }}" class="nav-link"><i class="fa-solid fa-tv"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @elseif(Helpers::isSuperAdmin())
            <li class="dropdown @if (request()->routeIs('admin.dashboard')) active @endif">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fa-solid fa-tv"></i><span>Dashboard</span></a>
            </li>
            @endif
            @if(Helpers::isPropertyManager() && (new App\Helpers\Helpers)->building_detail()->count() > 1)
            <li class="dropdown @if (request()->routeIs('property_manager.custom_building.dashboard')) active @endif">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i class="fa-sharp fa-solid fa-building-columns"></i><span>Project Dashboard</span></a>
                <ul class="dropdown-menu">
                    @foreach((new App\Helpers\Helpers)->building_detail() as $data)
                    <li><a class="nav-link" href="{{ route('property_manager.custom_building.dashboard', $data->id) }}">{{ $data->name }}</a></li>
                    @endforeach
                </ul>
            </li>
            @endif
            @if(Helpers::isSuperAdmin())
            <li class="menu-header">User Management</li>
            <li class="dropdown @if (request()->routeIs('admin.society_admin.index', 'admin.society_admin.create', 'admin.society_admin.edit', 'admin.society_admin.show')) active @endif">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i class="fa-solid fa-users"></i><span>Society Data</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link " href="{{ route('admin.society_admin.index') }}">Society Admin</a></li>
                </ul>
            </li>
            <li class="dropdown @if (request()->routeIs('admin.property_admin.index', 'admin.property_admin.create', 'admin.property_admin.edit', 'admin.property_admin.show')) active @endif">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i class="fa-sharp fa-solid fa-house-chimney"></i><span>Property Data</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link " href="{{ route('admin.property_admin.index') }}">Property Admin</a></li>
                </ul>
            </li>
            @endif
            @if(Helpers::isSaleManager())
            <li class="dropdown @if (request()->routeIs('sale_manager.employee.index', 'sale_manager.employee.create', 'sale_manager.employee.edit')) active @endif">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i class="fa-solid fa-user"></i><span>Sales Person</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('sale_manager.employee.index') }}">Employee</a></li>
                </ul>
            </li>
            @endif
            @if(Helpers::isPropertyManager() || Helpers::isSaleManager() || Helpers::isEmployee())
            <li class="menu-header">Project Management</li>
            <li class="dropdown @if (request()->routeIs('property_manager.building.index', 'property_manager.building.create', 'property_manager.building.edit', 'property_manager.building.show', 'property_manager.building_details.index', 'property_manager.building_details.edit')) active @endif">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i class="fa-sharp fa-solid fa-building-columns"></i>
                    <span>Project</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('property_manager.building.index',['panel' => \App\Helpers\Helpers::user_login_route()['panel']]) }}">All Projects</a></li>
                    <li><a class="nav-link" href="{{ route('property_manager.building_details.index',['panel' => \App\Helpers\Helpers::user_login_route()['panel']]) }}">All Project Extra Detail</a></li>
                </ul>
            </li>
            @elseif(Helpers::isPropertyAdmin())
            <li class="menu-header">Project Management</li>
            <li class="dropdown @if (request()->routeIs('property_admin.building.index', 'property_admin.building.create', 'property_admin.building.edit', 'property_admin.building.show')) active @endif">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i class="fa-sharp fa-solid fa-building-columns"></i><span>Project</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('property_admin.building.index') }}">Project List</a></li>
                    --}}{{--<li><a class="nav-link" href="{{ route('property_admin.building.detail_form') }}">Add Project Details</a>
            </li>--}}{{--
        </ul>
        </li>
        @endif
        @if(Helpers::isPropertyAdmin())
        <li class="dropdown @if (request()->routeIs('property_admin.manager.index', 'property_admin.manager.create', 'property_admin.manager.edit', 'property_admin.manager.show', 'property_admin.sale_manager.index', 'property_admin.sale_manager.create', 'property_admin.sale_manager.edit', 'property_admin.sale_manager.show')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-user"></i><span>Manager</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_admin.manager.index') }}">Manager List</a></li>
                <li><a class="nav-link" href="{{ route('property_admin.sale_manager.index') }}">Sale Manager List</a></li>
                --}}{{--<li><a class="nav-link" href="{{ route('property_admin.building.detail_form') }}">Add Project Details</a>
        </li>--}}{{--
        </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.property.index', 'property_manager.property.create', 'property_manager.property.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-sharp fa-solid fa-house-chimney"></i>
                <span>Property</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.property.index') }}">Property</a></li>
            </ul>
        </li>
        @endif

        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.membership.index', 'property_manager.membership.create', 'property_manager.membership.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-file-lines"></i>
                <span>Forms</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.membership.index') }}">Membership Form</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.payment_plan.index', 'property_manager.payment_plan.create', 'property_manager.payment_plan.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-credit-card"></i>
                <span>Payment Plan</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.payment_plan.index') }}">Payment Plan</a></li>
            </ul>
        </li>
        @can('Accounts')
        <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-user"></i>
                <span>Accounts</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('accounts.show_tree') }}">Chart of Accounts</a></li>
                <li><a class="nav-link" href="{{ route('accounts.supplier_payments') }}">Supplier Payment</a></li>
                <li><a class="nav-link" href="{{ route('accounts.cash_adjustment') }}">Cash Adjustment</a></li>
                <li><a class="nav-link" href="{{ route('accounts.debit_voucher') }}">Debit Voucher</a></li>
                <li><a class="nav-link" href="{{ route('accounts.credit_voucher') }}">Credit Voucher</a></li>
                <li><a class="nav-link" href="{{ route('accounts.contra_voucher') }}">Contra Voucher</a></li>
                <li><a class="nav-link" href="{{ route('accounts.journal_voucher') }}">Journal Voucher</a></li>
                <li><a class="nav-link" href="{{ route('accounts.aprove_v') }}">Voucher Approval</a></li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown">
                        <i class="fa-solid fa-user"></i>
                        <span>Accounts Report</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('accounts.voucher_report') }}">Voucher Report</a></li>
                        <li><a class="nav-link" href="{{ route('accounts.cash_book') }}">Cash Book</a></li>
                        <li><a class="nav-link" href="{{ route('accounts.bank_book') }}">Bank Book</a></li>
                        <li><a class="nav-link" href="{{ route('accounts.general_ledger') }}">General Ledger</a></li>
                        <li><a class="nav-link" href="{{ route('accounts.trial_balance') }}">Trial Balance</a></li>
                        <li><a class="nav-link" href="{{ route('accounts.profit_loss_report') }}">Profit Loss</a></li>
                        <li><a class="nav-link" href="{{ route('accounts.cash_flow_report') }}">Cash Flow</a></li>
                        <li><a class="nav-link" href="{{ route('accounts.coa_print') }}">COA Print</a></li>
                        <li><a class="nav-link" href="{{ route('accounts.balance_sheet') }}">Balance Sheet</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        @endcan
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.banner.index', 'property_manager.banner.update')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-image"></i>
                <span>Banner</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.banner.index') }}">Banner List</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.expense.index', 'property_manager.expense.edit', 'property_manager.expense.create', 'property_manager.office_expense.index', 'property_manager.office_expense.create', 'property_manager.office_expense.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-sharp fa-solid fa-sack-dollar"></i>
                <span>Expense</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.office_expense.index') }}">Office Expense</a></li>
                <li><a class="nav-link" href="{{ route('property_manager.expense.index') }}">Construction Expense</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.employee.index', 'property_manager.employee.create', 'property_manager.employee.edit', 'property_manager.employee_payroll.index', 'property_manager.employee_payroll.create', 'property_manager.employee_payroll.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-users"></i>
                <span>HRM</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.employee.index') }}">Employee</a></li>
                <li><a class="nav-link" href="{{ route('property_manager.employee_payroll.index') }}">Payroll</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.request.index', 'property_manager.request.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-regular fa-envelope"></i><span>Request</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.request.index', ['type' => 'possession']) }}">Possession</a></li>
                <li><a class="nav-link" href="{{ route('property_manager.request.index', ['type' => 'transfer']) }}">Transfer</a></li>
                <li><a class="nav-link" href="{{ route('property_manager.request.index', ['type' => 'file']) }}">File</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager() || Helpers::isPropertyAdmin() || Helpers::isSaleManager() || Helpers::isSaleManager() || Helpers::isEmployee())
        <li class="dropdown @if (request()->routeIs('property_manager.sale.lead.index', 'property_manager.sale.lead.create', 'property_manager.sale.lead.edit', 'property_manager.sale.online_booking.index', 'property_manager.sale.online_booking.edit', 'property_manager.sale.client.index', 'property_manager.sale.client.create', 'property_manager.sale.client.edit', 'property_manager.sale.client.show')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="far fa-handshake"></i>
                <span>Sales</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link " href="{{ route('property_manager.sale.lead.index', App\Helpers\Helpers::user_login_route()) }}">Leads</a></li>
                <li><a class="nav-link " href="{{ route('property_manager.sale.online_booking.index', App\Helpers\Helpers::user_login_route()) }}">Online
                        Booking</a></li>
                <li><a class="nav-link " href="{{ route('property_manager.sale.client.index', App\Helpers\Helpers::user_login_route()) }}">Client</a></li>
                <li><a class="nav-link " href="{{ route('property_manager.sale.client.history', App\Helpers\Helpers::user_login_route()) }}">Sale
                        History</a></li>

                <li><a class="nav-link " href="{{ route('property_manager.sale.import.view', App\Helpers\Helpers::user_login_route()) }}">Bulk Import</a>
                </li>
                <?php if (!\Illuminate\Support\Facades\Auth::user()->hasRole('sale_person')) { ?>
                    <li><a class="nav-link " href="{{ route('property_manager.sale.bulk.export', App\Helpers\Helpers::user_login_route()) }}">Bulk Export</a>
                    </li>
                <?php } ?>
            </ul>
        </li>
        <!-- <li class="dropdown @if (request()->routeIs('property_manager.my_targets','property_manager.staff_targets','property_manager.task_reports')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-user"></i><span>Task Manager</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.my_targets', Helpers::user_login_route()) }}">My Targets </a></li>
                <li><a class="nav-link" href="{{ route('property_manager.staff_targets', Helpers::user_login_route()) }}">Staff Targets </a></li>
                <li><a class="nav-link" href="{{ route('property_manager.task_reports', Helpers::user_login_route()) }}">Reports </a></li>
            </ul>
        </li> -->
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.custom_notification.index', 'property_manager.custom_notification.create', 'property_manager.custom_notification.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-regular fa-bell"></i>
                <span>Custom Notification</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link " href="{{ route('property_manager.custom_notification.index') }}">Notification List</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager() || Helpers::isPropertyAdmin() || Helpers::isSaleManager())
        <li class="dropdown @if (request()->routeIs('property_manager.webhook.index')) active @endif">
            <a href="{{ route('property_manager.webhook.index', \App\Helpers\Helpers::user_login_route()['panel']) }}">
                <i data-feather="facebook"></i><span>Facebook Leads</span>
            </a>
        </li>
        @endif
        @if(Helpers::isPropertyManager() || Helpers::isPropertyAdmin() || Helpers::isSaleManager() || Helpers::isEmployee())
        <li class="dropdown @if (request()->routeIs('property_manager.notification.index', 'property_manager.notification.create', 'property_manager.notification.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-regular fa-bell"></i>
                <span>Notification</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.notification.index', App\Helpers\Helpers::user_login_route()) }}">Notification</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyAdmin())
        <li class="dropdown @if (request()->routeIs('property_admin.setting.*')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-gear"></i><span>Settings</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_admin.setting.push_notification') }}">Push Notification</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyAdmin())
        <li class="dropdown @if (request()->routeIs('property_admin.profile.index')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-user"></i><span>Profile</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link " href="{{ route('property_admin.profile.index') }}">Profile</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.report.sale', 'property_manager.report.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-user"></i>
                <span>Accounts</span></a>
            <ul class="dropdown-menu">
                --}}{{-- <li><a class="nav-link" href="">Sales Report</a></li>--}}{{--
                <li><a class="nav-link" href="{{ route('property_manager.report.expense_report') }}">Expenses Report</a></li>
                <li><a class="nav-link" href="">Employee</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.update.index', 'property_manager.update.create', 'property_manager.update.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-newspaper"></i>
                <span>News</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('property_manager.update.index') }}">Project Update</a></li>
            </ul>
        </li>
        @endif
        @if(Helpers::isPropertyManager())
        <li class="dropdown @if (request()->routeIs('property_manager.about.index', 'property_manager.about.edit', 'property_manager.privacyPolicy.index', 'property_manager.privacyPolicy.edit', 'property_manager.term.index', 'property_manager.term.edit', 'property_manager.faq.index', 'property_manager.faq.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-caret-right"></i>
                <span>More</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link " href="{{ route('property_manager.about.index') }}">About</a></li>
                <li><a class="nav-link " href="{{ route('property_manager.privacyPolicy.index') }}">Privacy & Policy</a></li>
                <li><a class="nav-link " href="{{ route('property_manager.term.index') }}">Term & Condition</a></li>
                <li><a class="nav-link " href="{{ route('property_manager.faq.index') }}">Faqs</a></li>
            </ul>
        </li>
        @endif










        @if(\Illuminate\Support\Facades\Auth::user()->hasRole('accountant'))
        <li class="dropdown @if (request()->routeIs('accountant.dashboard')) active @endif">
            <a href="{{ route('accountant.dashboard') }}" class="nav-link"><i class="fa-solid fa-tv"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="dropdown @if (request()->routeIs('accountant.employee.index', 'accountant.employee.create', 'accountant.employee.edit', 'accountant.employee_payroll.index', 'accountant.employee_payroll.create', 'accountant.employee_payroll.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-users"></i>
                <span>HRM</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('accountant.employee.index') }}">Employee</a></li>
                <li><a class="nav-link" href="{{ route('accountant.employee_payroll.index') }}">Payroll</a></li>
            </ul>
        </li>
        <li class="dropdown @if (request()->routeIs('accountant.expense.index', 'accountant.expense.edit', 'accountant.expense.create', 'accountant.office_expense
                .index', 'accountant.office_expense.create', 'accountant.office_expense.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-sharp fa-solid fa-sack-dollar"></i>
                <span>Expense</span></a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('accountant.office_expense.index') }}">Office Expense</a></li>
                <li><a class="nav-link" href="{{ route('accountant.expense.index') }}">Construction Expense</a></li>
            </ul>
        </li>
        <li class="dropdown @if (request()->routeIs('accountant.report.sale', 'accountant.report.edit')) active @endif">
            <a href="#" class="menu-toggle nav-link has-dropdown">
                <i class="fa-solid fa-user"></i>
                <span>Accounts</span></a>
            <ul class="dropdown-menu">
                --}}{{--<li><a class="nav-link" href="">Sales Report</a></li>--}}{{--
                <li><a class="nav-link" href="{{ route('accountant.report.expense_report') }}">Expenses Report</a></li>
                <li><a class="nav-link" href="">Employee</a></li>
            </ul>
        </li>
        @endif

        </ul>
    </aside>
</div>--}}
