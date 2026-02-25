<!--start sidebar -->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('assets/img/logo/stay-smart.png')}}" class="logo-icon" alt="logo icon"
                style="width: 60px;">
        </div>
        <div class="toggle-icon ms-auto"> <i class="bi bi-list"></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li class="{{($activePage ?? '') == '' ? 'mm-active' : ''}}">
            <a href="/home">
                <div class="parent-icon"><i class="bi bi-house-fill"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        @unless(auth()->user()->hasRole('Cleaner'))
            <li class="{{($activePage ?? '') == 'Check In' ? 'mm-active' : ''}}">
                <a href="{{route('properties.checkIn')}}">
                    <div class="parent-icon"><i class="bi bi-printer"></i></i>
                    </div>
                    <div class="menu-title">Check In</div>
                </a>
            </li>
        @endunless
        @unless(auth()->user()->hasRole('Cleaner'))
            <li class="{{($activePage ?? '') == 'My Bookings' ? 'mm-active' : ''}}">
                <a href="{{route('booking.mine')}}">
                    <div class="parent-icon"><i class="bi bi-calendar2-check-fill"></i>
                    </div>
                    <div class="menu-title">My Bookings</div>
                </a>
            </li>
        @endunless
        @unless(auth()->user()->hasRole('Cleaner'))
            <li class="{{($activePage ?? '') == 'Apartments' ? 'mm-active' : ''}}">
                <a href="{{route('properties.index')}}">
                    <div class="parent-icon"><i class="bi bi-wrench-adjustable-circle-fill"></i>
                    </div>
                    <div class="menu-title">Apartments</div>
                </a>
            </li>
        @endunless
        @unless(auth()->user()->hasRole('Cleaner'))
            <li class="{{($activePage ?? '') == 'Payments' ? 'mm-active' : ''}}">
                <a href="{{route('payment.index')}}">
                    <div class="parent-icon"><i class="bi bi-wallet2"></i>
                    </div>
                    <div class="menu-title">Payments</div>
                </a>
            </li>
        @endunless
        <li class="{{($activePage ?? '') == '' ? 'mm-active' : ''}}">
            <a href="#">
                <div class="parent-icon"><i class="bi bi-headset"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
        </li>
        @if(auth()->user()->can("access all records") || auth()->user()->hasRole('Cleaner') || auth()->user()->hasRole('Admin'))
            <li class="{{($activePage ?? '') == '' ? 'mm-active' : ''}} menu-label">Property Management</li>
            <li class="{{($activePage ?? '') == 'Add Apartment' ? 'mm-active' : ''}}">
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="bi bi-house-heart-fill"></i>
                    </div>
                    <div class="menu-title">Apartments</div>
                </a>
                <ul>
                    <li>
                        <a href="{{route('properties.all')}}"><i class="bi bi-circle"></i>Apartments</a>
                    </li>
                    @if(auth()->user()->hasRole('Super Admin'))
                        <li>
                            <a href="{{route('properties.create')}}"><i class="bi bi-circle"></i>Add Apartment</a>
                        </li>
                        <li> <a href="{{route('property.amenity.index')}}"><i class="bi bi-circle"></i>Amenities</a>
                        </li>
                    @endif
                </ul>
            </li>
            @if(auth()->user()->hasRole('Super Admin'))
                <li>
                    <a class="has-arrow" href="javascript:;">

                        <div class="parent-icon"><i class="bi bi-egg-fried"></i>
                        </div>
                        <div class="menu-title">Chefs</div>
                    </a>
                    <ul>
                        <li> <a href="{{route('chefs.index')}}"><i class="bi bi-circle"></i>Chefs</a>
                        <li> <a href="{{route('chefs.create')}}"><i class="bi bi-circle"></i>Add Chef</a>
                        <li> <a href="{{route('chefs.book')}}"><i class="bi bi-circle"></i>Book Chef</a>
                        <li> <a href="{{route('chef.service.index')}}"><i class="bi bi-circle"></i>Services</a>
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
                        <li> <a href="{{route('drivers.index')}}"><i class="bi bi-circle"></i>Drivers</a>
                        <li> <a href="{{route('drivers.create')}}"><i class="bi bi-circle"></i>Add Driver</a>
                        <li> <a href="{{route('drivers.book')}}"><i class="bi bi-circle"></i>Book Driver</a>
                        <li> <a href="{{route('driver.service.index')}}"><i class="bi bi-circle"></i>Services</a>
                        </li>
                    </ul>
                </li>
            @endif
        @endif

        @if(auth()->user()->hasRole('Super Admin'))
            <li class="menu-label">Content Management</li>
            <li class="{{($activePage ?? '') == 'Blog Management' ? 'mm-active' : ''}}">
                <a href="{{ route('admin.blog.index') }}">
                    <div class="parent-icon"><i class="bi bi-newspaper"></i></div>
                    <div class="menu-title">Blog Posts</div>
                </a>
            </li>
        @endif

        <li class="menu-label">Settings</li>
        @if(auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
            <li>
                <a class="has-arrow" href="javascript:;">

                    <div class="parent-icon"><i class="bi bi-body-text"></i>
                    </div>
                    <div class="menu-title">Roles & Permissions</div>
                </a>
                <ul>
                    {{--@if(auth()->user()->hasRole('Super Admin'))
                    <li>
                        <a href="{{route('roles.index')}}"><i class="bi bi-circle"></i>Roles</a>
                    </li>
                    <li>
                        <a href="{{route('permissions.index')}}"><i class="bi bi-circle"></i>Permissions</a>
                    </li>
                    @endif---}}
                    <li>
                        <a href="{{route('role-assignment.index')}}"><i class="bi bi-circle"></i>Assign Roles</a>
                    </li>
                    <!--<li>
                                <a href="{{route('permission-assignment.index')}}"><i class="bi bi-circle"></i>Assign
                                    Permissions</a>
                            </li>-->
                </ul>
            </li>
            {{-- <li>
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
            </li> --}}
        @endif
        <li class="{{($activePage ?? '') == 'Profile' ? 'mm-active' : ''}}">
            <a href="{{route('profile.index')}}">
                <div class="parent-icon"><i class="bi bi-person-lines-fill"></i>
                </div>
                <div class="menu-title">Profile</div>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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