<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header text-center">

                <div class="profile-element px-0 mt-1">
                    <span class="text-white text-uppercase font-bold ">NBC TEST</span>
                </div>
            </li>
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ route('home') }}"><i class="fa fa-th-large"></i> <span
                        class="nav-label">Dashboard</span></a>
            </li>

            <li class="{{ request()->is('ripoti') ? 'active' : '' }}">
                <a href="{{ route('ripoti_b.index') }}"><i class="fa fa-th-large"></i> <span
                        class="nav-label">B Transaction</span></a>
            </li>

            <li class="{{ request()->is('ripoti') ? 'active' : '' }}">
                <a href="{{ route('ripoti_partnership.index') }}"><i class="fa fa-th-large"></i> <span
                        class="nav-label">Partners Transaction</span></a>
            </li>

        </ul>
    </div>
</nav>
