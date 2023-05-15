    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
    <div class="sidebar-section sidebar-user my-1">
            <div class="sidebar-section-body">
                <div class="media">
                    <div class="media-body text-center">
                        <div class="navbar-brand text-center text-lg-left">
                            <a href="" class="d-inline-block">
                                <img src="{{asset('/')}}assets/img/logo.png" class="d-none d-sm-block new"
                                    alt="" width="150px" style=" border-radius: 14px;">
                            </a>
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <button type="button"
                            class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                            <i class="icon-cross2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <ul class="sidebar-nav pt-4" id="sidebar-nav">
            {{-- <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard*') ? 'active' : 'collapsed' }}" href="{{route('admin.dashboard')}}">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link collapsed {{ (request()->is('category*')) ? 'active' : '' }}" href="{{ route('category.index') }}" >
                    <i class="bi bi-bezier"></i><span>Category</span>
                </a>
            </li> --}}
            
            <li class="nav-item">
                <a class="nav-link   {{ request()->is('user*') ? 'active' : 'collapsed' }}" href="{{route('user.index')}}">
                    <i class="bi bi-diagram-2"></i><span>User</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link   {{ request()->is('blog*') ? 'active' : 'collapsed' }}" href="{{route('blog.index')}}">
                    <i class="bi bi-diagram-2"></i><span>Blogs</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('term-condition*') ? 'active' : 'collapsed' }}" href="{{route('term-condition.index')}}">
                    <i class="bi bi-building"></i>
                    <span>Terms of use</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('about-us*') ? 'active' : 'collapsed' }}" href="{{route('about-us.index')}}">
                    <i class="bi bi-building"></i>
                    <span>About Us</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('privacy-policy*') ? 'active' : 'collapsed' }}" href="{{route('privacy-policy.index')}}">
                    <i class="bi bi-building"></i>
                    <span>Privacy Policy</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('change-password*') ? 'active' : 'collapsed' }}" href="{{route('change-password')}}">
                    <i class="bi bi-building"></i>
                    <span>Setting</span>
                </a>
            </li>

        </ul>

    </aside>
    <!-- End Sidebar-->