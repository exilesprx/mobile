 $(function() {
	$('form').on('click', '#close-image', function() {
		var $parentForm = $(this).parent();

		$parentForm.find('#old-image').val('{remove}').hide();
		$parentForm.find('input[type=file]').css({ display: 'block' });
	});

	$('form').on('click', '#close-image', function() {
		var $parentForm = $(this).parent();

		$parentForm.find('#old_logo').val('{remove}').hide();
		$parentForm.find('input[type=file]').css({ display: 'block' });
	});
});