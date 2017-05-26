@extends('layouts.app')

@section('content')
    <beerlist
        :initial_beer="{{ $beer->toJson() }}">
    </beerlist>
@endsection
