<!--start sidebar -->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('assets/img/logo/stay-smart.png')}}" class="logo-icon" alt="logo icon" style="width: 60px;">
        </div>
        <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="{{$activePage == '' ? 'mm-active' : ''}}">
            <a href="/home">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li class="{{$activePage == 'Check In' ? 'mm-active' : ''}}">
            <a href="{{route('apartments.checkIn')}}">
                <div class="parent-icon"><i class="bi bi-printer"></i></i>
                </div>
                <div class="menu-title">Check In</div>
            </a>
        </li>
        <li class="{{$activePage == 'My Bookings' ? 'mm-active' : ''}}">
            <a href="{{route('booking.mine')}}">
                <div class="parent-icon"><i class="bi bi-calendar2-check-fill"></i>
                </div>
                <div class="menu-title">My Bookings</div>
            </a>
        </li>
        <li class="{{$activePage == 'Apartments' ? 'mm-active' : ''}}">
            <a href="{{route('apartments.index')}}">
                <div class="parent-icon"><i class="bi bi-wrench-adjustable-circle-fill"></i>
                </div>
                <div class="menu-title">Apartments</div>
            </a>
        </li>
        <li class="{{$activePage == 'Payments' ? 'mm-active' : ''}}">
            <a href="{{route('payment.index')}}">
                <div class="parent-icon"><i class="bi bi-wallet2"></i>
                </div>
                <div class="menu-title">Payments</div>
            </a>
        </li>
        <li class="{{$activePage == '' ? 'mm-active' : ''}}">
            <a href="#">
                <div class="parent-icon"><i class="bi bi-headset"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
        </li>
        @can("access all records")
        <li class="{{$activePage == '' ? 'mm-active' : ''}}" class="menu-label">Property Management</li>
        <li class="{{$activePage == 'Add Apartment' ? 'mm-active' : ''}}">
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-house-heart-fill"></i>
                </div>
                <div class="menu-title">Apartments</div>
            </a>
            <ul>
                <li> <a href="#"><i class="bi bi-circle"></i>Amenities</a>
                </li>
                <li>
                    <a href="{{route('apartments.create')}}"><i class="bi bi-circle"></i>Add Apartment</a>
                </li>
                <li>
                    <a href="{{route('apartments.all')}}"><i class="bi bi-circle"></i>All Apartments</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">

                <div class="parent-icon"><i class="bi bi-egg-fried"></i>
                </div>
                <div class="menu-title">Chefs</div>
            </a>
            <ul>
                <li> <a href="#"><i class="bi bi-circle"></i>Add Chef</a>
                </li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:;">

                <div class="parent-icon"><i class="bi bi-car-front-fill"></i>
                </div>
                <div class="menu-title">Drivers</div>
            </a>
            <ul>
                <li> <a href="#"><i class="bi bi-circle"></i>Add Driver</a>
                </li>
            </ul>
        </li>
        @endif
        <li class="menu-label">Settings</li>
        @can("access all records")
        <li>
            <a class="has-arrow" href="javascript:;">

                <div class="parent-icon"><i class="bi bi-body-text"></i>
                </div>
                <div class="menu-title">Roles & Permissions</div>
            </a>
            <ul>
                <li>
                    <a href="{{route('roles.index')}}"><i class="bi bi-circle"></i>Roles</a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="{{route('permissions.index')}}"><i class="bi bi-circle"></i>Permissions</a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="{{route('role-assignment.index')}}"><i class="bi bi-circle"></i>Assign Roles</a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="{{route('permission-assignment.index')}}"><i class="bi bi-circle"></i>Assign Permissions</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#">
                <div class="parent-icon"><i class="bi bi-file-bar-graph-fill"></i>
                </div>
                <div class="menu-title">Reports</div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="parent-icon"><i class="bi bi-file-break-fill"></i>
                </div>
                <div class="menu-title">Tickets</div>
            </a>
        </li>
        @endif
        <li class="{{$activePage == 'Profile' ? 'mm-active' : ''}}">
            <a href="{{route('profile.index')}}">
                <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                </div>
                <div class="menu-title">Profile</div>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <div class="parent-icon">
                    <i class="bi bi-lock"></i>
                </div>
                <div class="menu-title">Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
    <!--end navigation-->
</aside>
<!--end sidebar -->
