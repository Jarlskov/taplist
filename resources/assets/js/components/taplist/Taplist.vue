<script>
export default {
    data() {
        return {
            filter: '',
        }
    },

    props: {
        bars: {
            required: true
        },
        listings: {
            required: true
        }
    },

    computed: {
        filtered_listings: function() {
            if (this.filter !== '') {
                return this.listings.filter((listing) => {
                    return listing.bar.name === this.filter;
                });
            }

            return this.listings;
        }
    }
}
</script>

<template>
    <div>
        <label for="barlist">Select bar: </label>
        <select id="barlist" v-model="filter">
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
                <tr v-for="listing in filtered_listings">
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
