@extends('layouts.admin')

@section('css')
	<style>
		body {
			background: #ffffff;
		}
		.nav_menu {
			display: none !important;
		}
		body {
			overflow-x: hidden !important;
			overflow-y: hidden !important;
		}
	</style>
@endsection

@section('content')
	<div class="container" style="text-align: center;">
		<h4>
			Sorry, your session seems to have expired or changed when you logged out already.
			<br /><br />
			Please reload the page or click <a href="/login">here</a> to login.
		</h4>
	</div>
@endsection