
    @include('backend.partials.header')
    @include('backend.partials.topbar')
    @include('backend.partials.sidebar')
    
    <main role="main" class="main-content">
    @yield('content')
    </main>

    @include('backend.partials.endbody')

