$('.delete-selected').on('click', function () {
  var sure = confirm('Удалить записи?');
  if (!sure) {
    return;
  }
  var keys = $('#w0').yiiGridView('getSelectedRows');
  var data = {};
  data.ids = {};
  for (var i = 0; i < keys.length; i++) {
    data.ids[i] = keys[i];
  }
  data.redirect = location.href;
  $.ajax({
    //url: 'index.php?r=lesson/delete-selected',
    url: 'delete-selected',
    type: 'POST',
    data: data,
    success: function (data) {
      //console.log('success');
      //console.log(data);
    },
    error: function () {
      //console.log('error');
      //console.log(data);
    }
  });
});

$('.copy-selected').on('click', function () {
  var keys = $('#w0').yiiGridView('getSelectedRows');
  var data = {};
  data.ids = {};
  for (var i = 0; i < keys.length; i++) {
    data.ids[i] = keys[i];
  }
  data.redirect = location.href;
  $.ajax({
    //url: 'index.php?r=lesson/copy-selected',
    url: '/lesson/copy-selected',
    type: 'POST',
    data: data,
    success: function (data) {
      //console.log('success');
      //console.log(data);
    },
    error: function (data) {
      //console.log('error');
      //console.log(data);
    }
  });
});
$('#w0').on('click', '.actionClick', function (event) {
  var td = $(event.target).closest('td');
  if ($(td).hasClass('date')) {
    var className = 'ajaxChange';
    var action = 'date-change';
    var type = 'date';
  } else if ($(td).hasClass('time')) {
    var className = 'ajaxChange';
    var action = 'time-change';
    var type = 'time';
  }
  var id = $(event.target).closest('tr').data('key');
  var td = $(event.target).closest('td');
  $(td).removeClass('actionClick');
  var content = $(td).text();
  /*var date = new Date(content);
  var month = date.getMonth()+1;
  var newdate = date.getFullYear() + '-'
    + (month < 10 ? '0' : '') + month + '-'
    + date.getDate();*/
  $(td).html('<input style="width:200px;" type="' + type + '" class="form-control ' + className + '" data-action="' + action + '" data-id="' + id + '" value="' + content + '">');
  $(td).find('input').focus();
  //console.log(id);
  //console.log(event.target);
});

$('#w0').on('blur', '.ajaxChange', function (event) {
  var id = $(event.target).data('id');
  var action = $(event.target).data('action');
  var value = $(event.target).val();
  var td = $(event.target).closest('td');
  var data = {};
  data.id = id;
  data.value = value;
  data.redirect = location.href;
  $.ajax({
    url: '/lesson/' + action,
    //url: 'index.php?r=lesson/' + action,
    type: 'POST',
    data: data,
    success: function (data) {
      $(td).addClass('actionClick');
      $(td).html(value);
    },
    error: function (data) {
      //console.log('error');
      //console.log(data);
    }
  });
});
// $('#Lessonsearch-date_start').daterangepicker();