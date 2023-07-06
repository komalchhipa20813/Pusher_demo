
<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <form class="search-form">
            <div class="input-group">
                <div class="input-group-text">
                    <i data-feather="search"></i>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
            </div>
        </form>
        <ul class="navbar-nav">



        <li class="nav-item dropdown">
            <a class="nav-link  dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i data-feather="bell"></i>
            <span class="bell-notify">
            @if(headerData()['count'] != 0)
            <div class="indicator">
                <div class="circle">1</div>
            </div>
            @endif
        </span>
            </a>
            <div class="dropdown-menu p-0 main-pusher-data" aria-labelledby="notificationDropdown">
            @if(headerData()['notifictions'])
                        {!! headerData()['notifictions']!!}
             @endif
            
            </div> 
        </li>
            <li class="nav-item dropdown">
            <div class="pusher-itme"></div>
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(empty(Auth::user()->image))
                    <img src="{{ asset('images/admin_logo.png') }}" alt="Profile" class="wd-30 ht-30 rounded-circle">
                    @else
                    <img src="{{ asset('uploads/images/'. Auth::user()->image) }}" alt="Profile"
                        class="wd-30 ht-30 rounded-circle">
                    @endif

                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            @if(empty(Auth::user()->image))
                            <img src="{{ asset('images/admin_logo.png') }}" alt="Profile"
                                class="wd-80 ht-80 rounded-circle">
                            @else
                            <img src="{{ asset('uploads/images/'. Auth::user()->image) }}" alt="Profile"
                                class="wd-80 ht-80 rounded-circle">
                            @endif

                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">
                                {{ ucwords(Auth::user()->first_name.' '. Auth::user()->last_name )}}</p>
                            <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href="" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="repeat"></i>
                                <span>Change Password</span>
                            </a>
                        </li>
                       
                        <li class="dropdown-item py-2">
                            <a href="{{route('logout')}}" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>