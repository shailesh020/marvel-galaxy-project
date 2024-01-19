<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon">
            {{Config::get('app.name')}}
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{activePage('home')}}">
        <a class="nav-link" href="{{route('home')}}">
            <span>DASHBOARD</span>
        </a>
    </li>
    <!-- Nav Item -  CLIENT -->
    <li class="nav-item {{activePage('clients.index')}}">
        <a class="nav-link" href="{{route('clients.index')}}">
            <span>CLIENT</span>
        </a>
    </li>
    <!-- Nav Item -  ENGINEER -->
    <li class="nav-item {{activePage('engineers.index')}}">
        <a class="nav-link" href="{{route('engineers.index')}}">
            <span>ENGINEER</span>
        </a>
    </li>
    <!-- Nav Item -  PURCHASE HISTORY-->
    <li class="nav-item {{activePage('purchase.index')}}">
        <a class="nav-link" href="{{route('purchase.index')}}">
            <span>PURCHASE HISTORY</span>
        </a>
    </li>
    <!-- Nav Item -  COMPLAINT -->
    <li class="nav-item {{activePage('complaint.index')}}">
        <a class="nav-link" href="{{route('complaint.index')}}">
            <span> COMPLAINT</span>
        </a>
    </li>
     <!-- Nav Item -  MASTER -->
     <li class="nav-item {{activePage('machine.index')}}{{activePage('client-group.index')}}{{activePage('notification.index')}}{{activePage('location.index')}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <span>MASTER</span>
        </a>
        <div id="collapseTwo" class="collapse {{collapseMenu('machine.index')}}{{collapseMenu('client-group.index')}}{{collapseMenu('notification.index')}}{{collapseMenu('location.index')}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management</h6>
                    <a class="collapse-item {{activePage('machine.index')}}" href="{{route('machine.index')}}">MACHINE</a>
                    <a class="collapse-item {{activePage('client-group.index')}}" href="{{route('client-group.index')}}">CLIENT GROUP</a>
                    <a class="collapse-item {{activePage('notification.index')}}" href="{{route('notification.index')}}">NOTIFICATION</a>
                    <a class="collapse-item {{activePage('location.index')}}" href="{{route('location.index')}}">ENGINEER LOCATION</a>
            </div>
        </div>
    </li>
    <!-- Nav Item -  ENGINEER -->
    {{-- <li class="nav-item {{activePage('machine.index')}}">
        <a class="nav-link" href="{{route('machine.index')}}">
            <span></span>
        </a>
    </li>
    <!-- Nav Item -  CLIENT GROUP-->
    <li class="nav-item {{activePage('client-group.index')}}">
        <a class="nav-link" href="{{route('client-group.index')}}">
            <span></span>
        </a>
    </li>
    <!-- Nav Item -  NOTIFICATION-->
    <li class="nav-item {{activePage('notification.index')}}">
        <a class="nav-link" href="{{route('notification.index')}}">
            <span></span>
        </a>
    </li>
    <!-- Nav Item -  ENGINEER LOCATION -->
    <li class="nav-item {{activePage('home')}}">
        <a class="nav-link" href="{{route('home')}}">
            <span> </span>
        </a>
    </li> --}}

    {{-- <!-- Nav Item -  COMPLAINT -->
    <li class="nav-item {{activePage('home')}}">
        <a class="nav-link" href="{{route('home')}}">
            <span> COMPLAINT</span>
        </a>
    </li>
    <!-- Nav Item -  REPORT -->
    <li class="nav-item {{activePage('home')}}">
        <a class="nav-link" href="{{route('home')}}">
            <span> REPORT</span>
        </a>
    </li>
    <!-- Nav Item -  ENGINEER LOCATION -->
    <li class="nav-item {{activePage('home')}}">
        <a class="nav-link" href="{{route('home')}}">
            <span> ENGINEER LOCATION</span>
        </a>
    </li>
    <!-- Nav Item -  MASTER -->
    <li class="nav-item {{activePage('users.index')}}{{activePage('roles.index')}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <span>MASTER</span>
        </a>
        <div id="collapseTwo" class="collapse {{collapseMenu('users.index')}}{{collapseMenu('roles.index')}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management</h6>
                @can('user-list')
                    <a class="collapse-item {{activePage('users.index')}}" href="{{route('users.index')}}">Users</a>
                @endcan
                @can('role-list')
                    <a class="collapse-item {{activePage('roles.index')}}" href="{{route('roles.index')}}">Roles</a>
                @endcan
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    @canany(['user-list','role-list'])
        <li class="nav-item {{activePage('users.index')}}{{activePage('roles.index')}}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <span>Users</span>
            </a>
            <div id="collapseTwo" class="collapse {{collapseMenu('users.index')}}{{collapseMenu('roles.index')}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">User Management</h6>
                    @can('user-list')
                        <a class="collapse-item {{activePage('users.index')}}" href="{{route('users.index')}}">Users</a>
                    @endcan
                    @can('role-list')
                        <a class="collapse-item {{activePage('roles.index')}}" href="{{route('roles.index')}}">Roles</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcanany --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
