@extends('layouts.admin')

@section('admin-title', 'Create New Plan')
@section('admin-nav-title', 'Create Plan')

@section('admin-content')
@include('admin.plans.form')
@endsection