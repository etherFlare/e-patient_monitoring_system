<div class="user-panel">
  <div class="pull-left image">
    <img src="{{ asset('img/icon002.jpg') }}" class="img-circle" alt="User Image">
  </div>
  <div class="pull-left info">
   
  
    <a href="#"><i class="fa fa-circle text-success"></i> Online?</a>
  </div>
</div>
<ul class="sidebar-menu" data-widget="tree">
  <li class="header">MAIN NAVIGATION</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-dashboard"></i> <span>Observe Patient</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{ route('observe') }}"><i class="fa fa-circle-o"></i>Observe Patient</a></li>
      <li><a href="{{ route('observe') }}"><i class="fa fa-circle-o"></i>Observer list</a></li>
    </ul>
  </li>
  <li>
    <a href="{{ route('user') }}">
      <i class="fa fa-calendar"></i> <span>Accounts</span>
      <span class="pull-right-container">
      </span>
    </a>
  </li>
  <li>
    <a href="{{ route('patient') }}">
      <i class="fa fa-calendar"></i> <span>Patients</span>
    </a>
  </li>
  <li>
    <a href="{{ route('unit') }}">
      <i class="fa  fa-circle-o"></i> <span>Units</span>
    </a>
  </li>
  <li>
    <a href="{{ route('role') }}">
      <i class="fa  fa-circle-o"></i> <span>Role</span>
    </a>
  </li>
  <li>
    <a href="{{ route('metadata') }}">
      <i class="fa fa-file-o"></i> <span>Data</span>
    </a>
  </li>
  <li>
    <a href="{{ route('normal') }}">
      <i class="fa fa-file-o"></i> <span>Normal References</span>
    </a>
  </li>
  <li>
    <a href="{{ route('location') }}">
      <i class="fa fa-file-o"></i> <span>Location</span>
    </a>
  </li>
  <li>
    <a href="{{ route('type') }}">
      <i class="fa fa-file-o"></i> <span>Type</span>
    </a>
  </li>
  <li class="header">LABELS</li>
  <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
  <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
  <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
</ul>
