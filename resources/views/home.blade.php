@extends('user.layout')

@section('title')
    Home
@stop

@section('content')
    <!-- section-banner Start-->
    <section class="section-banner">
        <h2 class="hidden">Hidden header for w3validation</h2><!-- Hidden header for w3validation -->
        <div class="container">
            <h1>Boat Rentals.<span> Singapore.</span></h1>
            <h3>Find the perfect boat for you.</h3>

            <div class="row">
                <div class="col-sm-12 col-md-8 col-md-offset-2">
                    <div class="search-form-padel hide">
                        {{Form::open(array('url'=>'/boats/list/search-result', 'method'=>'POST', 'class'=>'form-horizontal'))}}
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="labelZone">Zone</span>
                                        <select class="form-control chosen-no-search" id="zone" name="zone" aria-describedby="labelZone">
                                            <option value="Western">Western</option>
                                            <option value="Eastern">Eastern</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group" id="m1">
                                        <span class="input-group-addon" id="labelFrom">From</span>
                                        <select class="form-control select-styled" id="anchorage" name="east-start-point" aria-describedby="labelFrom">
                                                @foreach($anchorages as $anchorage)
                                                    <option value="{{$anchorage->id}}">{{$anchorage->title}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group" id="w1" style="display: none;">
                                        <span class="input-group-addon" id="labelFrom__w1">From</span>
                                        <select class="form-control select-styled" id="anchorage3" name="west-start-point" aria-describedby="labelFrom__w1">
                                            @foreach($anchorages as $anchorage)
                                                <option value="{{$anchorage->id}}">{{$anchorage->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group" id="m2">
                                        <span class="input-group-addon" id="labelTo__m2">To</span>
                                        <select class="form-control select-styled" id="anchorage2" name="east-destination" aria-describedby="labelTo__m2">
                                            @foreach($anchorages as $anchorage)
                                                <option value="{{$anchorage->id}}">{{$anchorage->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="input-group" id="w2" style="display: none;">
                                        <span class="input-group-addon" id="labelTo__w2">To</span>
                                        <select class="form-control select-styled" id="anchorage4" name="west-destination" aria-describedby="labelTo__w2">
                                            @foreach($anchorages as $anchorage)
                                                <option value="{{$anchorage->id}}">{{$anchorage->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary btn-src btn-block"><i class="fa fa-search"></i>Find boats now</button>
                                    {{--<a href="/boats/list" class="btn-primary btn-block" type="submit"><i class="fa fa-search"></i>Find boats now</a>--}}
                                </div>

                            </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
            
            <div class="search-form-box hide">
                {{Form::open(array('url'=>'/boats/list/search-result', 'method'=>'POST', 'class'=>'form-inline'))}}
                    <!-- <div class="form-group">
                        <label for="startPoint">Zone</label>
                        <div class="form-box start-select">
                            <select class="form-control chosen-no-search" id="zone" name="zone">
                                <option value="Western">Western</option>
                                <option value="Eastern">Eastern</option>
                            </select>                            
                        </div>
                    </div>
                    <div class="form-group" id="m1" >
                        <label for="destinationPoint">From</label>
                        
                        <div class="form-box start-select">
                            <select class="form-control " id="anchorage" name="east-start-point">
                                @foreach($anchorages as $anchorage)
                                    <option value="{{$anchorage->id}}">{{$anchorage->title}}</option>
                                    @endforeach
                            </select>
                        </div>
                    
                    </div>
                <div class="form-group" id="m2" >
                    <label for="destinationPoint">To</label>
                    <div class="form-box destination-select">
                        <select class="form-control " id="anchorage2" name="east-destination">
                            @foreach($anchorages as $anchorage)
                                <option value="{{$anchorage->id}}">{{$anchorage->title}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
                <div class="form-group" id="w1" style="display: none;">
                    <label for="destinationPoint">From</label>

                    <div class="form-box start-select">
                        <select class="form-control " id="anchorage3" name="west-start-point">
                            @foreach($anchorages as $anchorage)
                                <option value="{{$anchorage->id}}">{{$anchorage->title}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group" id="w2" style="display: none;">
                    <label for="destinationPoint">To</label>
                    <div class="form-box destination-select">
                        <select class="form-control " id="anchorage4" name="west-destination">
                            @foreach($anchorages as $anchorage)
                                <option value="{{$anchorage->id}}">{{$anchorage->title}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div> -->

                    <!-- <button class="btn-primary" type="submit"><i class="fa fa-search"></i>Find boats now</button> -->
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Find boats now</button>
                  {{--<a href="/boats/list" class="btn-primary" type="submit"><i class="fa fa-search"></i>Find boats now</a>--}}
                {{Form::close()}}
            </div> <!-- search-form-box -->


        </div><!-- container -->
        
        <div class="bg-layer"></div>
    </section><!-- section-banner end -->
    
    <!-- section-boating-highlights Start-->
    <section class="section-boating-highlights">
        <div class="bg-layer"></div>
        <h2 class="hidden">Hidden header for w3validation</h2><!-- Hidden header for w3validation -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center">
                    <div class="section-heading">
                        <h2>The world's largest boat rental and charter marketplace. </h2>
                        <p class="sub">Search for powerboat rentals, sailboat charters, fishing charters, jet ski rentals, and houseboat rentals with Boatlah.</p>
                        <div class="line"></div>
                    </div><!-- section-heading -->
                </div><!-- col-md-12 -->
            </div><!-- row -->
            
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <a href="/user/register" class="panel-block anc-block highlights">
                        <div class="title">
                            <h3>Individual</h3>
                        </div>
                        <div class="media icon">
                            <i class="fa fa-mobile"></i>
                        </div><!-- media -->
                        
                        <div class="content">
                            <p>Search boats ready to rent</p>
                        </div><!-- content -->
                    </a><!-- panel-block feature -->
                </div><!-- col-sm-3 -->
                <div class="col-md-4 col-sm-4">
                    <a href="/corporate/register" class="panel-block anc-block highlights">
                        <div class="title">
                            <h3>Corporate</h3>
                        </div>
                        <div class="media icon">
                            <i class="fa fa-calendar"></i>
                        </div><!-- media -->
                        
                        <div class="content">
                            <p>Rent boats through our easy-to-use booking system</p>
                        </div><!-- content -->
                    </a><!-- panel-block feature -->
                </div><!-- col-sm-3 -->
                <div class="col-md-4 col-sm-4">
                    <a  href="/owner/register" class="panel-block anc-block highlights">
                        <div class="title">
                            <h3>Boat owner</h3>
                        </div>
                        <div class="media icon">
                            <i class="fa fa-ship"></i>
                        </div><!-- media -->
                        
                        <div class="content">
                            <p>List Your Boat and earn money while it's not being used</p>
                        </div><!-- content -->
                    </a><!-- panel-block feature -->
                </div><!-- col-sm-3 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- section-boating-highlights end -->
    
    
    <!-- section-mobile-boating Start-->
    <section class="section-mobile-boating has-bg text-center">
        <div class="bg-layer"></div>
        <h2 class="hidden">Hidden header for w3validation</h2><!-- Hidden header for w3validation -->
        <div class="container">
            <div class="row">
                <!-- <div class="col-md-4">
                    <div class="mobile-block">
                        <img src="images/mob1.png"  alt=""/>
                    </div>
                </div> --> <!-- col-md-12 -->
                <div class="col-md-12">
                    <div class="mobile-block">
                        <img src="images/mob1.png"  alt=""/>
                    </div>
                    
                    <div class="mobile-boating-block">
                        <div class="section-heading">
                            <h2>Rent a boat right from your pocket! </h2>
                            <p class="sub">Our Android and iPhone app will get you on the water faster. Search for a boat right on the waterfront and reserve on the go.</p>
                            <div class="line"></div>
                        </div><!-- section-heading -->
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="info-block">
                                    <h3><i class="fa fa-globe"></i>15 areas</h3>
                                    <p>Boatlah has the largest selection with 44,000 boats listed Singapore.</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-block">
                                    <h3><i class="fa fa-check-circle-o"></i>Messaging</h3>
                                    <p>Book reservations and reply to messages directly in the app from anywhere.</p>
                                </div>
                            </div>
                        </div><!-- row -->
                        
                        <div class="row app-link">
                            <div class="col-sm-6">
                                <a href="">
                                    <img src="images/gplay.png" alt="" />
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="">
                                    <img src="images/appstore.png" alt="" />
                                </a>
                            </div>
                        </div><!-- app-link -->
                    </div><!-- mobile block -->
                    
                </div><!-- col-md-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- section-mobile-boating end -->
        
        
    <!-- section-feature-boat Start-->
    <section class="section-feature-boat hide">
        <h2 class="hidden">Hidden header for w3validation</h2><!-- Hidden header for w3validation -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center">
                    <div class="section-heading">
                        <h2>Featured Boat Rentals</h2>
                        <p class="sub">A few of the best loved boats available for renting and chartering in top boating destinations.</p>
                        <div class="line"></div>
                    </div><!-- section-heading -->
                </div><!-- col-md-12 -->
            </div><!-- row -->
            
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="panel-block feature">
                        <a href="/boats/list">
                            <div class="media">
                                <img src="images/boat/1-1.jpg" alt="" />
                            </div>
                            <div class="boat-info">
                                <div class="owner">
                                    <h4>SweetSpot Charters</h4>
                                </div>
                                <div class="boat-desc">
                                    <h5>Singapore Beach, Sg</h5>
                                </div>
                                <div class="cost abs">
                                    $199 <sub>/hour</sub>
                                </div>
                            </div><!-- boat-info -->
                        </a>
                    </div><!-- panel-block feature -->
                </div><!-- col-md-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="panel-block feature">
                        <a href="/boats/list">
                            <div class="media">
                                <img src="images/boat/1-3.jpg" alt="" />
                            </div>
                            <div class="boat-info">
                                <div class="owner">
                                    <h4>SweetSpot Charters</h4>
                                </div>
                                <div class="boat-desc">
                                    <h5>Singapore Beach, Sg</h5>
                                </div>
                                <div class="cost abs">
                                    $199 <sub>/hour</sub>
                                </div>
                            </div><!-- boat-info -->
                        </a>
                    </div><!-- panel-block feature -->
                </div><!-- col-md-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="panel-block feature">
                        <a href="/boats/list">
                            <div class="media">
                                <img src="images/boat/1-2.jpg" alt="" />
                            </div>
                            <div class="boat-info">
                                <div class="owner">
                                    <h4>SweetSpot Charters</h4>
                                </div>
                                <div class="boat-desc">
                                    <h5>Singapore Beach, Sg</h5>
                                </div>
                                <div class="cost abs">
                                    $199 <sub>/hour</sub>
                                </div>
                            </div><!-- boat-info -->
                        </a>
                    </div><!-- panel-block feature -->
                </div><!-- col-md-3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="panel-block feature">
                        <a href="/boats/list">
                            <div class="media">
                                <img src="images/boat/1-4.jpg" alt="" />
                            </div>
                            <div class="boat-info">
                                <div class="owner">
                                    <h4>FairWind Charters</h4>
                                </div>
                                <div class="boat-desc">
                                    <h5>Singapore Beach, Sg</h5>
                                </div>
                                <div class="cost abs">
                                    $199 <sub>/hour</sub>
                                </div>
                            </div><!-- boat-info -->
                        </a>
                    </div><!-- panel-block feature -->
                </div><!-- col-md-3 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- section-feature-boat end -->
    
    <!-- section-share-rent Start-->
    <section class="section-share-rent text-center">
        <h2 class="hidden">Hidden header for w3validation</h2><!-- Hidden header for w3validation -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 info-block has-bg bg-gray">
                    <div class="">
                        <h4>See if your <span>friends</span> are going boating</h4>
                        <p>You can join them for an outing you'll never forget</p>
                        <a href="" class="btn-default">Join with facebook</a>
                    </div>
                </div><!-- col-sm-6 -->
                <div class="col-sm-6 info-block bg-wht-gray">
                    <div class="">
                        <h4>Rent your boat, <span>safely</span> and <span>easily</span></h4>
                        <p>Boatbound owners offset their ownership costs without risk</p>
                        <a href="" class="btn-primary">Learn more</a>
                    </div><!-- info-block -->
                </div><!-- col-sm-6 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- section-share-rent end -->
@stop

@section('footer_scripts')
    <script>
        $("#zone").on('change', function (e) {
            console.log(e);
            //document.write('hello');
            var zone = e.target.value;
            if (zone=='Western') {
                $.get('/ajax_anchorage?zone=' + zone, function (data) {
                    $('#anchorage').empty();
                    $('#anchorage2').empty();
                    $.each(data, function (index, subcatObj) {
                        $('#anchorage').append('<option value="' + subcatObj.id + '">' + subcatObj.title + '</option>');
                        $('#anchorage2').append('<option value="' + subcatObj.id + '">' + subcatObj.title + '</option>');
                    })

                });
                document.getElementById('w1').style.display = "none";
                document.getElementById('w2').style.display = "none";
                document.getElementById('m1').style.display = "";
                document.getElementById('m2').style.display = "";
            }
            else if(zone=='Eastern')
            {
                $.get('/ajax_anchorage?zone=' + zone, function (data) {
                    $('#anchorage3').empty();
                    $('#anchorage4').empty();
                    $.each(data, function (index, subcatObj) {
                        $('#anchorage3').append('<option value="' + subcatObj.id + '">' + subcatObj.title + '</option>');
                        $('#anchorage4').append('<option value="' + subcatObj.id + '">' + subcatObj.title + '</option>');
                    })

                });
                document.getElementById('w2').style.display = "";
                document.getElementById('w1').style.display = "";
                document.getElementById('m2').style.display = "none";
                document.getElementById('m1').style.display = "none";
            }
        });

    </script>
@stop