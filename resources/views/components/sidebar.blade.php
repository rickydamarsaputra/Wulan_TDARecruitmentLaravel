<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{route('dashoard.index')}}">TDA REQUITMENT</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{route('dashoard.index')}}">TDA</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li><a href="{{route('dashoard.index')}}" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
      <li class="menu-header">Member List</li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-address-card"></i><span>Member</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{route('member.index')}}"><i class="fas fa-users"></i><span>Member List</span></a></li>
          <li><a class="nav-link" href="{{route('member.index')}}"><i class="fas fa-users"></i><span>All Member List</span></a></li>
        </ul>
      </li>
    </ul>

    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Documentation
      </a>
    </div>
  </aside>
</div>