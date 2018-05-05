$('#btn-submit').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
swal.setDefaults({
  input: 'text',
  confirmButtonText: 'Next &rarr;',
  showCancelButton: true,
  animation: true,
  progressSteps: ['1', '2', '3']
})

var steps = [
  {
    title: 'Room Number',
    text: '',
    buttonsStyling: true

  },
  'Patient Name',
  'Status'
]

swal.queue(steps).then(function (result) {
  swal.resetDefaults()
  swal({
    title: 'All done!',
    html:
      'Your answers: <pre>' +
        JSON.stringify(result) +
      '</pre>',
    confirmButtonText: 'Lovely!'
  })
}, function () {
  swal.resetDefaults()
})
});

