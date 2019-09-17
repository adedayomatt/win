<template>
    <div>
        <div class="text-center white">
            <h4>Console</h4>
        </div>
        <div class="row justify-content-center white">

            <div class="col-md-4 col-sm-8 no-padding-xs section">
                <button type="submit" class="btn btn-sm" @click="clearCache"><i class="fa fa-sync"></i> clear system cache</button>
                
                <form action="#" method="post" autofill="off" @submit.prevent="runArtisan" id="console"> 
                    <div>
                        <h6 class="white">Run artisan command</h6>
                        <pre>{{status}}</pre>
                        <div class="form-group">
                            <input v-if="ready" type="text" class="form-control no-outline command" name="command" placeholder="artisan command..." v-model="command" required>
                            <input v-else type="text" class="form-control no-outline command" name="command" placeholder="console busy..." disabled>
                        </div>
                        <div template v-for="param in params" v-bind:key="param.key" class="form-group row my-2">
                            <div class="col-6">
                                <input type="text" class="form-control no-outline command" placeholder="parameter..." name="parameters[]" v-model="param.parameter">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control no-outline command" placeholder="value..." name="values[]" v-model="param.value">
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-secondary btn-sm no-outline" @click="addParam"><i class="fa fa-plus"></i> param</button>
                        </div>
                        
                    </div>
                    
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-default">Run >>></button>
                    </div>
                </form>
            </div>

            <div class="col-md-4 col-sm-8 no-padding-xs section">
                <h6 class="text-center">Console Log</h6>
                <div class="logs-container">
                    <div v-for="log in logs" v-bind:key="logs.findIndex((l) => l.command == log.command)+Math.random()">
                        <template v-if="log.type=='artisan'">
                            <div>
                                <code :class="log.data.success ? 'text-success' : 'text-danger'" >[{{log.time}}] artisan {{log.data.command}}</code>
                            </div>
                            <pre v-for="output in log.data.outputs" v-bind:key="log.data.outputs.findIndex((o) => o == output)+Math.random()">{{output}}</pre>
                        </template>
                        <template v-else-if="log.type=='cache'">
                            <div>
                                <code :class="log.data.success ? 'text-success' : 'text-danger'">[{{log.time}}] system cache clear</code>
                            </div>
                            <pre>{{log.data.message}}</pre>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        data(){
            return {
                key: 0,
                ready: true,
                status:'waiting for command...',
                command:'',
                params: [],
                logs: [],
            }
        },
        computed: {
            time(){
            }
        },
        props: {

        },
        methods:{
            addParam(){
                if(this.ready){
                    this.key++;
                    this.params.push({key:this.key, parameter: '', value:''})
                }
           },
           getTime(){
            let date = new Date();
             return `${date.toLocaleDateString()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
           },
           runArtisan(){
              this.status = `running ${this.command}...`;
              this.ready = false;
               let data = $('form#console').serialize();
               axios.post('/system/artisan',data)
               .then(response => {
                this.status = `${this.command} done!`;
                this.ready = true;
                   this.logs.unshift({
                       type: 'artisan',
                       time: this.getTime(),
                       data: response.data
                   })
               })
               .catch(error => {
                   console.log(error.response)
               })
           },

            clearCache(){
               axios.post('/system/cache',{
                   _token: $('meta[name="csrf-token"]').attr('content'),
               })
               .then(response => {
                   this.logs.unshift({
                       type: 'cache',
                       time: this.getTime(),
                       data: response.data
                   })
               })
               .catch(error => {
                   console.log(error)
               })
           },
        },
        mounted() {
           
        }
    }
</script>

<style scoped>
    .logs-container{
        max-height: 80vh;
        overflow: auto
    }
    pre{
        border: 1px solid #f7f7f7;
        border-radius: 5px;
        padding: 5px;
    }
</style>