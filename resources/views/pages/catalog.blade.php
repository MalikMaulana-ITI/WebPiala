@include('partials.head')

<body class="bg-white">
    <header>
        @section('header')
        @include('partials.navbarCatalog')
        @show
    </header>

    @livewire('catalog-page')

    <footer class="">
        @section('footer')
        @include('partials.footerCatalog')
        @show
    </footer>
</body>
</html>
