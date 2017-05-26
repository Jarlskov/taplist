@extends('layouts.app')

@section('content')
    <userlist
        :initial_users="{{ $users->toJson() }}">
    </userlist>
@endsection
