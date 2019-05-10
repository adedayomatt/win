<script src="{{asset('js/vendors/jquery-3.3.1.js')}}"></script>
<script src="{{ asset('js/vendors/typeahead.min.js') }}"></script>
<script src="{{ asset('js/vendors/select2.min.js') }}"></script>
<script src="{{ asset('js/b/scripts.js') }}"></script>
<!-- 
<script src="http://wyzi.io/js/vendors/jquery-3.3.1.js"></script>
<script src="http://wyzi.io/js/vendors/typeahead.min.js"></script>
<script src="http://wyzi.io/js/vendors/select2.min.js"></script>
<script src="http://wyzi.io/js/b/scripts.js"></script> -->

@include('layouts.components.typeahead')
<!-- Extra script that should live in the head -->
@yield('h-scripts')