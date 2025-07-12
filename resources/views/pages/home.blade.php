@include('partials.head')
<body class="bg-[var(--color-background-primary)] ">
    <header>
        @section('header')
        @include('partials.navbar')
        @show
    </header>

    <script>
        AOS.init({
            duration: 800, // Durasi animasi (ms)
            once: false // Animasi satu kali
        });

    </script>

    <main>
        <!-- component -->
        <div class="relative min-h-screen overflow-hidden bg-[var(--color-background-primary)]">
            <div class="absolute top-[5%] left-[0%] w-96 h-96 bg-[var(--blob-color-1)] blur-3xl opacity-50 rounded-full mix-blend-screen -translate-x-1/2 -translate-y-1/2 md:w-[30rem] md:h-[30rem] lg:w-[40rem] lg:h-[40rem]"></div>

            <div class="absolute top-[-10%] right-[-10%] w-[30rem] h-[30rem] bg-[var(--blob-color-3)] blur-3xl opacity-50 rounded-full mix-blend-screen md:w-[35rem] md:h-[35rem] lg:w-[45rem] lg:h-[45rem]"></div>

            <div class="absolute top-[10%] right-[-10%] w-[35rem] h-[35rem] bg-[var(--blob-color-2)] blur-3xl opacity-50 rounded-full mix-blend-screen md:w-[40rem] md:h-[40rem] lg:w-[50rem] lg:h-[50rem]"></div>

            <section class="">
                @include('pages.homesection.hero')
            </section>

            <section class="">
                @include('pages.homesection.product')
            </section>


            <section class="">
                @include('pages.homesection.testimony')
            </section>

            <section class="">
                @include('pages.homesection.location')
            </section>

            {{-- <section class="top-0 flex flex-col bg-gray-100 ">
                @include('section.partners-section')
            </section>

            <section class="top-0 min-h-screen flex flex-col">
                @include('section.testimonial-section')
            </section>

            <section id="faq" class="top-0 flex flex-col scroll-mt-15">
                @include('section.faq-section')
            </section> --}}
            {{-- <div class="sticky top-0 h-screen flex flex-col items-center justify-center bg-neutral-800 text-white">--}}
            {{-- <h2 class="text-4xl">The Fourth Title</h2>--}}
            {{-- </div>--}}
        </div>
    </main>

    <footer>
        @section('footer')
        @include('partials.footer')
        @show
    </footer>

</body>
</html>
