<script>
export default {
    props: {
        bars: {
            required: true
        },
        listings: {
            required: true
        }
    }
}
</script>

<template>
    <div>
        <label for="barlist">Select bar: </label>
        <select id="barlist">
            <option selected value="">All</option>
            <option v-for="bar in bars">{{ bar.name }}</option>
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
                <tr v-for="listing in listings">
                    <td>{{ listing.bar.name }}</td>
                    <td>{{ listing.tap_name }}</td>
                    <td>{{ listing.beer.name }}</td>
                    <td>{{ listing.beer.brewery }}</td>
                    <td>{{ listing.beer.ratebeeroverallrating }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
