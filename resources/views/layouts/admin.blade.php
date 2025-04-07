@extends('layouts.app')

@section('title')
  @yield('admin-title')
@endsection

@section('styles')
  @yield('admin-styles')
@endsection

@section('content')
    <!-- nav bar for admin pages -->
    <!-- side bar for admin pages -->
    @yield('admin-content')
@endsection

@section('scripts')
  @yield('admin-scripts')
@endsection