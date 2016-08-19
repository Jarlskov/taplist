@extends('layouts.app')

@section('content')
<table id="listings">
    <thead>
        <tr>
            <th>Bar</th>
            <th>Tap</th>
            <th>Name</th>
            <th>Brewery</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody> 
        @foreach ($listings as $listing)
            <tr>
                <td>{{ $listing->bar->name }}</td>
                <td>{{ $listing->tap_name }}</td>
                <td>{{ $listing->beer->name }}</td>
                <td>{{ $listing->beer->brewery }}</td>
                <td>{{ $listing->beer->ratebeeroverallrating }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
