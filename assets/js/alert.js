 function hapus(href){
  swal({
    title: "Apakah anda yakin?",
    text: "Data yang dihapus tidak dapat dikembalikan!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      window.location = href
    }
  });
}

const success = $('.d-success').text(), error = $('.d-error').text(), warning = $('.d-warning').text(), message = $('.d-message').text();;

const messageObj = {
 title: "Berhasil!",
 text: message,
 icon: "success"
}

const successObj = {
 title: "Berhasil!",
 text: "Data berhasil " + success,
 icon: "success",
 timer : 1500,
 buttons : false
}

const warningObj = {
 title: "Perhatian!",
 text: warning,
 icon: "warning"
}

const errorObj = {
 title: "Error!",
 text:  error,
 icon: "error"
}

if (message != '') {
  swal(messageObj)
}
if (success != '') {
  swal(successObj)
}
if (warning != '') {
  swal(warningObj)
}
if (error != '') {
  swal(errorObj)
}