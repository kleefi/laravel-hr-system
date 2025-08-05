<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">

            <li>
                <a href="{{ route('admin.dashboard.index') }}"
                    @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group' , 'bg-gray-200'=>
                    request()->is('admin/dashboard')
                    ])>
                    <i class="fa-solid fa-chart-pie w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.employees.index') }}"
                    @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group' , 'bg-gray-200'=>
                    request()->is('admin/employees*')
                    ])>
                    <i class="fa-solid fa-users w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Employees</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.leave-requests.index') }}"
                    @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group' , 'bg-gray-200'=>
                    request()->is('admin/leave-requests*')
                    ])>
                    <i class="fa-solid fa-file-lines w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Leave Requests</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.approvals.index') }}"
                    @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group' , 'bg-gray-200'=>
                    request()->is('admin/approvals*')
                    ])>
                    <i class="fa-solid fa-circle-check w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Approvals</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.export.index') }}"
                    @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group' , 'bg-gray-200'=>
                    request()->is('admin/export*')
                    ])>
                    <i class="fa-solid fa-file-export w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Export</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.notifications.index') }}"
                    @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group' , 'bg-gray-200'=>
                    request()->is('admin/notifications*')
                    ])>
                    <i class="fa-solid fa-bell w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Notifications</span>
                </a>
            </li>

            <li>
                <a href="{{ route('setting.edit') }}"
                    @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group' , 'bg-gray-200'=>
                    request()->is('settings*')
                    ])>
                    <i class="fa-solid fa-gear w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Account Settings</span>
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <i class="fa-solid fa-right-from-bracket w-5 h-5 text-gray-500"></i>
                        <span class="ms-3">Logout</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</aside>