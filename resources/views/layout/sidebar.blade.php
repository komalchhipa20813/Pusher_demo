<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <img src="{{ url('images/logo.jpg') }}" alt="Logo" style="width :100px;">

        </a>
        <div class=" sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ active_class(['/', 'dashboard']) }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item nav-category">Module</li>
                <li class="nav-item {{ active_class(['notification']) }} ">
                    <a href="{{ route('notification.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="info"></i>
                        <span class="link-title">Notification</span>
                    </a>
                </li>            
        </ul>
    </div>
</nav>

