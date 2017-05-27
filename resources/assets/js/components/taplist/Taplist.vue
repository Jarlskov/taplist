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
            var listings = this.listings;

            if (this.filter !== '') {
                return this.listings.filter((listing) => {
                    return listing.bar.name === this.filter;
                });
            }

            return listings.sort((listinga, listingb) => {
                var bara = listinga.bar.name.toLowerCase();
                var barb = listingb.bar.name.toLowerCase();
                var tapa = listinga.tap_name;
                var tapb = listingb.tap_name;

                if (bara < barb) return -1;
                if (bara > barb) return 1;
                if (tapa < tapb) return -1;
                if (tapa > tapb) return 1;

                return 0;
            });
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
                    <th>Untappd Rating</th>
                    <th>Ratebeer Rating</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="listing in filtered_listings">
                    <td>{{ listing.bar.name }}</td>
                    <td>{{ listing.tap_name }}</td>
                    <td>{{ listing.beer.name }}</td>
                    <td>{{ listing.beer.brewery }}</td>
                    <td v-if="listing.beer.untappd_rating">{{ listing.beer.untappd_rating }}</td>
                    <td v-else></td>
                    <td>{{ listing.beer.ratebeeroverallrating }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
