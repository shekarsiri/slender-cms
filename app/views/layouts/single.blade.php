@extends('layouts.main')

@section('container')
    <div class="container">

      <!-- Notifications -->
      @include('notifications')
      <!-- ./ notifications -->

      <!-- Content -->
      @yield('content')
      <!-- ./ content -->

    </div> <!-- /container -->
@stop
