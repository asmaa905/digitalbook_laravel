@extends('layouts.app')

@section('title')


  @yield('publisher-title')
@endsection

@section('styles')

  @yield('publisher-styles')
@endsection

@section('content')
    <!-- nav bar for admin pages -->
    <!-- side bar for admin pages -->

    @yield('publisher-content')
@endsection

@section('scripts')


  @yield('publisher-scripts')
@endsection