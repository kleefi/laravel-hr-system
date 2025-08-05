<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">

            {{-- Dashboard --}}
            <li>
                <a href="#" @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group'
                    , 'bg-gray-200'=> request()->is('dashboard')
                    ])>
                    <i class="fa-solid fa-chart-pie w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            {{-- My Profile --}}
            <li>
                <a href="#" @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group'
                    , 'bg-gray-200'=> request()->is('profile')
                    ])>
                    <i class="fa-solid fa-user w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">My Profile</span>
                </a>
            </li>

            {{-- My Leave Requests --}}
            <li>
                <a href="#" @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group'
                    , 'bg-gray-200'=> request()->is('leaves')
                    ])>
                    <i class="fa-solid fa-file-lines w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">My Leave Requests</span>
                </a>
            </li>

            {{-- Apply for Leave --}}
            <li>
                <a href="#" @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group'
                    , 'bg-gray-200'=> request()->is('leaves/apply')
                    ])>
                    <i class="fa-solid fa-circle-plus w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Apply for Leave</span>
                </a>
            </li>

            {{-- Account Settings --}}
            <li>
                <a href="#" @class([ 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group'
                    , 'bg-gray-200'=> request()->is('settings')
                    ])>
                    <i class="fa-solid fa-gear w-5 h-5 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ms-3">Account Settings</span>
                </a>
            </li>

            {{-- Logout --}}
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