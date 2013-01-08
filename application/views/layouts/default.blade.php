<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			TV4
			@yield_section
		</title>
		<meta name="keywords" content="your, awesome, keywords, here" />
		<meta name="author" content="Jon Doe" />
		<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
		<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/bootstrap-responsive.css') }}" rel="stylesheet">

		<style>
		@section('styles')
			body {
				padding-top: 60px;
			}
		@yield_section
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}">
		<link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png') }}">
	</head>

	<body>
		<!-- Navbar -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>

					<div class="nav-collapse collapse">
						<ul class="nav">
							<li {{ (URI::is('/') ? 'class="active"' : '') }}><a href="{{ URL::to('') }}">TV4</a></li>

							@if (Auth::check())
								@if (Auth::user()->has_access("user.view"))
									<li {{ (URI::is('user') ? 'class="active"' : '') }}><a href="{{ URL::to('user') }}">Users</a></li>
								@endif
							<li {{ (URI::is('site') ? 'class="active"' : '') }}><a href="{{ URL::to('site') }}">Sites</a></li>
							<li {{ (URI::is('show') ? 'class="active"' : '') }}><a href="{{ URL::to('show') }}">Shows</a></li>
							<li {{ (URI::is('episode') ? 'class="active"' : '') }}><a href="{{ URL::to('episode') }}">Episodes</a></li>
							@endif

						</ul>

						<ul class="nav pull-right">
							@if (Auth::check())
							<li class="navbar-text">Logged in as {{ Auth::user()->fullName() }}</li>
							<li class="divider-vertical"></li>
							<li {{ (URI::is('account') ? 'class="active"' : '') }}><a href="{{ URL::to('account') }}">Account</a></li>
							<li><a href="{{ URL::to('account/logout') }}">Logout</a></li>
							@else
							<li {{ (URI::is('account/login') ? 'class="active"' : '') }}><a href="{{ URL::to('account/login') }}">Login</a></li>
							<li {{ (URI::is('account/register') ? 'class="active"' : '') }}><a href="{{ URL::to('account/register') }}">Register</a></li>
							@endif
						</ul>
					</div>
					<!-- ./ nav-collapse -->
				</div>
			</div>
		</div>
		<!-- ./ navbar -->

		<!-- Container -->
		<div class="container">
			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<!-- Content -->
			@yield('content')
			<!-- ./ content -->
		</div>
		<!-- ./ container -->

		<!-- Javascripts
		================================================== -->
		<script src="{{ asset('assets/js/jquery.v1.8.3.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap-2.2.2/bootstrap.min.js') }}"></script>
	</body>
</html>
