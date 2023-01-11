<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{asset('/assets/images/users/user-1.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
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
                    <a href="#project" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Project Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="project">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('project.create', ['RolePrefix' => RolePrefix()])}}">Add Project</a>
                            </li>
                            <li>
                                <a href="{{route('project.index', ['RolePrefix' => RolePrefix()])}}">All Project</a>
                            </li>
                        </ul>
                    </div>
                </li>
               
                <li>
                    <a href="#building" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Building Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="building">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('building.index', ['RolePrefix' => RolePrefix()])}}">All Building</a>
                                <a href="{{route('project_extra_detail', ['RolePrefix' => RolePrefix(),'project_type'=>'building'])}}">Building
                                    Extra Detail</a>
                                <a href="#building_feature" data-toggle="collapse">
                                    <i data-feather="shopping-cart"></i>
                                    <span> Building Features </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="building_feature">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'plot'])}}">Plot
                                                Features</a>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'communication'])}}">Communication
                                                Features</a>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'community'])}}">Community
                                                Features</a>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'health'])}}">Health
                                                Features</a>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'other'])}}">Other
                                                Features</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
             
                <li>
                    <a href="#society" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Society Management </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="society">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('society.index', ['RolePrefix' => RolePrefix()])}}">All Society</a>
                                <a href="{{route('project_extra_detail', ['RolePrefix' => RolePrefix(),'project_type'=>'society'])}}">Society
                                    Extra Detail</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#property" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Property </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="property">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('property.create', ['RolePrefix' => RolePrefix()])}}">Add Property</a>
                            </li>
                            <li>
                                <a href="{{route('property.index', ['RolePrefix' => RolePrefix()])}}">All Property</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#farmhouse" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Farmhouse </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="farmhouse">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('farmhouse.index', ['RolePrefix' => RolePrefix()])}}">All Farmhouse</a>
                                <a href="{{route('project_extra_detail', ['RolePrefix' => RolePrefix(),'project_type'=>'farm_house'])}}">Farmhouse
                                    Extra Detail</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#inventory-data" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Inventory Extra Data </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="inventory-data">
                        <ul class="nav-second-level">
                            <li><a href="{{route('premium.index', ['RolePrefix' => RolePrefix()])}}">Premium</a></li>
                            <li><a href="{{route('block.index', ['RolePrefix' => RolePrefix()])}}">Block</a></li>
                            <li><a href="{{route('size.index', ['RolePrefix' => RolePrefix()])}}">Size</a></li>
                            <li><a href="{{route('type.index', ['RolePrefix' => RolePrefix()])}}">Type</a></li>
                            <li><a href="{{route('category.index', ['RolePrefix' => RolePrefix()])}}">Category</a></li>
                            <li><a href="{{route('payment_plan.index', ['RolePrefix' => RolePrefix()])}}">Payment
                                    Plan</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#task-target" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Task Targets </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="task-target">
                        <ul class="nav-second-level">
                            <li><a href="{{route('target.index', ['RolePrefix' => RolePrefix()])}}">My Targets</a></li>
                            <li><a href="{{route('target.staff_targets', ['RolePrefix' => RolePrefix()])}}">Staff
                                    Targets</a></li>
                            <li><a href="{{route('target.task_reports', ['RolePrefix' => RolePrefix()])}}">Reports</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#employees" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i> <span> Employees</span> <span class="menu-arrow fa fa-"></span>
                    </a>
                    <div class="collapse" id="employees">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('employee.index', ['RolePrefix' => RolePrefix()]) }}">All Employees</a></li>
                            <li><a href="{{ route('employees.form/holidays/new', ['RolePrefix' => RolePrefix()]) }}">Holidays</a></li>
                            <li><a href="{{ route('employees.form/leaves/new', ['RolePrefix' => RolePrefix()]) }}">Leaves</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#payroll" data-toggle="collapse"><i data-feather="shopping-cart"></i>
                        <span> Payroll </span> <span class="menu-arrow fa fa-"></span></a>
                    <div class="collapse" id="payroll">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('payroll.form/salary/page', ['RolePrefix' => RolePrefix()]) }}"> Employee Salary </a></li>
                            {{-- <li><a href="{{ route('payroll.form/salary/view', ['RolePrefix' => RolePrefix()]) }}"> Payslip </a>
                </li> --}}
                <li><a href="{{ route('payroll.form/payroll/items', ['RolePrefix' => RolePrefix()]) }}"> Payroll Items </a></li>
            </ul>
        </div>
        </li>
        <li>
            <a href="#task-target1" data-toggle="collapse">
                <i data-feather="shopping-cart"></i>
                <span> Accounts </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="task-target1">
                <ul class="nav-second-level">
                    <li><a class="nav-link" href="{{ route('accounts.show_tree') }}">Chart of Accounts</a></li>
                    <li><a class="nav-link" href="{{ route('accounts.supplier_payments') }}">Supplier Payment</a></li>
                    <li><a class="nav-link" href="{{ route('accounts.cash_adjustment') }}">Cash Adjustment</a></li>
                    <li><a class="nav-link" href="{{ route('accounts.debit_voucher') }}">Debit Voucher</a></li>
                    <li><a class="nav-link" href="{{ route('accounts.credit_voucher') }}">Credit Voucher</a></li>
                    <li><a class="nav-link" href="{{ route('accounts.contra_voucher') }}">Contra Voucher</a></li>
                    <li><a class="nav-link" href="{{ route('accounts.journal_voucher') }}">Journal Voucher</a></li>
                    <li><a class="nav-link" href="{{ route('accounts.aprove_v') }}">Voucher Approval</a></li>
                    <li>
                        <a href="#task-target12" data-toggle="collapse">
                            <i data-feather="shopping-cart"></i>
                            <span> Accounts Report </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="task-target12">
                            <ul class="nav-second-level">
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
                        </div>
                    </li>
                </ul>
            </div>
        </li>

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
                        <a href="{{route('lead.employee', ['RolePrefix' => RolePrefix()])}}">Employee
                            Reports</a>
                    </li>
                    <li>
                        <a href="{{route('lead.refer', ['RolePrefix' => RolePrefix()])}}">Refer Leads</a>
                    </li>
                    <li>
                        <a href="{{route('lead.bulk_import.view', ['RolePrefix' => RolePrefix()])}}">Bulk
                            Import</a>
                    </li>
                    <li>
                        <a href="{{route('lead.bulk_export', ['RolePrefix' => RolePrefix()])}}">Bulk Export</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#email" data-toggle="collapse">
                <i data-feather="shopping-cart"></i>
                <span> Email </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="email">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{route('email.compose', ['RolePrefix' => RolePrefix()])}}">Compose</a>
                    </li>
                    <li>
                        <a href="{{route('email.sent', ['RolePrefix' => RolePrefix()])}}">Sent</a>
                    </li>
                    <li>
                        <a href="{{route('email.draft', ['RolePrefix' => RolePrefix()])}}">Drafts</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#clients_bar" data-toggle="collapse">
                <i data-feather="shopping-cart"></i>
                <span> Clients </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="clients_bar">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{route('clients.create', ['RolePrefix' => RolePrefix()])}}">Add Client</a>
                    </li>
                    <li>
                        <a href="{{route('clients.index', ['RolePrefix' => RolePrefix()])}}">All Clients</a>
                    </li>
                    <li>
                        <a href="{{route('sale.history', ['RolePrefix' => RolePrefix()])}}">Sale History</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#banner" data-toggle="collapse">
                <i data-feather="shopping-cart"></i>
                <span> Banner </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="banner">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{route('banner.index', ['RolePrefix' => RolePrefix()])}}">Banner List</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#dealer" data-toggle="collapse">
                <i data-feather="shopping-cart"></i>
                <span> Dealer </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="dealer">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{route('dealer.index', ['RolePrefix' => RolePrefix()])}}">Dealer List</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#more" data-toggle="collapse">
                <i data-feather="shopping-cart"></i>
                <span> More </span>
                <span class="menu-arrow"></span>
            </a>
            <div class="collapse" id="more">
                <ul class="nav-second-level">
                    <li>
                        <a href="{{route('about.index', ['RolePrefix' => RolePrefix()])}}">About</a>
                    </li>
                    <li>
                        <a href="{{route('faq.index', ['RolePrefix' => RolePrefix()])}}">FAQs</a>
                    </li>
                    <li>
                        <a href="{{route('privacy_policy.index', ['RolePrefix' => RolePrefix()])}}">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="{{route('term.index', ['RolePrefix' => RolePrefix()])}}">Terms</a>
                    </li>
                </ul>
            </div>
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