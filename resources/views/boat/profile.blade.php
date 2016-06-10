@extends('user.layout')

@section('title')
    View Boat
@stop

@section('content')
<section class="section-boat-list">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="block-wrapper">

                            <div class="block">
                                <div class="boat-deatails">
                                    <h2 class="post-title">{{ $boat->name }}</h2>
                                                                      
                                    <div class="media">
                                        <div class="sigle-boat-slider">
                                            <div class="item">
                                                @if($boat->photo!=null)
                                                    <img src="{{URL::asset($boat->photo)}}" alt="...">
                                                @else
                                                    <img src="{{URL::asset('/images/preview.png')}}" alt="...">
                                                @endif
                                            </div>
                                        </div><!-- sigle-boat-slider -->
                                    </div>
                                    
                                    <div class="content">
                                        <h4>Description</h4>
                                        <p>{{ $boat->about }}</p>
                                        
                
                                        
                                    </div><!-- content -->
                                    
                                </div><!-- boat-details -->
                            </div><!-- block -->

                            <div class="padel-bprofile">
                                <form class="form-horizontal">
                                    <div class="me-block">
                                        <div class="header-bar booking-header-bar">
                                            <h4><i class="fa fa-ticket"></i>Booking</h4>
                                        </div>
                                        <div class="me-block-heading">
                                            <label class="label-title">Location type</label>
                                            <label class="radio-inline">
                                                <input type="radio" name="locationType" id="singleLocRadio" value="" checked="checked"> Single Location
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="locationType" id="multiLocRadio" value="option3"> Multiple Location
                                            </label>
                                        </div>
                                        <div class="me-content">
                                            <div class="table-responsive">
                                                <table class="table me-location-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Origin</th>
                                                            <th>Destination</th>
                                                            <th>Vessel Name</th>
                                                            <th>Accompanying Passenger Name</th>
                                                            <th>Remarks</th>
                                                            <th>Principal</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <select class="form-control select-styled" id="origin1" name="">
                                                                    <option>Select</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control select-styled" id="destination1" name="">
                                                                    <option>Select</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" class="form-control" id="vessel_name1" name=""></td>
                                                            <td><input type="text" class="form-control" id="ac_passenger__name1" name=""></td>
                                                            <td><input type="text" class="form-control" id="remarks1" name=""></td>
                                                            <td>
                                                                <select class="form-control select-styled" id="principal1" name="">
                                                                    <option>Principal one</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <a href="javascript: ;" class="me-addrow" id="remove1"><i class="fa fa-plus"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="me-block">
                                        <div class="me-block-heading">
                                            <label class="label-title inline-block">Booking for</label>
                                            <label class="radio-inline">
                                                <input type="radio" checked="checked" name="tab__bookings" data-target="#tab__self" value="Self"> Self
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="tab__bookings" data-target="#tab__employee" value="Employee"> Employee
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="tab__bookings" data-target="#tab__guest" value="Guest"> Guest
                                            </label>
                                        </div>
                                        <div class="me-content me-content-booking">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="tab__self">

                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tab__employee">
                                                    <select class="form-control chosen" data-placeholder="Boat User" name="">
                                                        <option value="Admin" selected="selected">Admin</option>
                                                    </select>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="tab__guest">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" placeholder="Passenger Name">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="email" class="form-control" placeholder="Email">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" placeholder="Phone">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary mt-15">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="sidebar">
                            <div class="panel-wrapper">
                                <div class="widget widget-captain">
                                    <div class="header-bar">
                                        <h4><i class="fa fa-user-secret"></i>Captain</h4>
                                    </div>
                                    @if(isset($boat->captain->user->name))
                                        <div class="media">
                                            <img src="{{ asset($boat->captain->photo_original) }}" alt="" />
                                        </div>
                                        <div class="content">
                                            <h4><a href="/captains/profile/{{ $boat->captain->user_id }}">{{ $boat->captain->user->name }}</a></h4>
                                            <p>{{ $boat->captain->about }}</p>
                                        </div>
                                    @else
                                        <div class="content">
                                            <h3><span class="label label-warning">Off-Duty</span></h3>
                                        </div>
                                    @endif
                                </div>

                                <div class="boat-meta-description table-responsive widget widget-captain">
                                            <div class="header-bar"><h4><i class="fa fa-ship"></i>Boat details</h4></div>
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="title">Owner</td>
                                                        <td><a href="/owners/profile/{{ $boat->owner->user_id }}">{{ $boat->owner->user->name }}</a> </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="title">Contact number</td>
                                                        <td>{{ $boat->owner->user->phone }}</td>
                                                    </tr>
                                                    @if(isset($boat->captain->user->name))
                                                    <tr>
                                                        <td class="title">Captain</td>
                                                        <td><a href="/captains/profile/{{ $boat->captain->user_id }}">{{ $boat->captain->user->name }}</a> </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="title">Captain Contact number</td>
                                                        <td>{{ $boat->captain->user->phone }}</td>
                                                    </tr>
                                                    @endif                                                    
                                                    <tr>
                                                        <td class="title">License</td>
                                                        <td>{{ $boat->license }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="title">Date of License</td>
                                                        <td>{{ $boat->license_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="title">Type</td>
                                                        <td>{{ ucfirst($boat->manning_type) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div><!-- boat-meta-description -->


                                        <div class="widget widget-captain">
                                            <div class="header-bar">
                                                <h4><i class="fa fa-map-marker"></i>Location</h4>
                                            </div>
                                            <div id="map" class="map"></div>
                                            <div id="map-side-bar">
                                                <div class="map-location" data-jmapping="{id: 1, point: { lng: {{ $boat->longitude }}, lat: {{ $boat->latitude }} }, category: 'market', zoom: 5}">
                                                    <a href="#" class="map-link"></a>
                                                </div>
                                            </div>
                                            
                                        </div>

                            </div>
                        </div>


                    </div>
                    
                    <div class="col-sm-8">
                        
                        <div class="block-wrapper">
                            
                        </div><!-- block-wrapper -->
                        
                        
                        
                        
                        <div class="clearfix"></div>
                        
                    </div><!--  col-md-8 -->
                    
                    
                </div><!-- row -->
            </div><!-- container -->
</section>
@stop

@section('footer_scripts')
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.23"></script>
<script type="text/javascript" src="/jmap/jquery.jmapping.min.js"></script>
<script type="text/javascript" src="/jmap/markermanager.js"></script>
<script type="text/javascript" src="/jmap/StyledMarker.js"></script>
<script type="text/javascript" src="/jmap/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/maplace.min.js"></script>
<script>
    $(document).ready(function(){
      $('#map').jMapping();
      $(".boat-location .map-link").trigger('click');

      $(function(){
        $('input[name="tab__bookings"]').click(function () {
            $(this).tab('show');
        });
      })

      $(function(){
          $(".me-location-table").on('click', '.me-addrow', function() {
            var $tr = $(this).closest('tr');
            var allTrs = $tr.closest('table').find('tr');
            var lastTr = allTrs[allTrs.length-1];
            var $clone = $(lastTr).clone();
            $clone.find('td').each(function(){
                var el = $(this).find(':first-child');
                var id = el.attr('id') || null;
                if(id) {
                    var i = id.substr(id.length-1);
                    var prefix = id.substr(0, (id.length-1));
                    el.attr('id', prefix+(+i+1));
                    el.attr('name', prefix+(+i+1));
                }
            });
            $clone.addClass('appended');
            $tr.closest('.me-location-table').append($clone);
        });
      });

      $(function(){
        $(".me-addrow").hide();
        $("label input").change(function(){
            if($("#multiLocRadio").is(":checked")){
                $(".me-addrow").show();
                $("tr.appended").show();
            }else {
                $(".me-addrow").hide();
                $("tr.appended").hide();
            }
        });
      });

    });

    function user(value) {
        if (value == 0) {
            document.getElementById('boatUser').className = 'tab-pane fade';
            document.getElementById('boatUser2').className = 'tab-pane fade';
        }
        else if (value == 1) {
            document.getElementById('boatUser').className = 'tab-pane fade in active';
            document.getElementById('boatUser2').className = 'tab-pane fade';
        }
        else if (value == 2) {
            document.getElementById('boatUser2').className = 'tab-pane fade in active';
            document.getElementById('boatUser').className = 'tab-pane fade';

        }
    }
</script>
@endsection