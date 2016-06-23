<ul id="dropdown1" class="dropdown-content purple-text">
   <li><a href="#!">Help</a></li>
  <li class="divider"></li>
  <li><a href="/auth/logout">Logout</a></li>
</ul>

<nav >
  <div class="nav-wrapper purple darken-4">
    <a href="/app" class="brand-logo">
      <img src="../../../img/logo_white.png" class="logo_header_size_min">
    </a>
    <ul class="right hide-on-med-and-down">
      @can('admin')
        <li>
          <a  href="/app/user/list">Admin<i class="fa fa-lock material-icons right"></i></a>
        </li>
      @endcan
      <li>
        <a  href="/app/patient/list">Bolniki<i class="material-icons right">perm_contact_calendar</i></a>
      </li>

      <li>
        <a href="/app/food/list" >Hranilne snovi<i class="fa fa-cutlery material-icons right"></i></a>
      </li>

      <li>
        <a href="/app/chart/index">Prikaz grafov<i class="fa fa-area-chart material-icons right"></i></a>
      </li>

      <li>
        <a class="dropdown-button" href="#" data-activates="dropdown1">{{ Auth::user()->name }}<i class="material-icons right">perm_identity</i></a>
      </li>
    </ul>
  </div>
</nav>
