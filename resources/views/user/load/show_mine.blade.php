@extends('layouts.app')

@section('content')

@if (session('flush_message'))
    <p>{{ session('flush_message') }}</p>
@endif

@include('user.parts.load_mine', ['load' => $load])
@include('user.parts.applies', ['applies' => $load->applies])

@endsection