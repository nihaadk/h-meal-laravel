<nav >
  <div class="nav-wrapper purple darken-4">
    <a href="#" class="brand-logo">
      <!-- <img src="../../../img/logo_white.png" class="logo_header_size_min"> -->
      <div class="deep-purple lighten-1" style="padding: 15px 30px; margin: 15px 15px;"><large>{{ Auth::user()->name }}</large></div>
    </a>
    <ul class="right hide-on-med-and-down">
      @can('admin')
        <li>
          <a  href="/app/user/list">Admin<i class="fa fa-lock material-icons right"></i></a>
        </li>
      @endcan
      <li>
        <a  href="/app">Comments<i class="material-icons right">comment</i></a>
      </li>
      <li>
        <a  href="/app/patient/list">Patients<i class="material-icons right">perm_contact_calendar</i></a>
      </li>

      <li>
        <a href="/app/food/list" >Nutrients<i class="fa fa-cutlery material-icons right"></i></a>
      </li>

      <li>
        <a href="/app/chart/index">Charts<i class="fa fa-area-chart material-icons right"></i></a>
      </li>

      <li>
        <a href="/auth/logout">Logout<i class="fa fa-sign-out material-icons right" ></i></a>
      </li>
  </div>
</nav>
