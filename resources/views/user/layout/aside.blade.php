<<<<<<< HEAD
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">
                <img alt="image" src="{{ asset('assets/img/logo.png') }}" class="header-logo" style="height:150px !important;margin-top: -20px !important;" />
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown">
                <a href="{{route('dashboard', ['RolePrefix' => RolePrefix()])}}" class="nav-link"><i class="fa-solid fa-tv"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">User Management</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i class="fa-sharp fa-solid fa-house-chimney"></i><span>Leads</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">Add New</a></li>
                    <li><a class="nav-link" href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">All (40)</a></li>
                    <li><a class="nav-link" href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">Closed (10)</a></li>
                    <li><a class="nav-link" href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">Matured (10)</a></li>
                    <li><a class="nav-link" href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">Bulk Import</a></li>
                    <li><a class="nav-link" href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">Bulk Export</a></li>
                    <li><a class="nav-link" href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">Employee Report</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
=======
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
                                      <a href="{{route('leads.index', ['RolePrefix' => RolePrefix()])}}">All Lead</a>
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
>>>>>>> 11b5463d7b2c3aa720aa0cca1591679795e6cc6b
