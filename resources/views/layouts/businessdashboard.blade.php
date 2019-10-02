<html lang="en">
    <head>
        @include('includes.head')
    </head>
    <body>    
        <a href="#" id="scroll" style="display: none;"><i class="fas fa-angle-up"></i></a>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            @include('includes.businessdashboardmenu')
        </nav>
        <div class="grey-bg">
            @include('includes.businessdashboardbreadcrumb')
            <!-- Tabs -->
            @yield('content')
            <!-- ./Tabs -->
        </div>
        <!-- Main Footer -->
        @include('includes.businessdashboardfooter')
        <!-- Main Footer -->  
        @include('includes.footerscript')
        <script>
            window.FontAwesomeConfig = {
                searchPseudoElements: true
            } 
        </script>      
    </body>
</html>