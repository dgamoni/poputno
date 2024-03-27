$(document).ready(function() {
$('#contactForm').slidinglabels({
/* these are all optional */
className : 'snf-box', // the class you're wrapping the label & input with -> default = slider
topPosition : '10px', // how far down you want each label to start
leftPosition : '25px', // how far left you want each label to start
axis : 'x', // can take 'x' or 'y' for slide direction
speed : 'fast' // can take 'fast', 'slow', or a numeric value
});

$('form#contactForm input, form#contactForm textarea').focus(function(){
		$(this).parent().addClass('active-field');
	});
	
	$('form#contactForm input, form#contactForm textarea').focusout(function(){
		$(this).parent().removeClass('active-field');
	});

	$('form#contactForm').submit(function() {
		$('form#contactForm .error').remove();
		var hasError = false;
		$('.requiredField').each(function() {
			if(jQuery.trim($(this).val()) == '') {
				var labelText = $(this).prev('label').text();
				$(this).parent().addClass('error-field');
				hasError = true;
			} else if(jQuery.trim($(this).not('.email').val()) !== '') {
					$(this).parent().removeClass('error-field');	
			} else if($(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim($(this).val()))) {
					var labelText = $(this).prev('label').text();
					$(this).parent().addClass('error-field');
					hasError = true;
				} else {
					$(this).parent().removeClass('error-field');	
				}
			}
		});
		if(!hasError) {
			$('form#contactForm li.buttons button').fadeOut('normal', function() {
				$(this).parent().append();
			});
			var formInput = $(this).serialize();
			$.post($(this).attr('action'),formInput, function(data){
				$('form#contactForm').fadeOut(400, function() {				   
					$(this).before('<h3>Новость отправлена.</h3> <p>Спасибо за сотрудничество.</p>');
				});
			});
		}		
		return false;	
	});
	
	
});