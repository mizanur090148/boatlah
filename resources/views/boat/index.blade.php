@extends('user.layout')

@section('title')
    Boat List
@stop

@section('content')
<section class="section-boat-list">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="sidebar">
                    <div class="side-filter">
                        <div class="boat-filter-search">
                            {{Form::open(array('url'=>'/boats/list/search-result', 'method'=>'POST', 'class'=>'filter-search-form'))}}
                             <input type="hidden" name="zone" id="zone" value="{{$zone}}">

                                <div class="inner">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="search-block">
                                                <ul class="zone-selection dtable clearfix">
                                                    <li class="cell @if($zone=='Western')active @endif">
                                                        <a href="#east-zone" data-toggle="tab" class="btn btn-primary full" onclick="zone('Western')">Western</a>
                                                    </li>
                                                    <li class="cell @if($zone=='Eastern')active @endif">
                                                        <a href="#west-zone" data-toggle="tab" class="btn btn-primary full" onclick="zone('Eastern')">Eastern</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="tab-content">
                                                    <div class="tab-pane fade @if($zone=='Western') in active @endif" id="east-zone">
                                                        <div class="search-block  col-sm-6">
                                                            <label for="">Start point</label>
                                                            <select class="form-control east-start-point chosen" data-placeholder="Select Start point" id="east-start-point" name="east-start-point">
                                                                @foreach($Western_anchorages as $anchorage)
                                                                    <option value="{{ $anchorage->id }}" @if($start==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="search-block  col-sm-6">
                                                            <label for="">Destination point</label>
                                                            <select class="form-control east-destination chosen" data-placeholder="Select Destination" id="east-destination" name="east-destination">
                                                                @foreach($Western_anchorages as $anchorage)
                                                                    <option value="{{ $anchorage->id }}" @if($destination==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- tab-pane -->
                                                    <div class="tab-pane fade @if($zone=='Eastern') in active @endif" id="west-zone">
                                                        <div class="search-block  col-sm-6">
                                                            <label for="">Start point</label>
                                                            <select class="form-control west-start-point chosen" data-placeholder="Select Start Point" id="west-start-point" name="west-start-point">
                                                                @foreach($Eastern_anchorages as $anchorage)
                                                                    <option value="{{ $anchorage->id }}" @if($start==$anchorage->id) selected @endif>{{ $anchorage->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="search-block col-sm-6">
                                                            <label for="">Destination point</label>
                                                            <select class="form-control west-destination chosen" data-placeholder="Select Destination" id="west-destination" name="west-destination">
                                                                @foreach($Eastern_anchorages as $anchorage)
                                                                    <option value="{{ $anchorage->id }}" @if($destination==$anchorage->id) selected @endif >{{ $anchorage->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- tab-pane -->
                                                </div>
                                                <!-- tab-content -->
                                            </div>
                                            <!-- row -->
                                        </div>
                                        <!-- col-md -->
                                    </div>
                                    <!-- row -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">Boat type</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="check-btn-group">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="radio radio-block check-block  @if($manning_type=='one manned') selected @endif">
                                                        <label>
                                                            <input class="check-btn" type="radio" name="manning_type" value="one manned" @if($manning_type=='one manned') checked @endif/>
                                                            <span><i class="fa fa-user"></i>One manned</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-6 -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="radio radio-block check-block  @if($manning_type=='two manned') selected @endif">
                                                        <label>
                                                            <input class="check-btn" type="radio" name="manning_type" value="two manned"  @if($manning_type=='two manned') checked @endif/>
                                                            <span><i class="fa fa-user-plus"></i>Two manned</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- col-md-6 -->
                                        </div>
                                        <!-- radio-btn-group -->
                                    </div>

                                    <!-- row -->
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="search-block">
                                                <!-- <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Search the boat </button> -->
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Search Boats </button>
                                            </div>
                                            <!-- search-block -->
                                        </div>
                                        <!-- col-md-12 -->
                                    </div>
                                    <!-- row -->
                                </div>
                                <!-- inner -->
                            {{Form::close()}}
                        </div>
                        <!-- boat filter search -->
                    </div>
                    <!-- search-filter -->
                </div>
                <!-- sidebar -->
            </div>
            <!-- sidebar wrapper -->
            <div class="col-md-8">
                <div class="header-bar">
                    <h4><i class="fa fa-ship"></i>List of boats</h4>
                    <ul class="view-type-tab">
                        @if($contracted_boats!=[])
                        <li class="active"><a href="#boat-list-tab" data-toggle="tab"><i class="fa fa-list-alt"></i>Contracted Boats</a></li>
                        <li><a href="#boat-list-tab2" data-toggle="tab"><i class="fa fa-list-alt"></i>Other Available Boats</a></li>
                         @else
                            <li class="active"><a href="#boat-list-tab2" data-toggle="tab"><i class="fa fa-list-alt"></i>Available Boats</a></li>
                        @endif
                    </ul>
                </div>
                <!-- header-bar -->
                <div class="tab-content">
                    <div id="boat-list-tab" class="tab-pane @if($contracted_boats!=[]) active @endif">
                        <div class="boat-items">
                            @foreach($contracted_boats as $boat2)
                                @foreach($boat2 as $boat)
                                    <div class="single-boat dtable">
                                        <div class="cell media">
                                            <a href="/boats/profile/{{ $boat->id }}/{{$start}}/{{$destination}}"><img class="img-responsive" src="{{$boat->thumb_photo}}" alt="" /></a>
                                        </div>
                                        <div class="cell content">
                                            <h4><a href="/boats/profile/{{ $boat->id }}/{{$start}}/{{$destination}}">{{$boat->name}}</a></h4>
                                            <div class="info">
                                                <ul>
                                                    <li>Average Speed: <span>{{ $boat->average_speed }} Knots</span></li>
                                                    <li>Capacity: <span>{{ $boat->capacity }}</span></li>
                                                    <li>Operating Zone: <span>{{ $boat->operating_zone }}</span></li>
                                                    <li>Manning type: <span>{{ $boat->manning_type }}</span></li>
                                                </ul>
                                            </div>
                                            <!-- boat-info -->
                                            <div class="boat-meta">
                                                <a href="/boats/profile/{{ $boat->id }}/{{$start}}/{{$destination}}" class="btn btn-info btn-sm"><i class="fa fa-calendar-check-o"></i>Book Now</a>
                                            </div>
                                        </div>
                                        <!-- content -->
                                    </div>
                                    <!-- single-boat -->
                                @endforeach
                            @endforeach
                        </div>
                        <!-- boat-items wrapper -->
                        <div class="clearfix"></div>

                        @if(isset($contracted_boats->links))
                            <nav class="pagination-nav">
                                {!! $contracted_boats->links() !!}
                            </nav>
                            @endif

                                    <!-- pagination-nav -->
                    </div>
                    <div id="boat-list-tab2" class="tab-pane @if($contracted_boats==[]) active @endif">
                        <div class="boat-items">
                            @foreach($available_boats as $boat3)
                                @foreach($boat3 as $boat4)
                                    <div class="single-boat dtable">
                                        <div class="cell media">
                                            <a href="/boats/profile/{{ $boat4->id }}/{{$start}}/{{$destination}}"><img class="img-responsive" src="{{$boat4->thumb_photo}}" alt="" /></a>
                                        </div>
                                        <div class="cell content">
                                            <h4><a href="/boats/profile/{{ $boat4->id }}/{{$start}}/{{$destination}}">{{$boat4->name}}</a></h4>
                                            <div class="info">
                                                <ul>
                                                    <li>Average Speed: <span>{{ $boat4->average_speed }} Knots</span></li>
                                                    <li>Capacity: <span>{{ $boat4->capacity }}</span></li>
                                                    <li>Operating Zone: <span>{{ $boat4->operating_zone }}</span></li>
                                                    <li>Manning type: <span>{{ $boat4->manning_type }}</span></li>
                                                </ul>
                                            </div>
                                            <!-- boat-info -->
                                            <div class="boat-meta">
                                                <a href="/boats/profile/{{ $boat4->id }}/{{$start}}/{{$destination}}" class="btn btn-info btn-sm"><i class="fa fa-calendar-check-o"></i>Book Now</a>
                                            </div>
                                        </div>
                                        <!-- content -->
                                    </div>
                                    <!-- single-boat -->
                                @endforeach
                            @endforeach
                        </div>
                        <!-- boat-items wrapper -->
                        <div class="clearfix"></div>

                        @if(isset($available_boats->links))
                            <nav class="pagination-nav">
                                {!! $available_boats->links() !!}
                            </nav>
                            @endif

                                    <!-- pagination-nav -->
                    </div>
                </div>
                <!-- tab-content -->
            </div>
            <!-- boat-list wrapper -->
        </div>
        <!-- row -->
    </div>
    <!-- container -->
</section>
@stop

@section('footer_scripts')
<script>
function zone(zone)
{
    document.getElementById("zone").value = zone;
}
</script>

@endsection