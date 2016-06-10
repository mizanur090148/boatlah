 <div class="side-menu">
    <ul>
        <li class="{{Request::is('company/dashboard')?'active':''}}"><a href="/company/dashboard"><i class="fa fa-user"></i> Profile</a></li>
        <li class="has-dropdown-aside {{Request::is('company/dashboard/my_employee')?'active':''}}"> <a href="/company/dashboard/my_employee"><i class="fa fa-group"></i>My Employees</a>
            <ul>
                <li><a href="/company/dashboard/approve_list">Employee <i class="fa fa-plus-square-o"></i> Requests</a></li>
                <li><a href="/company/dashboard/remove_list">Employee <i class="fa fa-minus-square-o"></i> Requests</a></li>
            </ul>
        </li>
        <li class="{{Request::is('company/dashboard/contracts')?'active':''}}"><a href="/company/dashboard/contracts"><i class="fa fa-file-text"></i>My Contracts</a></li>
        <li class="{{Request::is('company/dashboard/my_principals')?'active':''}}"><a href="/company/dashboard/my_principals"><i class="fa fa-bookmark-o"></i>My Principals</a></li>
        <li class="{{Request::is('company/dashboard/catalogs')?'active':''}}"><a href="/company/dashboard/catalogs"><i class="fa fa-usd"></i>My Tariff Tables</a></li>
        
        <li class="{{Request::is('company/dashboard/advance-booking')?'active':''}}"><a href="/company/dashboard/advance-booking"><i class="fa fa-bookmark"></i> Advance Booking</a></li>
        
        <li class="has-dropdown-aside {{Request::is('company/dashboard/report')?'active':''}}"><a href="#"><i class="fa fa-file-excel-o"></i> Report</a>
            <ul>
                <li><a href="/company/dashboard/report">Trips</a></li>
                <li><a href="/company/dashboard/billing_statements">Billing Statement</a></li>
            </ul>
        </li>
    </ul>
</div>
<!-- side-menu -->