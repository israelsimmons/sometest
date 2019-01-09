<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">{{ action }} Share VUEJS</div>

                    <div class="card-body" v-if="!editmode">
                        <dl class="row" v-if="share">
                            <dt class="col-sm-3">Company name</dt>
                            <dd class="col-sm-9">{{ share.company_name }}</dd>

                            <dt class="col-sm-3">Instrument name</dt>
                            <dd class="col-sm-9">{{ share.instrument_name }}</dd>
                        </dl>
                        <div class="" v-else>
                            <p>No share selected</p>
                        </div>
                    </div>
                    <div class="card-body" v-if="editmode">

                        <form method="POST" novalidate>
                            <div class="form-group row">
                                <label for="company_name" class="col-sm-4 col-form-label text-md-right">Company Name</label>

                                <div class="col-md-6">
                                    <input id="company_name" type="text" class="form-control" v-model="share.company_name" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="instrument_name" class="col-sm-4 col-form-label text-md-right">Instrument Name</label>

                                <div class="col-md-6">
                                    <input id="instrument_name" type="text" class="form-control" v-model="share.instrument_name" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quentity" class="col-sm-4 col-form-label text-md-right">Quantity</label>

                                <div class="col-md-6">
                                    <input id="quantity" type="text" class="form-control" v-model="share.quantity" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-sm-4 col-form-label text-md-right">Price</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" class="form-control" v-model="share.price" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="certificate_number" class="col-sm-4 col-form-label text-md-right">Certificate Number</label>

                                <div class="col-md-6">
                                    <input id="certificate_number" type="text" class="form-control" v-model="share.certificate_number" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="transaction_date" class="col-sm-4 col-form-label text-md-right">Transaction Date</label>

                                <div class="col-md-6">
                                    <input id="transaction_date" type="text" class="form-control" v-model="share.transaction_date" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="transaction_date" class="col-sm-4 col-form-label text-md-right">Tags</label>

                                <div class="col-md-6">
                                    <b-form-select multiple v-model="tagSelected" :options="tags"></b-form-select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <button v-on:click="saveShare($event)" class="btn btn-primary">Save Share</button>
                            </div>
                        </form>

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
                share:{
                    company_name:'',
                    instrument_name:'',
                    quantity:'',
                    price:'',
                    certificate_number:''
                },
                companyName:'',
                editmode:true,
                share_id:'',
                action:'Edit',
                tagSelected:[4],
                tags:[]
            }
        },
        created() {
            this.share_id = this.$route.params.id

            if (this.$route.params.id !== 'new') {
                this.show(this.$route.params.id)
            } else {
                this.action = 'Register New'
            }

            this.getTags()
        },
        methods: {
            getTags() {
                let asd = this
                axios.get('/api/tags/')
                .then(function(d){
                    asd.tags = d.data.tags.map(function(a){
                        return {value:a.id, text:a.description}
                    })

                })
            },
            show(id) {
                let asd = this

                axios.get('/api/shares/' + id )
                .then(function(d){
                    asd.share = d.data.share
                    asd.tagSelected = asd.share.tags.map(function(a){
                        return a.id
                    })

                    delete asd.share.tags;

                })
            },
            saveShare(event) {
                event.preventDefault();

                let asd = this
                let updated = false;

                let obj = { share:asd.share}

                if (this.$route.params.id !== 'new') {
                    obj._method = 'PUT'
                }

                axios.post('/api/shares/' + asd.share.id , obj)
                .then(function(d){

                    if (asd.share.id !== d.data.share.id) {
                        asd.$router.push({name:'show', params: {id:d.data.share.id}});
                        asd.$toasted.success('Share successfuly registered', {duration:3000, icon:'check'})

                    } else {
                        updated = true;
                        asd.$toasted.success('Share successfuly modified', {duration:3000, icon:'check'})
                    }

                    asd.share = d.data.share

                    axios.post('/api/shares/' + asd.share.id + '/tags', {tags:asd.tagSelected})
                    .then(function(d){
                        // asd.$toasted.success('Tags updated propperly', {duration:3000, icon:'check'})
                    })

                    // asd.$router.go(-1)
                }).catch(function(error){
                    asd.$toasted.error(error.response.data.message, {duration:5000, icon:'atom'});
                    for (let err in error.response.data.errors) {
                        error.response.data.errors[err].map(function(message){
                            asd.$toasted.error(message, {duration:5000, icon:'atom'});
                        });

                    }

                })

            }
        }
    }
</script>
