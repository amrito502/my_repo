<nav class="navbar">
    <div class="col-12">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="BrandLogo" href="{{ route('dashboard') }}">
                <img src="{{url ('assets/images/logo.png')}}" width="30" alt="">
                <span class="brandName">UMMUN Model Academy</span>
            </a>

        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                role="button">
                    <span class="userProfile small"><i class="fa fa-user"></i></span>
                    <span class="userName">{{ Auth::user()->name }}</span>
                </a>
            <ul class="dropdown-menu slideDown">
                <li class="header">Profile</li>
                <div class="body text-center py-3">
                    <p class="userProfile" style="color: #979797;">
                        <i class="fa fa-user fa-4x"></i>
                    </p>
                    <p>{{ Auth::user()->name }}</p>
                    <p><i class="fa fa-envelope mr-1"></i> {{ Auth::user()->email }}</p>

                </div>
                <div class="footer text-center py-3">
                    <a href="{{ route('user-logout') }}" class="mega-menu" data-close="true">
                        <i class="fa fa-power-off"></i> Logout</a>
                </div>
            </ul>
        </li>

            {{-- <li>
                <i class="fa fa-user"></i>
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="email">{{ Auth::user()->email }}</div>
            </li>
            <li><a href="{{ route('user-logout') }}" class="mega-menu" data-close="true">
                <i class="zmdi zmdi-power"></i> Logout</a></li> --}}
        </ul>
    </div>
</nav>
