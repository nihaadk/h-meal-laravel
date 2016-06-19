<!DOCTYPE html>
<html>
    <head>
      @include('includes.head')
    </head>
    <body>
        <div class="wrapper">

          @if(Auth::check())
            <header class="main-header">
              @include('includes.nav')
            </header> 
          @endif
          
              @yield('welcome')

              @yield('chart')
              @yield('login')
              @yield('user-list')
              @yield('patient')
              @yield('food-list')

              @yield('user-edit')
              @yield('patient-details')

              
              
            
          <!-- 
          @if(Auth::check())
            <footer class="main-footer">
              @include('includes.footer')
            </footer>
          @endif
          -->
            @include('includes.scripts')


        </div>
    </body>
</html>
