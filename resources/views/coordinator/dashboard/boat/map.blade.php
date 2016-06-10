@extends('user.layout')

@section('title')
    Coordinator Dashboard
@stop

@section('content')
<section class="section-boat-list">
    <div class="container">
        @include('coordinator.dashboard.common.breadcrumb')
        <div class="row">
            <div class="col-md-3 col-sm-4">
                <div class="sidebar">
                    <div class="widget widget-side-menu">
                        <div class="header-bar">
                            <h4><i class="fa fa-gear"></i>Manage account</h4>
                        </div>
                    @include('coordinator.dashboard.common.sidemenu')
                    </div><!-- widget -->
                </div><!-- sidebar -->
            </div><!-- sidebar wrapper -->
            <div class="col-md-9 xol-sm-8">
                <div class="block-wrapper">
                    <div class="block account-block padel-box" style="background:#fff;">
                        <div class="header-bar padel-box-header">
                            <h4 class="clearfix padel-title">
                                 <i class="fa fa-ship"></i> Boats of {{$my_profile->boatOwner->name}} @ {{$my_profile->location}}
                                 <a href="/coordinator/dashboard/boats" class="pull-right rb-edit"><i class="fa fa-list"></i>List View</a>
                             </h4>
                             
                        </div>
                        <div class="padel-box-body my-boats">
                            <div class="map-wrapper">
                               <div id="map"></div>
                                <div id="map-side-bar">
                                @foreach($boats as $boat)                                   
                                    <div class="map-location" data-jmapping="{id: {{ $boat->id }}, point: {lng: {{ $boat->longitude }}, lat: {{ $boat->latitude }} }, category: @if($boat->status=='available' && $boat->captain_id!=null) 'available' @else 'busy' @endif}">
                                        <a href="#" class="map-link">{{ $boat->name }}</a>
                                        <div class="info-box">
                                            <p>{{ $boat->name }}</p>
                                            @if($boat->status=='available' && $boat->captain_id!=null)
                                               <p class="text-success">{{ $boat->status }}</p>
                                               <p>Captain : <a href="/captains/profile/{{$boat->captain_id}}" target="_blank">{{$boat->captain->user->name}}</a> </p>
                                            @else
                                               <p class="text-danger">Not Available</p>
                                            @endif
                                            <a href="/boats/profile/{{ $boat->id }}" target="_blank" class="map-link">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- block about-block -->
                </div>
                <!-- block-wrapper -->
                <div class="clearfix"></div>
            </div><!-- boat-list wrapper -->
        </div><!-- row -->
    </div><!-- container -->
</section>
@stop

@section('footer_scripts')
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.23&key=AIzaSyDujTDYQd_SoE5jCy0yqDAMVOxmRlopKNY"></script>
<script type="text/javascript" src="/jmap/jquery.jmapping.min.js"></script>
<script type="text/javascript" src="/jmap/markermanager.js"></script>
<script type="text/javascript" src="/jmap/StyledMarker.js"></script>
<script type="text/javascript" src="/jmap/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/maplace.min.js"></script>
<script>
    jQuery(document).ready(function() {
        $('#map').jMapping({
            category_icon_options: function(category){
                if (category.match('available')) {
                    return new google.maps.MarkerImage('/images/boat-marker.png');
                } else {
                    return new google.maps.MarkerImage('/images/boat-marker-busy.png');
                }
            }
        });
    });

function zone(zone)
{
    document.getElementById("zone").value = zone;
}
</script>

@endsection