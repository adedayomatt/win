<script>
	$('.has-tag-follow').on('submit', '.tag-follow', function(e){
			e.preventDefault();
			var form = $(this);
			var btn = $(this).find('[type = "submit"]');
				if(auth()){
					request(
						url = form.attr('action'),
						method = form.attr('method'),
						data =  {
							_token: form.find('[name="_token"]').val(),
							async: 1,
							},
						success = function(response){
							toastr.success(response.message);
							if(btn.attr('data-role') == 'follow'){
								btn.removeClass('btn-theme');
								btn.addClass('btn-default');
								btn.find('.icon').removeClass('fa-plus-circle');
								btn.find('.icon').addClass('fa-minus-circle');
								btn.find('.text').text('unfollow');
								btn.attr('data-role','unfollow');
							}else if(btn.attr('data-role') == 'unfollow'){
								btn.removeClass('btn-default');
								btn.addClass('btn-theme');
								btn.find('.icon').removeClass('fa-minus-circle');
								btn.find('.icon').addClass('fa-plus-circle');
								btn.find('.text').text('follow');
								btn.attr('data-role','follow');
							}
						},
						fail = function(status){
							toastr.error(`failed: ${status}`)
					})
				}
				else{
					toastr.info('Sign in first!');
				}
		})	
</script>