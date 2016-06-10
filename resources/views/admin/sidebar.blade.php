  <div class="site-menubar">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu">
            <li class="site-menu-category">Stats</li>
            <li class="site-menu-item has-sub">
              <a href="{{url('/admin/dashboard')}}">
                <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                <span class="site-menu-title">Dashboard</span>
                <div class="site-menu-badge">
                  <!-- <span class="badge badge-success">3</span> -->
                </div>
              </a>             
            </li>
            <li class="site-menu-category">Players</li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa-user" aria-hidden="true"></i>
                <span class="site-menu-title">Admins</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/admins')}}">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/admins/create')}}">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa-user" aria-hidden="true"></i>
                <span class="site-menu-title">Boat Owners</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/boat-owners')}}">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/boat-owners/pendingList')}}">
                    <span class="site-menu-title">Pending List</span>
                  </a>
                </li>

                <!--
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/boat-owners/create')}}">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li>
                -->

              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa-group" aria-hidden="true"></i>
                <span class="site-menu-title">Boat Coordinators</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/boat-coordinators')}}">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>

                <!--
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/boat-coordinators/create')}}">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li>    
                -->            
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa-street-view" aria-hidden="true"></i>
                <span class="site-menu-title">Captains</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="/admin/boat-captains">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>
                <!--
                <li class="site-menu-item">
                  <a class="animsition-link" href="/admin/boat-captains/create">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li>   
                -->             
              </ul>
            </li>

            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa-phone" aria-hidden="true"></i>
                <span class="site-menu-title">CSR</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="/admin/csr">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="/admin/csr/create">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa-university" aria-hidden="true"></i>
                <span class="site-menu-title">Shipping Companies</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="/admin/shipping-companies">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/shipping-companies/pendingList')}}">
                    <span class="site-menu-title">Pending List</span>
                  </a>
                </li>
                <!--
                <li class="site-menu-item">  
                  <a class="animsition-link" href="/admin/shipping-companies/create">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li>   
                -->             
              </ul>
            </li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa-users" aria-hidden="true"></i>
                <span class="site-menu-title">Users</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="/admin/users">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>
                <!--
                <li class="site-menu-item">
                  <a class="animsition-link" href="/admin/users/create">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li>  
                -->              
              </ul>
            </li>

            <li class="site-menu-category">Boats</li>
            <li class="site-menu-item has-sub">
              <a href="javascript:void(0)">
                <i class="site-menu-icon fa-ship" aria-hidden="true"></i>
                <span class="site-menu-title">Manage Boats</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/boats')}}">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/boats/create')}}">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li> 
              </ul>
            </li>

            <li class="site-menu-category">Pages</li>
            <li class="site-menu-item has-sub">
              <a href="#">
                <i class="site-menu-icon fa-ship" aria-hidden="true"></i>
                <span class="site-menu-title">Manage Pages</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/pages')}}">
                    <span class="site-menu-title">List</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/pages/create')}}">
                    <span class="site-menu-title">Add New</span>
                  </a>
                </li>
              </ul>
            </li>


            <li class="site-menu-category">Reports</li>
            <li class="site-menu-item has-sub">
              <a href="#">
                <i class="site-menu-icon fa-ticket" aria-hidden="true"></i>
                <span class="site-menu-title">Manage Reports</span>
                <span class="site-menu-arrow"></span>
              </a>
              <ul class="site-menu-sub">
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/reports/owner_reports')}}">
                    <span class="site-menu-title">Owner Reports</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/reports/company_reports')}}">
                    <span class="site-menu-title">Company Reports</span>
                  </a>
                </li>
                <li class="site-menu-item">
                  <a class="animsition-link" href="{{url('/admin/reports/user_reports')}}">
                    <span class="site-menu-title">User Reports</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="site-menu-category">Roles</li>
            <li class="site-menu-item has-sub">
              <a href="{{url('/admin/users-and-roles')}}">
                <i class="site-menu-icon fa-link" aria-hidden="true"></i>
                <span class="site-menu-title">Users and Roles</span>
              </a>
            </li>

            <li class="site-menu-category">Logout</li>
            <li class="site-menu-item has-sub">
              <a href="{{url('/user/logout')}}">
                <i class="site-menu-icon wb-power" aria-hidden="true"></i>
                <span class="site-menu-title">Logout</span>
              </a>
            </li>

          </ul>         
        </div>
      </div>
    </div>
  </div>