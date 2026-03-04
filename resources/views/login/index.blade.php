@extends('layout')

@section('content')

    <h2>Login</h2>

    <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>

@endsection