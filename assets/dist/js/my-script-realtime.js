  // Pusher JS
  
  // load icon animation
  var ajax_load = "<img src="+ location.origin +"/assets/img/makna2-loading.gif alt='loading...' width='50' class='mx-auto d-block' />";
  
  // awal load data
  $("#hasilCus4").html(ajax_load).load(location.href + "/cusdet")
  $("#hasilPro4").html(ajax_load).load(location.href + "/prodet")
  
  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = true

  var pusher = new Pusher('b7a2020658dd085fd51c', {
    cluster: 'ap1'
  });

  var channel = pusher.subscribe('ci3pusher-test');
  channel.bind('customer', function(data) {
    $("#totCus").text(data['total'])
    $("#hasilCus4").html(ajax_load).load(location.href + "/cusdet");
    toastr.success(data['message'])
    Push.create("Pesan MSM", {
      body: data.message,
      icon: location.origin+'/assets/img/makna2.png',
      timeout: 4000,
      onClick: function () {
        window.focus();
        this.close();
      }
    })
  })
  channel.bind('produk', function(data) {
    $("#totPro").text(data['total'])
    $("#hasilPro4").html(ajax_load).load(location.href + "/prodet");
    toastr.success(data['message'])
    Push.create("Pesan MSM", {
      body: data.message,
      icon: location.origin+'/assets/img/makna2.png',
      timeout: 4000,
      onClick: function () {
        window.focus();
        this.close();
      }
    })
  })
  channel.bind('distribusi', function(data) {
    $("#totDis").text(data['total'])
    toastr.success(data['message'])
    Push.create("Pesan MSM", {
      body: data.message,
      icon: location.origin+'/assets/img/makna2.png',
      timeout: 4000,
      onClick: function () {
        window.focus();
        this.close();
      }
    })
  })
  channel.bind('login', function(data) {
    if ($('#online-' + data['message']).hasClass('bg-success')) {
        $('#online-' + data['message']).removeClass('bg-success', 1000, "easeOutBounce")
    }else{
        $('#online-' + data['message']).addClass('bg-success', 1000, "easeOutBounce")
    }
    
    if ($('#status-' + data['message']).hasClass('d-none')) {
        $('#status-' + data['message']).removeClass('d-none')
    }else{
        $('#status-' + data['message']).addClass('d-none')
    }
    $("#totOn").text(data.total)
  })
  
  channel.bind('all', function(data) {
    toastr.info((data.nama != undefined ? data.nama : 'Pesan ') + ': ' + data.message)
    if(data.clear == 1) {
        $("#messageList").load(location.origin + "/home/chat")
        $("#countPesan").text('')
    }
  })
  // END PUSHER JS

  // ===============================================================================================================>>

  // NODE JS
  var socket = io('https://myservernode-app.herokuapp.com/', {
    secure: true,
    transports: ['websocket', 'polling']
  })

  // autofocus
  $('.modal').on('shown.bs.modal', function() {
    $(this).find('[autofocus]').focus();
  })

  // menghapus chat
  $("#truncteChat").on('click', function(e) {
    e.preventDefault()
    
    Swal.fire({
      title: 'Anda yakin?',
      text: "Data akan dihapus secara permanen dari database!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yakin!'
    }).then((result) => {
      if (result.value) {
        $(this).toggleClass('d-none')
        $('#btn-tr-loading').toggleClass('d-none')
        $.ajax({
          type: 'post',
          url: location.origin + "/home/truncateChat",
          data: "id="+1,
          success: function(data) {
            if (data == 1) {
              $("#messageList").load(location.origin + "/home/chat")
              $('#truncteChat').toggleClass('d-none')
              $('#btn-tr-loading').toggleClass('d-none')
              $("#countPesan").text('')
            } else {
              toastr.error('gagal', data)
            }
          }
        })
      }
    })
  })
  
//   delete pesan cookie pesan
  $("#contactChat").on('click', function() {
    let dataID = $("#message").prop('classList')
    $.ajax({
        type: 'post',
        url: location.origin + "/home/countlesschat",
        data: 'id='+dataID[1],
        success: function() {
            $("#countPesan").text('')
        }
    })
    if($('#staticBackdrop').hasClass('show')) {
        $("#messageList").animate({scrollTop: $('#messageList').get(0).scrollHeight}, 1000)
    }
  })

  // get data
  $("#messageList").load(location.origin + "/home/chat")
  socket.on('message', (param) => {
    $("#messageList").load(location.origin + "/home/chat")
    
    let dataID = $("#message").prop('classList')
    if (dataID[1] == param.id) {
      $("#message").val('')
    }else if(param.text){
        if(!$('#staticBackdrop').hasClass('show')) {
            $.ajax({
                type: 'post',
                url: location.origin + "/home/countchat",
                data: 'pesan='+param.pesanBaru,
                success: function(data) {
                    $('#countPesan').text(data)
                }
            })
        }
        
      toastr.info(param.text, param.nama.split("_").join(" "))
      play()
      Push.create(param.nama, {
      body: param.text,
      icon: location.origin+'/assets/img/makna2.png',
      timeout: 4000,
      onClick: function () {
        window.focus();
        this.close();
        }
      })
    }
    $("#messageList").animate({scrollTop: $('#messageList').get(0).scrollHeight}, 1000)
  })

  // send data
  $("#message").on('keyup', (e) => {
    let dataID = $("#message").prop('classList')
    if (e.which == 13) {
      socket.emit('message', {
        text: $("#message").val(),
        id: dataID[1],
        nama: dataID[2],
        pesanBaru: 1
      })
      $('#sendMessage').toggleClass('d-none')
      $('#btn-sd-loading').toggleClass('d-none')
      $.ajax({
        type: 'POST',
        url: location.origin + "/home/sendchat",
        data: {
          pesan: $("#message").val(),
          id: dataID[1],
          nama: dataID[2]
        },
        success: function(data) {
          if (data != 1) {
            toastr.error("Masukan pesan terlebih dahulu")
            $('#message').addClass('is-invalid', 300, "easeOutBounce")
            $('#message').attr("placeholder", "Pastikan kolom ini tidak kosong!!")
            $('#sendMessage').toggleClass('d-none')
            $('#btn-sd-loading').toggleClass('d-none')
          }else{
            $('#message').removeClass('is-invalid', 300, "easeOutBounce")
            $('#message').attr("placeholder", "Tulis pesan...")
            $('#sendMessage').toggleClass('d-none')
            $('#btn-sd-loading').toggleClass('d-none')
            $("#messageList").animate({scrollTop: $('#messageList').get(0).scrollHeight}, 1000)
          }
        },
        error: function() {
          toastr.error("gagal disimpan")
        }
      })
      
    }
    if($('#message').val() !== 0) {
      $('#message').removeClass('is-invalid')
      $('#message').attr("placeholder", "Tulis pesan...")  
    }
  })

  // send data tanpa menghapus input
  $("#sendMessage").click(() => {
    let dataID = $("#message").prop('classList')
    socket.emit('message', {
      text: $("#message").val(),
      id: dataID[1],
      nama: dataID[2],
      pesanBaru: 1
    })
    $('#sendMessage').toggleClass('d-none')
    $('#btn-sd-loading').toggleClass('d-none')
    $.ajax({
      type: 'POST',
      url: location.origin + "/home/sendchat",
      data: {
        pesan: $("#message").val(),
        id: dataID[1],
        nama: dataID[2]
      },
      success: function(data) {
        if (data != 1) {
          toastr.error("gagal disimpan")
          $('#message').addClass('is-invalid', 300, "easeOutBounce")
          $('#message').attr("placeholder", "Pastikan kolom ini tidak kosong!!")
          $('#sendMessage').toggleClass('d-none')
          $('#btn-sd-loading').toggleClass('d-none')
        }else{
          $('#sendMessage').toggleClass('d-none')
          $('#btn-sd-loading').toggleClass('d-none')
          $("#messageList").animate({scrollTop: $('#messageList').get(0).scrollHeight}, 1000)
        }
      },
      error: function() {
        toastr.error("gagal disimpan")
      }
    })
  })
  // END NODE JS