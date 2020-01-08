<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/vendors/toastr.min.js')}}"></script>
<script src="{{asset('js/vendors/owl.carousel.min.js')}}"></script>

<script src="{{ asset('js/vendors/jquery.jscroll.min.js') }}"></script>
<script src="{{ asset('js/vendors/typeahead.min.js') }}"></script>
<script src="{{ asset('js/vendors/select2.min.js') }}"></script>
<script src="{{ asset('js/b/scripts.js') }}"></script>

<script>
			toastr.options = {
				"closeButton": true,
				"debug": true,
				"newestOnTop": true,
				"progressBar": true,
				"escapeHtml": false,
				"positionClass": "toast-bottom-center",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "0",
				"extendedTimeOut": "0",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			}

	$('.infinite-scroll').each(function(){
		var container = $(this);
		container.find('ul.pagination').hide();
		container.jscroll({
            autoTrigger: true,
            // loadingHtml: '<img class="center-block" src="/images/loading.gif" alt="Loading..." />',
            loadingHtml: '<div class="text-muted text-center"><small>loading more...</small></div>',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                container.find('ul.pagination').remove();
            }
        });
	});

</script>
	@include('layouts.components.toastr')
	@include('layouts.components.owl')

<!-- Extra scripts -->
@yield('b-scripts')
