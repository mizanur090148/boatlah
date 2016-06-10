<?php
$adminRole = Sentinel::findRoleBySlug('admin');
$userRole = Sentinel::findRoleBySlug('user');
$ownerRole = Sentinel::findRoleBySlug('owner');
$companyRole = Sentinel::findRoleBySlug('company');
$coordinatorRole = Sentinel::findRoleBySlug('coordinator');
$captainRole = Sentinel::findRoleBySlug('captain');
$csrRole = Sentinel::findRoleBySlug('csr');
?>

<header>

    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL::to('/') }}"><img src="{{asset('images/logo.png')}}"
                                                                       alt="Botlah logo" width="100px"/></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse col-sm-offset-3" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                    @if(Sentinel::check())
                        <li>
                            <a>
                                Welcome {{ Sentinel::getUser()->name}}!
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">Roles <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @if (Sentinel::getUser()->inRole($adminRole))
                                    <li><a href="{{ URL::to('/admin/dashboard') }}">Admin</a></li>
                                @endif
                                @if (Sentinel::getUser()->inRole($ownerRole))
                                    <li><a href="{{ URL::to('/owner/dashboard') }}">Owner</a></li>
                                @endif
                                @if (Sentinel::getUser()->inRole($companyRole))
                                    <li><a href="{{ URL::to('/company/dashboard') }}">Shipping Agency</a></li>
                                @endif
                                @if (Sentinel::getUser()->inRole($coordinatorRole))
                                    <li><a href="{{ URL::to('/coordinator/dashboard') }}">Coordinator</a></li>
                                @endif
                                @if (Sentinel::getUser()->inRole($csrRole))
                                    <li><a href="{{ URL::to('/csr/dashboard') }}">CSR</a></li>
                                @endif
                                @if (Sentinel::getUser()->inRole($userRole))
                                    <li><a href="{{ URL::to('/user/dashboard') }}">User</a></li>
                                @endif
                            </ul>
                        </li>
                        <li><a href="{{ URL::to('/user/logout') }}"> Log Out</a></li>
                        <li><a href="{{ URL::to('/boats/list') }}" class="btn-primary">Browse Boats</a></li>
                    @else
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false"> Sign up <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ URL::to('/corporate/register') }}">Corporate</a></li>
                                <li><a href="{{ URL::to('/owner/register') }}">Boat Owner</a></li>
                                <li><a href="{{ URL::to('/user/register') }}">Individual User</a></li>
                            </ul>
                        </li>                       
                        <li><a href="{{ URL::to('login') }}"> Login </a></li>
                        <!-- <li><a href="{{ URL::to('/owner/register') }}" class="btn-primary">List Your Boat</a></li> -->
                    @endif

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>


</header>
<!--/.header-->