 <div class="side-menu">
    <ul>
        <li class="{{Request::is('owner/dashboard')?'active':''}}"><a href="/owner/dashboard"><i class="fa fa-user"></i> Profile</a></li>
        <li class="{{Request::is('owner/dashboard/boats')?'active':''}}"><a href="/owner/dashboard/boats"><i class="fa fa-ship"></i> My Boats</a></li>
        <li class="{{Request::is('owner/dashboard/captains')?'active':''}}"><a href="/owner/dashboard/captains"><i class="fa fa-street-view"></i> My Captains</a></li>
        <li class="{{Request::is('owner/dashboard/coordinators')?'active':''}}"><a href="/owner/dashboard/coordinators"><i class="fa fa-group"></i> My Coordinators</a></li>
        <li class="{{Request::is('owner/dashboard/contracts*')?'active':''}}"><a href="/owner/dashboard/contracts"><i class="fa fa-file-text-o"></i> My Contracts</a></li>
        <li class="{{Request::is('owner/dashboard/catalogs')?'active':''}}"><a href="/owner/dashboard/catalogs"><i class="fa fa-usd"></i> Tariff Tables</a></li>
        <li class="{{Request::is('owner/dashboard/my_bookings')?'active':''}}"><a href="/owner/dashboard/my_bookings"><i class="fa fa-ship"></i> My Bookings</a></li>
        <li class="has-dropdown-aside {{Request::is('owner/dashboard/report/*')?'active':''}}"><a href="#"><i class="fa fa-file-excel-o"></i> Reports</a>
            <ul>
                <li><a href="/owner/dashboard/report/trips">Trips</a></li>
                <li><a href="/owner/dashboard/report/collections">Collections</a></li>
                <li><a href="/owner/dashboard/report/billing_statements">Billing Statement</a></li>
            </ul>
        </li>
    </ul>
</div>
<!-- side-menu -->