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
                                <a href="{{route('building_extra_detail', ['RolePrefix' => RolePrefix()])}}">Building Extra Detail</a>
                                <a href="#building_feature" data-toggle="collapse">
                                    <i data-feather="shopping-cart"></i>
                                    <span> Building Features </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="building_feature">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'plot'])}}">Plot Features</a>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'communication'])}}">Communication Features</a>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'community'])}}">Community Features</a>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'health'])}}">Health Features</a>
                                            <a href="{{route('feature.index', ['RolePrefix' => RolePrefix(),'key'=> 'other'])}}">Other Features</a>
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
                    <a href="#society" data-toggle="collapse">
                        <i data-feather="shopping-cart"></i>
                        <span> Society </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="society">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('society.create', ['RolePrefix' => RolePrefix()])}}">Add Society</a>
                            </li>
                            <li>
                                <a href="{{route('society.index', ['RolePrefix' => RolePrefix()])}}">All Society</a>
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
                            <li><a href="{{route('unit.index', ['RolePrefix' => RolePrefix()])}}">Unit</a></li>
                            <li><a href="{{route('size.index', ['RolePrefix' => RolePrefix()])}}">Size</a></li>
                            <li><a href="{{route('type.index', ['RolePrefix' => RolePrefix()])}}">Type</a></li>
                            <li><a href="{{route('category.index', ['RolePrefix' => RolePrefix()])}}">Category</a></li>
                            <li><a href="{{route('payment_plan.index', ['RolePrefix' => RolePrefix()])}}">Payment Plan</a></li>
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
                            <li><a href="{{route('target.staff_targets', ['RolePrefix' => RolePrefix()])}}">Staff Targets</a></li>
                            <li><a href="{{route('target.task_reports', ['RolePrefix' => RolePrefix()])}}">Reports</a></li>
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
                        <a href="{{route('lead.employee', ['RolePrefix' => RolePrefix()])}}">Employee Reports</a>
                    </li>
                    <li>
                        <a href="{{route('lead.refer', ['RolePrefix' => RolePrefix()])}}">Refer Leads</a>
                    </li>
                    <li>
                        <a href="{{route('lead.bulk_import.view', ['RolePrefix' => RolePrefix()])}}">Bulk Import</a>
                    </li>
                    <li>
                        <a href="{{route('lead.bulk_export', ['RolePrefix' => RolePrefix()])}}">Bulk Export</a>
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
