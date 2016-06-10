 <div class="side-menu">
    <ul>
        <li class="{{Request::is('csr/dashboard')?'active':''}}"><a href="/csr/dashboard"><i class="fa fa-user"></i> Profile</a></li>
        <li class="{{Request::is('csr/dashboard/users')?'active':''}}"><a href="/csr/dashboard/users"><i class="fa fa-ship"></i> Users</a></li>
        <li class="{{Request::is('csr/dashboard/trips')?'active':''}}"><a href="/csr/dashboard/trips"><i class="fa fa-ship"></i> Trips</a></li>
    </ul>
</div>
<!-- side-menu -->