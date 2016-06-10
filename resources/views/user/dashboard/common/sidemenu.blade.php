<?php $userProfile = \App\BoatUserProfile::where('user_id','=',Sentinel::getUser()->getUserID())->where('company_id','!=','NULL')->first();?>

 <div class="side-menu">
    <ul>
        <li class="{{Request::is('user/dashboard')?'active':''}}"><a href="/user/dashboard"><i class="fa fa-user"></i> Profile</a></li>
        <li class="{{Request::is('user/dashboard/company')?'active':''}}"><a href="/user/dashboard/company"><i class="fa fa-university"></i> My Company</a></li>
        <li class="{{Request::is('user/dashboard/my_trips')?'active':''}}"><a href="/user/dashboard/my_trips"><i class="fa fa-ship"></i> My Trips</a></li>
        @if($userProfile!=null)
        <li class="{{Request::is('user/dashboard/advance-booking')?'active':''}}"><a href="/user/dashboard/advance-booking"><i class="fa fa-bookmark"></i> Advance Booking</a></li>
        @endif
        <li class="{{Request::is('user/dashboard/report')?'active':''}}"><a href="/user/dashboard/report"><i class="fa fa-file-excel-o"></i> Reports</a></li>
    </ul>
</div>
<!-- side-menu -->