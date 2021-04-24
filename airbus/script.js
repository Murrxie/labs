$(function () {
  $('#datetimepicker1').datetimepicker({
    locale: 'ru',
    format: 'DD.MM.yyyy',
  });
  $('#datetimepicker2').datetimepicker({
    locale: 'ru',
    format: 'DD.MM.yyyy',
  });
  let form = document.getElementsByClassName('search-form');
  Array.prototype.filter.call(form, function (form) {
    form.addEventListener('submit', function (event) {
      if (form.checkValidity() === false) {

      } else {
        let data = {
          'from': $('.search-form select[name=from]').val(),
          'to': $('.search-form select[name=to]').val(),
          'dateFrom': $('.search-form input[name=dateTo]').val(),
          'dateTo': $('.search-form input[name=dateBack]').val(),
          'count': $('.search-form input[name=count]').val(),
          'class': $('.search-form select[name=class]').val(),
        };
        $.post({
          url: './app/search.php?XDEBUG_SESSION_START=1',
          data: data,
          dataType: 'json'
        })
          .done(data => {
            let $resultBlock = $('.search-form .search-result');
            $resultBlock.html('');
            if (!data.length) {
              $resultBlock.append('<p class="noFoundTickets">Билеты по заданным критериям отсутствуют</p>');
              return;
            }
            let tickets = getAllTickets(data);
            $resultBlock.html(tickets);
          });
      }
      event.preventDefault();
      event.stopPropagation();
      form.classList.add('was-validated');
    }, false);
  });

  let ticketCreationForm = document.getElementsByClassName('ticket-creation-form');
  Array.prototype.filter.call(ticketCreationForm, function (form) {
    form.addEventListener('submit', function (event) {
      if (form.checkValidity() === false) {
      } else {
        let data = {
          'from': $('.ticket-creation-form select[name=from]').val(),
          'fromAirport': $('.ticket-creation-form select[name=fromAirport]').val(),
          'to': $('.ticket-creation-form select[name=to]').val(),
          'toAirport': $('.ticket-creation-form select[name=toAirport]').val(),
          'dateFrom': $('.ticket-creation-form input[name=dateTo]').val(),
          'dateTo': $('.ticket-creation-form input[name=dateBack]').val(),
          'count': $('.ticket-creation-form input[name=count]').val(),
          'class': $('.ticket-creation-form select[name=class]').val(),
          'price': $('.ticket-creation-form input[name=price]').val(),
        }
        $.post({
          url: '/app/admin/create.php?XDEBUG_SESSION_START=1',
          data: data,
          dataType: 'json',
        })
          .done(response => {
            alert(response['message']);
            if (response['success'] !== false) {
              document.location.reload();
            }
          })
      }
      event.preventDefault();
      event.stopPropagation();
      form.classList.add('was-validated');
    }, false);
  });

  $('#registrationForm').submit(event => {
    $('#loginModal').modal('hide');
    event.preventDefault();
    let formData = {
      'email': $('#registrationForm input[name=email]').val(),
      'password': $('#registrationForm input[name=password]').val(),
    }

    $.post({
      url: '/app/register.php',
      data: formData,
      dataType: 'json'
    })
      .done(data => {
        alert(data['message']);
        $('#registrationForm').trigger('reset');
      });

  })

  $('#loginForm').submit(event => {
    $('#loginModal').modal('hide');
    event.preventDefault();
    let formData = {
      'email': $('#loginForm input[name=loginEmail]').val(),
      'password': $('#loginForm input[name=loginPassword]').val(),
    }

    $.post({
      url: '/app/auth.php',
      data: formData,
      dataType: 'json'
    })
      .done(data => {
        if (data['success'] === true) {
          document.location.reload();
        }
        alert(data['message']);
      });

  })

  const $fromCity = $('#from');
  const $toCity = $('#to');

  $fromCity.on('change', event => {
    setAirports(event.target.value, '#fromAirport')
  });

  $toCity.on('change', event => {
    setAirports(event.target.value, '#toAirport');
  });

  $('#createModal').on('shown.bs.modal', function () {
    $fromCity.trigger('change');
    $toCity.trigger('change');
  })

});

const drawTicket = data => {
  return `<div class="ticketInfo">
    <p><b>Город отправки:</b>  ${data.fromCity}</p>
    <p><b>Аэропорт отправки:</b> ${data.airportFrom}</p>
    <p><b>Город прибытия:</b>  ${data.toCity}</p>
    <p><b>Аэропорт прибытия:</b>  ${data.airportTo}</p>
    <p><b>Класс:</b> ${data.class}</p>
    <p><b>Цена:</b> ${data.price} &#8381;</p>
    <p><b>Билетов в наличии:</b> ${data.count}</p>
    <button onclick="book(${data.id});return false;" class="btn btn-success">Купить</button>
    </div>`;
}

const getAllTickets = data => {
  return data
    .map(ticket => drawTicket(ticket))
    .join('')
}

const book = id => {
  $.post({
    url: './app/book.php',
    data: {
      id: id,
      count: $('.search-form input[name=count]').val(),
    },
    dataType: 'json'
  })
    .done(response => {
      if (response['success'] === false) {
        alert(response['message']);
        return;
      }
      alert('Билет куплен');
    })
}

const removeTicket = id => {
  $.post({
    url: './app/admin/remove.php?XDEBUG_SESSION_START=1',
    data: {
      id: id
    },
    dataType: 'json'
  })
    .done(response => {
      if (response['success'] === false) {
        alert(response['message']);
        return;
      }
      alert(response['message']);
      $(`[data-id="${id}"]`).remove();
    })
}

const setAirports = (id, selector) => {
  $.post({
    url: './app/admin/airports.php?XDEBUG_SESSION_START=1',
    data: {
      id: id
    },
    dataType: 'json',
  })
    .done(data => {
      updateAirports(selector, data);
    })
}

const updateAirports = (selector, data) => {
  const optionsSelector = selector + ' option';
  $(optionsSelector).remove();
  if (!data.length) {
    $(selector).append(new Option('Аэропорты отсутствуют', ''));
    return;
  }
  data.forEach(item => {
    $(selector).append(new Option(item.name, item.id));
  })
}


