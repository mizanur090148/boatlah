@extends('user.layout')

@section('title')
    Dashboard
@stop

@section('content')
<section class="section-boat-list">
    <div class="container">
        <div class="notifications-holder">
            <h4 class="noti-pheading"><i class="fa fa-globe"></i> Notifications</h4>

            <div class="notifications">
                <a href="" class="notification">
                    <div class="noti-thumb"><img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQtfqFMiAv-k7qFFZtiS8qIuzLbtTOyZBgh8WQ1Pt14KKaZ6n5xIw"></div>
                    <div class="noti-content">
                        <div class="noti-meta-info"><span class="name">Jone Deo</span> Likes your post on his timeline</div>
                        <span class="noti-post-time"><i class="fa fa-picture-o"></i> Yesterday at 3:42pm</span>
                    </div>
                </a>
                <a href="" class="notification">
                    <div class="noti-thumb"><img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQtfqFMiAv-k7qFFZtiS8qIuzLbtTOyZBgh8WQ1Pt14KKaZ6n5xIw"></div>
                    <div class="noti-content">
                        <div class="noti-meta-info"><span class="name">Jone Deo</span> Likes your post on his timeline</div>
                        <span class="noti-post-time"><i class="fa fa-picture-o"></i> Yesterday at 3:42pm</span>
                    </div>
                </a>
                <a href="" class="notification">
                    <div class="noti-thumb"><img src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQtfqFMiAv-k7qFFZtiS8qIuzLbtTOyZBgh8WQ1Pt14KKaZ6n5xIw"></div>
                    <div class="noti-content">
                        <div class="noti-meta-info"><span class="name">Jone Deo</span> Likes your post on his timeline</div>
                        <span class="noti-post-time"><i class="fa fa-picture-o"></i> Yesterday at 3:42pm</span>
                    </div>
                </a>
            </div>
        </div>
    </div><!-- container -->
</section>
@stop