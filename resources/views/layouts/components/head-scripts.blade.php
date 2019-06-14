<!-- <script src="{{asset('js/vendors/jquery-3.3.1.js')}}"></script>
<script src="{{ asset('js/vendors/typeahead.min.js') }}"></script>
<script src="{{ asset('js/vendors/select2.min.js') }}"></script>
<script src="{{ asset('js/b/scripts.js') }}"></script> -->
<!-- 
<script src="http://wyzi.io/js/vendors/jquery-3.3.1.js"></script>
<script src="http://wyzi.io/js/vendors/typeahead.min.js"></script>
<script src="http://wyzi.io/js/vendors/select2.min.js"></script>
<script src="http://wyzi.io/js/b/scripts.js"></script> -->

<script src="http://169.254.56.90/wyzi/public/js/vendors/jquery-3.3.1.js"></script>
<script src="http://169.254.56.90/wyzi/public/js/vendors/jquery.jscroll.min.js"></script>
<script src="http://169.254.56.90/wyzi/public/js/vendors/typeahead.min.js"></script>
<script src="http://169.254.56.90/wyzi/public/js/vendors/select2.min.js"></script>
<script src="http://169.254.56.90/wyzi/public/js/b/scripts.js"></script> 
<script>

function authId(){
    @if(Auth::check())
        return {{Auth::id()}};
    @else
        return null;
    @endif
}
function auth(){
  return authId() === null ? false : true;
}
function baseURL(){
    return "{{url('/')}}"
}
function typeaheadEngine(url){
   return new Bloodhound({
            remote: {
           url: url+'?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
}
</script>
@include('layouts.components.typeahead.tag')
<!-- Extra script that should live in the head -->
@yield('h-scripts')