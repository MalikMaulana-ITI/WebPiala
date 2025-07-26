<nav class="bg-transparent text-white fixed w-full z-20 top-0 start-0 md:mt-7 ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{asset('storage/images/logo.png')}}" class="h-8" alt="Mazayatrophy19" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap ">Mazayatrophy19.com</span>
        </a>
        <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200   " aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border rounded-lg  md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 ">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'block py-2 px-3 text-white bg-white rounded-sm md:bg-transparent md:text-green-300 md:p-0 md:  md:' : 'block py-2 px-3 text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-300 md:p-0  md:   md:' }}" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="{{ route('catalog') }}" class="{{ request()->is('catalog') || request()->is('catalog/*') ? 'block py-2 px-3 text-white bg-white rounded-sm md:bg-transparent md:text-green-300 md:p-0 md:  md:' : 'block py-2 px-3 text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-300 md:p-0  md:   md:' }}">Catalog</a>
                </li>
                <li>
                    <a href="{{ route('aboutus') }}" class="{{ request()->is('about-us') ? 'block py-2 px-3 text-white bg-white rounded-sm md:bg-transparent md:text-green-300 md:p-0 md:  md:' : 'block py-2 px-3 text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-300 md:p-0  md:   md:' }}">About Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
