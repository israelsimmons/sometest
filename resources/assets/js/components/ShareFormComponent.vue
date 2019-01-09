<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Edit Share VUEJS</div>

                    <div class="card-body">
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
                share:false,
                share_id:''
            }
        },
        created() {
            // this.show()
            let asd = this
            eventBus.$on('shareSelected', function(share){
                console.log(share)
                asd.share = share
            });
        },
        methods: {
            show() {
                let asd = this
                axios.get('/api/users/1/shares/' + this.shareId )
                .then(function(d){
                    asd.share = d.data.share

                })
            }
        }
    }
</script>
