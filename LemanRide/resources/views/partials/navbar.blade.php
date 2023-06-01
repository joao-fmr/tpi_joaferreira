<header class="bg-gray-300 bg-opacity-80">
    <nav class="navbar text-[#134563]">
        <div class="navbar-left">
            <a href="{{route('home')}}"><img src="{{ asset('img/lemanride-logo.png') }}" alt="Logo du site LemanRide" class="h-20 object-contain"></a>
        </div>
        <div class="navbar-center content-center w-100">
            <ul class="hidden lg:flex justify-center">
                <li class="ml-20"><a href="{{route('home')}}" class="btn btn-ghost normal-case text-xl text-[#134563]">Accueil</a></li>
                <li class="ml-20"><a href="{{route('stations')}}" class="btn btn-ghost normal-case text-xl font-normal">Stations</a></li>
                <li class="ml-20"><a href="{{route('about')}}" class="btn btn-ghost normal-case text-xl font-normal">À propos</a></li>
                <li class="ml-20"><a href="{{route('contact')}}" class="btn btn-ghost normal-case text-xl font-normal">Contact</a></li>
            </ul>   
        </div>

        <div class="navbar-right flex-1 justify-end lg:hidden">
            <div class="dropdown ">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                </label>
                <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-gray-300 bg-opacity-80 rounded-box w-40 origin-top-right right-0">
                    <li><a href="{{route('home')}}" class="btn btn-ghost normal-case text-xl text-[#134563]">Accueil</a></li>
                    <li><a href="{{route('stations')}}" class="btn btn-ghost normal-case text-xl font-normal">Stations</a></li>
                    <li><a href="{{route('about')}}" class="btn btn-ghost normal-case text-xl font-normal">À propos</a></li>
                    <li><a href="{{route('contact')}}" class="btn btn-ghost normal-case text-xl font-normal">Contact</a></li>
                </ul>
            </div> 
        </div>
      
    </nav>
</header>