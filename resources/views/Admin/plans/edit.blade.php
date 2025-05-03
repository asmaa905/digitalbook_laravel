@extends('layouts.admin')

@section('admin-title', 'Edit Plan')

@section('admin-content')
@include('admin.plans.form', ['plan' => $plan])
@endsection