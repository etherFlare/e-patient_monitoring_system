$('#btn-new-patient').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
swal({
  title: 'Add New Pateint',
   type: 'warning',
  showCancelButton: true,
  allowEnterKey: true,
  reverseButtons:true,
  showCloseButton:true,
  showLoaderOnConfirm:true,
  confirmButtonText: 'Yes, confir!m',
  cancelButtonText: 'No, cancel!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: true,
  allowOutsideClick: false,
  html:
    '<input id="swal-input1" class="swal2-input" placeholder="Name">' +
    '<input id="swal-input2" class="swal2-input" placeholder="Status">'+
    '<input id="swal-input3" class="swal2-input" placeholder="Description">',
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
    'Pateint Added!',
    'New Pateint was Added :'+
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

$('#btn-new-account').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
swal({
  title: 'Add New Account',
   type: 'warning',
  showCancelButton: true,
  allowEnterKey: true,
  reverseButtons:true,
  showCloseButton:true,
  showLoaderOnConfirm:true,
  confirmButtonText: 'Yes, confir!m',
  cancelButtonText: 'No, cancel!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: true,
  allowOutsideClick: false,
  html:
    '<input id="swal-input1" class="swal2-input" placeholder="Name">' +
    '<input id="swal-input2" class="swal2-input" placeholder="Role">'+
    '<input id="swal-input3" class="swal2-input" placeholder="Description">',
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
    'Account Added!',
    'New Account was Added :'+
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


$('#btn-new-role').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
swal({
  title: 'Add New Role',
   type: 'warning',
  showCancelButton: true,
  allowEnterKey: true,
  reverseButtons:true,
  showCloseButton:true,
  showLoaderOnConfirm:true,
  confirmButtonText: 'Yes, confir!m',
  cancelButtonText: 'No, cancel!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: true,
  allowOutsideClick: false,
  html:
    '<input id="swal-input1" class="swal2-input" placeholder="Name">' +
    '<input id="swal-input2" class="swal2-input" placeholder="Description">',
  preConfirm: function () {
    var form_data = {
      name: $('#swal-input1').val(),
      room: $('#swal-input2').val()
    };
    return new Promise(function (resolve) {
      resolve({
        name: $('#swal-input1').val(),
        address: $('#swal-input2').val()
      })
    })
  },
  
  onOpen: function () {
    $('#swal-input1').focus()
  },
}).then(function (result) {
  swal(
    'Role Added!',
    'New Role was Added :'+
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

$('#btn-new-unit').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
swal({
  title: 'Add New Unit',
   type: 'warning',
  showCancelButton: true,
  allowEnterKey: true,
  reverseButtons:true,
  showCloseButton:true,
  showLoaderOnConfirm:true,
  confirmButtonText: 'Yes, confir!m',
  cancelButtonText: 'No, cancel!',
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: true,
  allowOutsideClick: false,
  html:
    '<input id="swal-input1" class="swal2-input" placeholder="Unit Number">' +
    '<input id="swal-input2" class="swal2-input" placeholder="Room">'+
    '<input id="swal-input3" class="swal2-input" placeholder="Patient Number">',
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
    'Unit Added!',
    'New Unit was Added :'+
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
