<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">My Shares VUEJS</div>

                    <div class="card-body">

                        <router-link class="btn btn-primary" :to="{ name: 'show', params: {id:'new'}}">Register New Share</router-link>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Instrument</th>
                                    <th class="text-right">Qty</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Investment</th>
                                    <th>Trans. date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="share in shares">
                                    <td>{{ share.company_name }}</td>
                                    <td>
                                        {{ share.instrument_name }}<br>
                                        <small class="badge badge-primary" v-for="tag in share.tags">{{ tag.description}}</small>
                                    </td>
                                    <td class="text-right">{{ share.quantity}}</td>
                                    <td class="text-right">{{ share.price}}</td>
                                    <td class="text-right">{{ share.total_investment}}</td>
                                    <td>{{ share.transaction_date}}</td>
                                    <td>
                                        <button class="btn btn-success btn-small" v-on:click="selectShare(share)" type="button" name="button"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger btn-small" v-on:click="deleteShare(share)" type="button" name="button"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <b-pagination size="md" v-on:input="getData" :total-rows="pagination.total" v-model="currentPage" :per-page="pagination.per_page"></b-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import {eventBus} from '../app.js'

    export default {
        data() {
            return {
                shares:[],
                pagination:{},
                currentPage:1
            }
        },
        created() {
            // Load the paginated list when the object is created

        },
        mounted(){
            this.getData()
        },
        methods: {
            getData() {
                let asd = this
                axios.get('/api/shares?page=' + this.currentPage )
                .then(function(d){
                    asd.shares = d.data.shares.data
                    asd.pagination = d.data.shares

                })
            },

            selectShare(share) {
                eventBus.$emit('shareSelected', share);
                this.$router.push({ name: 'show', params: { id: share.id }})
            },

            deleteShare(share) {
                let asd = this;

                this.$toasted.show('Please confirm your intent to delete: ' + share.instrument_name, {
                    icon:'trash',
                    action:[
                        {
                            text:'Cancel',
                            onClick: function(e, toastObject) {
                                toastObject.goAway(0);
                            }
                        },
                        {
                            text:'Delete!',
                            onClick: function(e, toastObject) {
                                console.log(share)
                                toastObject.goAway(0)
                                axios.delete('/api/shares/' + share.id)
                                .then(function(data){
                                    asd.getData();
                                    asd.$toasted.success(
                                        data.data.message,
                                        {
                                            icon:'check',
                                            duration:3000
                                        }
                                    )

                                })
                                .catch(function(error){
                                    toastObject.goAway(0)
                                    asd.$toasted.error(
                                        error.response.data.message,
                                        {
                                            icon:'exclamation-circle',
                                            duration:5000
                                        }
                                    )
                                })
                            }
                        }

                    ]
                })
            }
        }
    }
</script>
