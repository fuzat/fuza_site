@extends('errors::layout')

@section('title', 'Page Expired')

@section('message')
    Session has been time out.
    <br />
    <br />
    <a href="{{ route('home') }}">Click here</a> to continue.
@stop
