<script>
import axios from 'axios';

export default {
    data() {
        return {
            loading: false,
            user: {},
        }
    },

    mounted() {
        this.$root.$on('editUser', (user) => {
            this.user = $.extend({}, user);

            $('#edit-user-modal').modal('show');
        });
    },

    methods: {
        submitForm() {
            this.loading = true;

            axios.put('/users/' + this.user.id, this.user)
                .then(({ data }) => {
                    this.$root.$emit('userEdited', data.user)

                    $('#edit-user-modal').modal('hide');
                });
        }
    }
}
</script>

<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-user-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit {{ user.name }}</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group label-floating">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" v-model="user.name" class="form-control">
                        </div>

                        <div class="form-group label-floating">
                            <label for="name">Email</label>
                            <input type="text" id="name" name="name" v-model="user.email" class="form-control">
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="name" name="name" v-model="user.is_admin"> Admin
                            </label>
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
