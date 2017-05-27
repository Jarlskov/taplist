<script>
import axios from 'axios';
import EditBeer from './EditBeer';
import Vue from 'vue';

export default {
    data() {
        return {
            beer: {},
        }
    },

    mounted() {
        this.loadBeer();

        this.$root.$on('beerUpdated', (beer) => {
            Vue.set(this.beer, beer.id, beer);
        });
    },

    methods: {
        beerClicked(beer) {
            this.$root.$emit('editBeer', beer);
        },

        loadBeer() {
            axios.get('/beer')
                .then(({ data }) => {
                    this.beer = data.beer;
                });
        }
    },

    components: {
        editbeer: EditBeer,
    }
}
</script>

<template>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Beer</th>
                    <th>Brewery</th>
                    <th>Untappd link</th>
                    <th>RateBeer link</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="beer in beer">
                    <td><a href="#" @click.prevent="beerClicked(beer)">{{ beer.name }}</a></td>
                    <td><a href="#" @click.prevent="beerClicked(beer)">{{ beer.brewery }}</a></td>
                    <td>{{ beer.untappd_link }}</td>
                    <td v-if="beer.ratebeerurl">
                        <a :href="beer.ratebeerurl">
                            <span v-if="beer.ratebeeroverallrating">{{ beer.ratebeeroverallrating }}</span>
                            <span v-else>N/A</span>
                        </a>
                    </td>
                    <td v-else>Not matched</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Beer</th>
                    <th>Brewery</th>
                    <th>Untappd link</th>
                    <th>RateBeer link</th>
                </tr>
            </tfoot>
        </table>
        <editbeer></editbeer>
    </div>
</template>
