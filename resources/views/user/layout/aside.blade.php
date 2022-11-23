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