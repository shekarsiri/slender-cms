@extends('layouts.main')

@section('container')
 <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Videos</li>
              <li><a href="/videos">Show All Videos</a></li> <!-- class="active" -->
              <li><a href="/videos/create">Add new Video</a></li>
              <li class="nav-header">Alboms</li>
              <li><a href="#">Add New Albom</a></li>
              <li><a href="#">Show All Alboms</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <div class="span10">
            

            <!-- Notifications -->
            @include('notifications')
            <!-- ./ notifications -->

            <!-- Content -->
            @yield('content')
            <!-- ./ content -->

          
        </div><!--/span-->
      </div><!--/row-->
</div><!--/container-fluid-->   
@stop
