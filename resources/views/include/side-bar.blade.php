<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <!-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">{{ __('EPMS') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fa fa-users" aria-hidden="true"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">
                <i class="fa fa-users nav-icon" aria-hidden="true"></i>
                  <p>All User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Roles
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('role.index') }}" class="nav-link">
                <i class="fa fa-lock nav-icon" aria-hidden="true"></i>
                  <p>All Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('role.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Role</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Reports
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('report.index') }}" class="nav-link">
                <i class="fa fa-list-alt nav-icon" aria-hidden="true"></i>
                  <p>All Reports</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('report.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Report</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Fields
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('field.index') }}" class="nav-link">
                <i class="fa fa-star nav-icon" aria-hidden="true"></i>
                  <p>Rating Fields</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('field.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add a Field</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Designation
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('designation.index') }}" class="nav-link">
                <i class="fa fa-address-card nav-icon" aria-hidden="true"></i>
                  <p>User Designations</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('designation.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Designation</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>