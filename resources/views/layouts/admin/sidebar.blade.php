 <aside id="sidebar"
     class="fixed top-0 left-0 h-full w-64 bg-white border-r border-gray-200 z-40
               transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">
     <div class="h-16 flex items-center px-6 border-b border-gray-100">
         <span class="text-lg font-bold text-indigo-600 tracking-tight">Kelas Online</span>
     </div>

     <nav class="p-4 space-y-1">
         <a href="{{ route('dashboard') }}"
             class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                       {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
             <i class="bi bi-speedometer"></i> Dashboard
         </a>

         @if (auth()->user()->role === 'admin')
             <a href="{{ route('users.index') }}"
                 class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                           {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                 <i class="bi bi-people"></i> User Settings
             </a>
             <a href="{{ route('video-categories.index') }}"
                 class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                           {{ request()->routeIs('video-categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                 <i class="bi bi-camera-video"></i> Video Categories
             </a>
             <a href="{{ route('videos.index') }}"
                 class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                           {{ request()->routeIs('videos.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                 <i class="bi bi-play-circle"></i> Videos
             </a>
             <a href="{{ route('video-requests.index') }}"
                 class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                           {{ request()->routeIs('video-requests.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100' }}">
                 <i class="bi bi-inbox"></i> Video Requests
             </a>
         @endif
     </nav>

     <div class="absolute bottom-0 w-full p-4 border-t border-gray-100">
         <form method="POST" action="{{ route('logout') }}">
             @csrf
             <button type="submit"
                 class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 cursor-pointer">
                 <i class="bi bi-box-arrow-right"></i> Logout
             </button>
         </form>
     </div>
 </aside>
