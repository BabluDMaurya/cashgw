<html lang="en">
    <head>
        @include('includes.head')
    </head>
    <body>    
        <a href="#" id="scroll" style="display: none;"><i class="fas fa-angle-up"></i></a>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            @include('includes.admindashboardmenu')
        </nav>
        <div class="grey-bg">
            @include('includes.userdashboardbreadcrumb')
            <!-- Tabs -->
            @yield('content')
            <!-- ./Tabs -->
        </div>
        <!-- Main Footer -->
        @include('includes.userdashboardfooter')
        <!-- Main Footer -->  
        @include('includes.footerscript')
        <script>
            window.FontAwesomeConfig = {
                searchPseudoElements: true
            } 
        </script>      
    </body>
</html>