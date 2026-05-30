$(document).ready(function() {
  $('#check-table tbody tr').click(function(event) {
    if (event.target.type !== 'checkbox' && !$(event.target).closest('.checkbox-wrapper').length) {
      $(':checkbox', this).trigger('click');
    }
  });
});
