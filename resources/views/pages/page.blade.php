@extends('user.layout')

@section('title')
    {{$page->title}}
@stop

@section('content')
    <section class="section-boat-list">
        <div class="container">
            <div class="row">
                <!-- sidebar wrapper -->
                <div class="col-md-12">
                    <div class="tab-content">
                        <div id="boat-list-tab" class="tab-pane active">
                            <div class="boat-items">
                                <div class="single-boat">
                                    {!! $page->content !!}
                                </div>
                            </div>
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
    <script type="text/javascript"
            src="http://maps.google.com/maps/api/js?v=3.23&key=AIzaSyDujTDYQd_SoE5jCy0yqDAMVOxmRlopKNY"></script>
    <script type="text/javascript" src="/jmap/jquery.jmapping.min.js"></script>
    <script type="text/javascript" src="/jmap/markermanager.js"></script>
    <script type="text/javascript" src="/jmap/StyledMarker.js"></script>
    <script type="text/javascript" src="/jmap/jquery.metadata.js"></script>
    <script type="text/javascript" src="/js/maplace.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            $('#map').jMapping({
                category_icon_options: function (category) {
                    return new google.maps.MarkerImage('/images/boat-marker.png');
                }
            });
        });

        function zone(zone) {
            document.getElementById("zone").value = zone;
        }
    </script>

@endsection