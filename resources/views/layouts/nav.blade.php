

<!-- nav -->
<nav class="mb-6 px-4 py-2 bg-yellow-600  dark:bg-gray-800 text-gray-900 dark:text-gray-800 rounded-md shadow-lg"  >
<div class="flex flex-wrap items-center justify-between " >
    <div class="flex items-center justify-center ">
    <div class="flex items-center justify-center text-3xl font-bold text-true-gray-800 dark:text-gray-100">
    <img src="https://obologistic.com/wp-content/uploads/2021/09/obo-logistic-LOGO-variaciones-de-color-16-2-e1707318780684.png" alt="Logo" class="h-16 mr-2">
</div>

<div class="flex flex-wrap items-center justify-center antialiased ml-10 pt-1">
    <div class="sm:flex">
    <x-nav-link href="{{ route('/') }}" :active="request()->routeIs('/')"
            class="font-semibold text-xl px-4 py-2 mx-2 sm:mx-10 {{ request()->routeIs('/') ? 'text-blue-600' : 'text-gray-600' }}">
    {{ __('Inicio') }}
</x-nav-link>

    </div>

    <div class="sm:flex">
        <x-nav-link href="#services" :active="request()->routeIs('/')"
                    class="text-xl font-bold px-4 py-2 mx-2 sm:mx-10 {{ request()->routeIs('/') ? 'text-blue-600' : 'text-gray-600' }}">
            {{ __('Servicios') }}
        </x-nav-link>
    </div>

    <div class="sm:flex">
        <x-nav-link href="{{ route('/') }}" :active="request()->routeIs('/')"
                    class="text-xl font-bold px-4 py-2 mx-2 sm:mx-10  'text-blue-600' : 'text-gray-600' }}">
            {{ __('Rastreo') }}
        </x-nav-link>
    </div>
</div>

    </div>
    <div class="w-1/2 mx-auto " >

</form>

</div>
    @if(Route::has('login'))
        <div class=" flex items-center justify-center ">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" class="text-xl font-bold  "
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                      @else
                     <a href="{{ route('login') }}"
                           class="mr-5 text-lg font-medium dark:text-gray-100 text-true-gray-800 hover:text-cool-gray-700 transition duration-150 ease-in-out">Login</a>

                           @if(Route::has('register'))
                          <a
                        href="{{ route('register') }}"
                        class="px-6 py-3 rounded-3xl font-medium bg-gradient-to-b from-gray-900 to-black text-white outline-none focus:outline-none hover:shadow-md hover:from-true-gray-900 transition duration-200 ease-in-out">
                        Regístrese
                         </a>
                            @endif
               @endauth
                <!-- Selector de tema oscuro -->

        </div>
    @endif
</div>
</nav>
<!-- /nav -->
