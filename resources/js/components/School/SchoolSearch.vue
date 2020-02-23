<template>
    <div>
        <div>
            <strong><i class="fa fa-check"></i> {{school_name}}</strong>
        </div>
        <input type="search" class="school-search form-control no-outline" placeholder="search school..."
        v-model.trim="q"
        >
        <input type="hidden" name="school" v-model="school_id">
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import Bloodhound from 'corejs-typeahead/dist/bloodhound';
    import typeahead from 'corejs-typeahead/dist/typeahead.jquery';


    export default {
       name: 'school-search',
        data () {
            return {
            q: '',
            suggestions: null,
            school: this.data == '' ? null : JSON.parse(this.data),
            }
        },
        props: ['container','data'],
        computed: {
            input(){
                return `${this.container} .school-search`
            }, 
           school_name(){
               return this.school == null ? '' : this.school.name
           },
            school_id(){
               return this.school == null ? '' : this.school.id
           }

        },
        methods: {
            ...mapActions([
                'apiCall'
            ]),
            selectSchool(sch){
                this.school = sch;
            },
            createNewSchool(name){
                this.apiCall({
                    endpoint: '/school',
                    method: 'POST',
                    data: {school: name}
                })
                .then(response => {
                    this.selectSchool(response.data)
                })
                .catch(error => {
                    toastError(error.response)
                })
            }
        },
        components: {
        
        },
        mounted() {
            let component = this;
            this.suggestions = new Bloodhound({
				remote: {
                            url: baseURL()+'/search/school?q=%QUERY%',
                            wildcard: '%QUERY%'
                        },
                datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
                queryTokenizer: Bloodhound.tokenizers.whitespace
                });
            let input = $(this.input);
            input.typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, 
            { 
                source: this.suggestions,
                // This will bttAdaptere appended to "tt-dataset-" to form the class name of the suggestion menu.
                name: 'school-suggestions',

                templates: {
                    empty : function(){
                        return `<div class="list-group-item"><strong>"<span class="new-school">${input.typeahead('val')}</span>"</strong></div>`
                    },
                    pending: function(){
                        return `<div class="list-group-item"><strong>"<span class="new-school">${input.typeahead('val')}</span>"</strong></div>`
                    },
                    header: function(){
                        return `<div class="list-group-item"><strong>"<span class="new-school">${input.typeahead('val')}</span>"</strong></div>`
                    },
                    // footer: '<div class="list-group-item text-center">Footer Content</div>',
                    suggestion: function (data) {
                        var avatarURL = baseURL()+'/storage/images/users/';
                        return `<div class="list-group-item">
                                        <strong class="d-block">
                                            ${data.name}
                                        </strong>
                                        <small class="m-1 d-block">${data.address == null ? '' : data.address}</small>
                                        ${data.educations != null ? '<small class="m-1 d-block"> '+data.educations.length+' others attends</small>' : ''}
                                </div>`;
                    }
                }
            }).bind('typeahead:select', function(ev, suggestion) {
                component.q = suggestion.name;
                $(this).typeahead('val',suggestion.name);
                component.selectSchool(suggestion);
            })

            $(this.container).on('click', '.new-school', function(e){
                component.createNewSchool($(this).text());
            })
        }
    }
</script>
