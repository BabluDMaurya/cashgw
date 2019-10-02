<html lang="en">
    <head>
        @include('includes.head')
    </head>
    <body>    
        <div class="grey-bg">
            <!-- Tabs -->
            @yield('content')
            <!-- ./Tabs -->
        </div>
        @include('includes.footerscript')           
    </body>
</html>