<div class="sidebar-content">
  <ul class="nav nav-primary">
    <li class="nav-item {{ in_array('home', $activeMenu)?'active':'' }}">
      <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> <p>Dashboard</p>
      </a>
    </li>
    <li class="nav-section {{ in_array('logs', $activeMenu)?'active':'' }}">
      <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
      <h4 class="text-section">LOG</h4>
    </li>
    <li class="nav-item submenu {{ in_array('log:presence', $activeMenu)?'active':'' }}">
      <a href="{{ route('logs.presence') }}"><i class="fas fa-list-alt"></i><p>Presensi</p></a>
    </li>
    <li class="nav-section {{ in_array('setup', $activeMenu)?'active':'' }}">
      <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
      <h4 class="text-section">Setup</h4>
    </li>
    <li class="nav-item submenu {{ in_array('machine', $activeMenu)?'active':'' }}">
      <a href="{{ route('setup.machine') }}"><i class="fas fa-desktop"></i><p>Mesin FingerPrint</p></a>
    </li>
    {{--<li class="nav-item submenu">
      <a data-toggle="collapse" href="#base">
        <i class="fas fa-layer-group"></i>
        <p>Base</p>
        <span class="caret"></span>
      </a>
      <div class="collapse show" id="base">
        <ul class="nav nav-collapse">
          <li>
            <a href="../components/avatars.html">
              <span class="sub-item">Avatars</span>
            </a>
          </li>
        </ul>
      </div>
    </li>--}}
  </ul>
</div>
