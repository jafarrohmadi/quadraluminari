<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            @can('dashboard')
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @endcan
            @can('active_client_view')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.active-client.index") }}">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        Active Client
                    </a>
                </li>
            @endcan

            @can('active_opportunity_view')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.active-opportunity.index") }}">
                        <i class="fa-fw fas fa-tasks nav-icon">

                        </i>
                        Active Opportunity
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.active-opportunity-reminder.index") }}">
                        <i class="fa-fw fas fa-tasks nav-icon">

                        </i>
                        Active Opportunity Reminder
                    </a>
                </li>
            @endcan

            @can('user_management_view')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.users.index") }}">
                        <i class="fa-fw fas fa-users nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                </li>
            @endcan

            <li class="nav-item">
                <a href="#" class="nav-link"
                   onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
