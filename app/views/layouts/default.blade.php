@extends('layouts.main')

@section('container')
 <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Sites</li>
              <li class="active"><a href="#">Show All Sites</a></li>
              <li><a href="#">Add new Site</a></li>
              <li class="nav-header">Users</li>
              <li><a href="#">Add New User</a></li>
              <li><a href="#">Show All Users</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li class="nav-header">Sidebar</li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
              <li><a href="#">Link</a></li>
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
