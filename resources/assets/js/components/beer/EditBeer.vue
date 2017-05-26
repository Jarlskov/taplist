<script>
import axios from 'axios';

export default {
    data() {
        return {
            beer: {},
        }
    },

    mounted() {
        this.$root.$on('editBeer', (beer) => {
            this.beer = beer;

            $('#edit-beer-modal').modal('show');
        });
    },

    methods: {
        reloadRatebeerRating() {
            axios.post('/beer/' + this.beer.id + '/reloadratebeer')
                .then(({ data }) => {
                    this.beer.ratebeeroverallrating = data.rating;
                    this.$root.$emit('beerUpdated', this.beer);
                });
        }
    }
}
</script>

<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-beer-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit {{ beer.name }}</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" v-model="beer.name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="brewery">Brewery</label>
                            <input type="text" id="brewery" name="name" v-model="beer.brewery" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="ratebeerurl">Ratebeer URL</label>
                            <input type="text" id="ratebeerurl" v-model="beer.ratebeerurl" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="ratebeeroverallrating">Ratebeer overall rating</label>
                            <div v-if="beer.ratebeeroverallrating">{{ beer.ratebeeroverallrating }}</div>
                            <div v-else>Rating missing</div>
                            <button type="button" class="btn btn-default" @click.prevent="reloadRatebeerRating">Reload rating</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" @click.prevent="submitForm" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>
