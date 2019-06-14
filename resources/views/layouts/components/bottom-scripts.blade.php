<!-- <script src="{{ asset('js/vendors/popper.min.js') }}"></script>
<script src="{{asset('js/vendors/bootstrap-4.min.js')}}"></script>
<script src="{{asset('js/vendors/toastr.min.js')}}"></script> -->

<!-- <script src="http://wyzi.io/js/vendors/popper.min.js"></script>
<script src="http://wyzi.io/js/vendors/bootstrap-4.min.js"></script>
<script src="http://wyzi.io/js/vendors/toastr.min.js"></script>
<script src="http://wyzi.io/js/vendors/owl.carousel.min.js"></script> -->

<script src="http://169.254.56.90/wyzi/public/js/vendors/popper.min.js"></script>
<script src="http://169.254.56.90/wyzi/public/js/vendors/bootstrap-4.min.js"></script>
<script src="http://169.254.56.90/wyzi/public/js/vendors/toastr.min.js"></script>
<script src="http://169.254.56.90/wyzi/public/js/vendors/owl.carousel.min.js"></script>

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
