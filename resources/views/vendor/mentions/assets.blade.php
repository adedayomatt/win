<script type="text/javascript" src="{{asset('js/vendors/jquery.caret.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vendors/jquery.atwho.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vendors/laravel.mentions.js')}}"></script>
<script type="text/javascript">
    function enableMentions(elem, type, column, beforeInsert = null) {
        let root = "{{url('/')}}";
        $(elem).atwho({
            at: "@",
            limit: 5,
            // data: ['Matthew', 'Adedayo'],
            callbacks: {
                remoteFilter: function(query, callback) {
                    if (query.length <= 1) return;

                    $.getJSON(root+"/api/mentions/" + type, {
                        q: query,
                        c: column
                    }, function(data) {
                        callback(data);
                    });
                },
                beforeInsert(value, $li){
                    let new_value = value;
                    if(beforeInsert !== null && typeof beforeInsert === 'function'){
                        new_value = beforeInsert(value, $li);
                    }
                     return new_value;   
                }
            }
        });
    }

</script>