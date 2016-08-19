@extends('layouts.app')

@section('content')
<label for="barlist">Select bar: </label>
<select id="barlist">
    <option selected value="">All</option>
    @foreach ($bars as $bar)
        <option>{{ $bar->name }}</option>
    @endforeach
</select>

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
