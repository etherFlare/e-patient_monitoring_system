  $(function () {

    $('#patient-table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
     $('#account-table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
    
});
  
    $(document).ready(function () {      
     $('#account-table tbody tr').click(function (event) {
 		   event.preventDefault();
   var form = $(this).parents('form');
swal({
  title: 'Accounts',
   type: 'info',
  showCancelButton: true,
  allowEnterKey: true,
  showCloseButton:true,
  showLoaderOnConfirm:true,
  confirmButtonText: 'Edit details!',
  cancelButtonText: 'Close!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: true,
  allowOutsideClick: false,
  html:
    '<input id="swal-input1" class="swal2-input" placeholder="Something">' +
    '<input id="swal-input2" class="swal2-input" placeholder="Something">'+
    '<input id="swal-input3" class="swal2-input" placeholder="Something">',
  preConfirm: function () {
    var form_data = {
      name: $('#swal-input1').val(),
      room: $('#swal-input2').val(),
      condition: $('#swal-input3').val()
    };
    return new Promise(function (resolve) {
      resolve({
        name: $('#swal-input1').val(),
        address: $('#swal-input2').val(),
        status: $('#swal-input3').val()
      })
    })
  },
  
  onOpen: function () {
    $('#swal-input1').focus()
  },
}).then(function (result) {
  swal(
    'Changes Saved!',
    'Account Deatails was saved :'+
    '<br>'+ result['name'] +'<hr>',
    'success'
  )
}, function (dismiss) {
  // dismiss can be 'cancel', 'overlay',
  // 'close', and 'timer'
  if (dismiss === 'cancel') {
    swal(
      'Cancelled',
      'Process Canceled',
      'error'
    )


  }

}).catch(swal.noop)
     });
     });	