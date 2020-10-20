$('#btnUpdateUser').on('click', function(e) {
	e.preventDefault();

	$btn = $(this);

	loadingBtn($btn, true);

	axios.patch(window.location.href, {
		name: $('[name=name]').val(),
		email: $('[name=email]').val(),
		password: $('[name=password]').val(),
		password_confirmation: $('[name=password_confirmation]').val()
	})
	.then(response => {
		console.log(response.data);
		window.location = response.data.redirect;
	})
	.catch(error => {
		console.log(error.response);

		loadingBtn($btn, false);
		dispatchErrorMessages(error.response.data.errors);
	});
});

$('#btnDeleteAccount').on('click', function(e) {
	e.preventDefault();

	Swal.fire({
		icon: 'error',
		iconHtml: '<i class="fas fa-trash-alt"></i>',
		title: 'Tem certeza?',
		html: '<div class="text-center">Sua conta não poderá ser recuperada</div>',
		showCancelButton: true,
		confirmButtonText: 'Tenho',
		cancelButtonText: 'Cancelar'
	})
	.then(result => {
		if (result.isConfirmed) {
			axios.delete(window.location.href + '/deletar')
				.then(response => {
					window.location = response.data.redirect;
				})
				.catch(error => {
					console.log(error.response);
				});	
		}
	});
});