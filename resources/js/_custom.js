$(document).on('focus', 'input, select', function() {
  $(this).removeClass('is-invalid')
    .next('.text-danger')
    .remove();
    
  $(this).parent().next('.text-danger').remove();
}); 

$(document).on('click', '.btn-today', function(e) {
  e.preventDefault();

  let date = new Date();
  let today = new Intl.DateTimeFormat('pt-BR').format(date);
  
  if (this.hasAttribute('data-target')) {
    $($(this).attr('data-target')).val(today);
  } else {
    $(this).parents('.input-group').find('input').val(today).focus();
  }

});

$('[data-toggle="tooltip"]').tooltip();

$('.clickable-link').on('mouseup', function(e) {
  let url = $(this).attr('data-url');

  if (e.which == 1) {
    window.location = url;
  }

  if (e.which == 2) {
    openInNewTab(url);
  }
});

$('[data-mask="money"]').each(function() {
  var formatter = new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  });

  $(this).text(formatter.format(($(this).text())));
});

$('[data-mask="date"]').each(function() {
  let date = $(this).text().split('-');
  let formatter = new Intl.DateTimeFormat('pt-BR');

  date = new Date(date[0], date[1] - 1, date[2]);

  $(this).text(formatter.format(date));
});