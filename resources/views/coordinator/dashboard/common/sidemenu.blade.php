 <div class="side-menu">
    <ul>
        <li class="{{Request::is('coordinator/dashboard')?'active':''}}"><a href="/coordinator/dashboard"><i class="fa fa-user"></i> Profile</a></li>
        <li class="{{Request::is('coordinator/dashboard/boats')?'active':''}}"><a href="/coordinator/dashboard/boats"><i class="fa fa-ship"></i> Boats</a></li>
        <li class="{{Request::is('coordinator/dashboard/my-advance-bookings')?'active':''}}"><a href="/coordinator/dashboard/my-advance-bookings"><i class="fa fa-bookmark"></i>  Advance Bookings Request</a></li>
        <li class="{{Request::is('coordinator/dashboard/trips')?'active':''}}"><a href="/coordinator/dashboard/trips"><i class="fa fa-ship"></i> Trips</a></li>
    </ul>
</div>
<!-- side-menu -->