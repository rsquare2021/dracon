@extends('layouts.app')

@section('content')

@if (session('flush_message'))
    <p>{{ session('flush_message') }}</p>
@endif

<h4>荷物情報</h4>
@include('user.parts.load_other', ['load' => $load])
<h4 class="mt-4">会社情報</h4>
@include('user.parts.company', ['company' => $load->owner])

@endsection