<template>
    <div>
        <div>
            <strong><i class="fa fa-check"></i> {{company_name}}</strong>
        </div>

        <input type="search" class="company-search form-control no-outline" placeholder="search company..."
        v-model.trim="q"
        >
        <input type="hidden" name="company" v-model="company_id" >
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import {mapActions} from 'vuex';
    import Bloodhound from 'corejs-typeahead/dist/bloodhound';
    import typeahead from 'corejs-typeahead/dist/typeahead.jquery';


    export default {
       name: 'company-search',
        data () {
            return {
            q: '',
            suggestions: null,
            company: JSON.parse(this.data),
            }
        },
        props: ['container','data'],
        computed: {
            input(){
                return `${this.container} .company-search`
            }, 
            company_name(){
                return this.company == null ? '' : this.company.name
            },
            company_id(){
                return this.company == null ? '' : this.company.id
            }
           
        },
        methods: {
            selectCompany(comp){
                this.company = comp;
                $(this.input).typeahead('close');
            },
            createNewCompany(name){
                axios.post(apiURL('/company'), {company: name})
                .then(response => {
                    this.selectCompany(response.data)
                })
                .catch(error => {

                })
            }
        },
        components: {
        
        },
        mounted() {
            let component = this;
            this.suggestions = new Bloodhound({
				remote: {
                            url: baseURL()+'/search/company?q=%QUERY%',
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
                name: 'company-suggestions',

                templates: {
                    empty : function(){
                        return `<div class="list-group-item"><strong>"<span class="new-company">${input.typeahead('val')}</span>"</strong></div>`
                    },
                    pending: function(){
                        return `<div class="list-group-item"><strong>"<span class="new-company">${input.typeahead('val')}</span>"</strong></div>`
                    },
                    header: function(){
                        return `<div class="list-group-item"><strong>"<span class="new-company">${input.typeahead('val')}</span>"</strong></div>`
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
                component.selectCompany(suggestion)
            })

            $(this.container).on('click', '.new-company', function(e){
                component.createNewCompany($(this).text());
                
            })
        }
    }
</script>
