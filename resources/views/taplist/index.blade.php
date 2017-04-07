@extends('layouts.app')

@section('content')
    <taplist
        :bars="{{ $bars->toJson() }}"
        :listings="{{ $listings->toJson() }}">
    </taplist>
@endsection
