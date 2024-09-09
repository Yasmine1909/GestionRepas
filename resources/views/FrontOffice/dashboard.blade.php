

@extends('FrontOffice.layouts.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


<style>
    body {
        background-color: #f5f5f5;
        font-family: 'Helvetica Neue', sans-serif;
        color: #333;
    }
    .container {
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }
    .calendar {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 1px;
        background-color: #f8f9fa;
        border-radius: 10px;
        overflow: hidden;
        border: none;
        margin-top: 30px;
        max-width: 80%;
        max-height: 50%;
    margin: 0 auto;
    }
    h1 {
        color: #0d4a75;
        font-weight: bold;
        font-size: 2.5rem;
    }
    .calendar div {
    padding: 10px;
    text-align: center;
    background-color: #ffffff;
    transition: background-color 0.3s, color 0.3s;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.85rem; /* Réduire la taille de la police pour plus de compacité */
}

    .calendar .header {
        background-color: #0d4a75;
        color: #ffffff;
        font-weight: bold;
        padding: 10px 5px;
    }
    .calendar .clickable {
        cursor: pointer;
    }
    .calendar .clickable:hover {
        background-color: #e0a800;
        color: #ffffff;
    }
    .calendar .disabled {
        background-color: #e9ecef;
        color: #adb5bd;
    }
    .calendar .download {
        background-color: #007bff;
        color: #ffffff;
        cursor: pointer;
        text-align: center;
        padding: 10px;
        transition: background-color 0.3s;
    }
    .calendar .download:hover {
        background-color: #0056b3;
    }
    .modal-body {
        padding: 2rem;
    }
    .modal-header {
        background-color: #007bff;
        color: #ffffff;
        border-bottom: 1px solid #dee2e6;
    }
    .modal-footer {
        border-top: 1px solid #dee2e6;
    }
    .plat-info {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 10px;
    }
    .btn-custom {
        background-color: #007bff;
        color: #ffffff;
        transition: background-color 0.3s;
    }
    .btn-custom, .reserve-week-btn {
        /* position: relative; */
    /* bottom: 10px; /* Ajustez selon vos besoins */
    /* right: 1140px;  Ajustez selon vos besoins */
    background-color: #0056b3;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 50px;
    transition: background-color 0.3s;
    margin-right: 80px; /* Espace entre le bouton et les icônes */
    margin-left:100px;
    }
    .reserve-week-btn:hover {
        background-color: #007bff;
    }
    .btn-custom:hover {
        background-color: #0056b3;
    }
    .btn-secondary-custom {
        background-color: #6c757d;
        color: #ffffff;
        transition: background-color 0.3s;
    }
    .btn-secondary-custom:hover {
        background-color: #565e64;
    }
    .btn-success-custom {
        background-color: #28a745;
        color: #ffffff;
        transition: background-color 0.3s;
    }
    .btn-success-custom:hover {
        background-color: #218838;
    }
    .btn-danger-custom {
        background-color: #dc3545;
        color: #ffffff;
        transition: background-color 0.3s;
    }
    .btn-danger-custom:hover {
        background-color: #c82333;
    }
    .calendar .current-week {
        background-color: #d1ecf1; /* Couleur pour la semaine actuelle */
        color: #0c5460; /* Couleur du texte pour la semaine actuelle */
    }
    .calendar .next-week {
        background-color: #d4edda; /* Couleur pour la semaine suivante */
        color: #155724; /* Couleur du texte pour la semaine suivante */
    }
    .calendar .reserved {
        background-color: #ffc107; /* Couleur pour les jours réservés */
        color: #ffffff;
    }
    .calendar .clickable-next-week {
    cursor: pointer;
}
.calendar .clickable-next-week:hover {
    background-color: #e0a800;
    color: #ffffff;
}
    .calendar .reserved-next-week {
    background-color: #ffc107; /* Couleur orange pour les jours réservés de la semaine suivante */
    color: #ffffff;
}



    .calendar .reserved {
        background-color: #ffc107; /* Couleur pour les jours réservés */
        color: #ffffff;
    }
    .calendar .clickable {
        cursor: pointer;
    }
    .calendar .clickable:hover {
        background-color: #e0a800;
        color: #ffffff;
    }
    .calendar .disabled {
        background-color: #f1f1f1;
        color: #c0c0c0;
    }
    .btn-danger-custom {
        background-color: #dc3545;
        color: #ffffff;
        transition: background-color 0.3s;
    }
    .btn-danger-custom:hover {
        background-color: #c82333;
    }
    .btn-success-custom {
        background-color: #28a745;
        color: #ffffff;
        transition: background-color 0.3s;
    }
    .btn-success-custom:hover {
        background-color: #218838;
    }
    .icon-list {
    display: flex;
    gap: 20px; /* Espacement entre chaque icône */
}
    .icon-legend {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        justify-content: flex-start;
    }
    .icon-legend div {
        margin: 0 15px;
        text-align: center;
    }
    .icon-legend i {
        font-size: 24px;
        margin-bottom: 5px;
    }
    .icon-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}
    .calendar .weekend {
    background-color: #7f8f9e; /* Gris foncé */
    color: #ffffff;
}
.btn-disabled {
    background-color: grey;
    cursor: not-allowed;
}


</style>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>




<div class="container" style="margin-top: 10%; margin-bottom: 5%; position: relative;">

    <h1 class="text-center mb-4">Réservations de Repas</h1>


    <div class="calendar">
<div class="header">Lun</div>
<div class="header">Mar</div>
<div class="header">Mer</div>
<div class="header">Jeu</div>
<div class="header">Ven</div>
<div class="header ">Sam</div>
<div class="header ">Dim</div>
<div class="header">Télécharger Le Menu</div>


@foreach ($calendarDays->chunk(8) as $week)
    @foreach ($week as $day)
        @php
            $dateString = $day->format('Y-m-d');
            $jour = $jours->get($dateString);
            $plats = $jour ? $jour->plats->pluck('titre')->implode(', ') : '';
            $isReservableWeek = $day->between($currentWeekStart, $currentWeekEnd);
            $reservation = $reservations->firstWhere('date', $dateString);
            $isReserved = !is_null($reservation);
            $hasPlats = !empty($plats);
            $dayClass = '';

            // if ($day->isSaturday() || $day->isSunday()) {
            //     $dayClass .= 'weekend ';
            // }

            if ($isReservableWeek) {
                $dayClass .= 'reservable-week ';
                if ($isReserved) {
                    $dayClass .= 'reserved ';
                }
                if ($hasPlats) {
                    $dayClass .= 'clickable';
                } else {
                    $dayClass .= 'disabled';
                }
            } else {
                $dayClass .= 'disabled';
            }


            $icon = '';
            if ($isReserved) {
    if ($reservation->status === 'available') {
        $icon = '<i class="fas fa-check-circle mt-1 fa-2x" style="color: green;"></i>'; // Taille agrandie à 2x
    } elseif ($reservation->status === 'unavailable') {
        switch ($reservation->reason) {
            case 'Déplacement':
                $icon = '<i class="fas fa-car mt-1 fa-2x" style="color: rgb(97, 74, 4);"></i>'; // Taille agrandie à 2x
                break;
            case 'Congé':
                $icon = '<i class="fas fa-umbrella-beach mt-1 fa-2x" style="color: rgb(97, 74, 4);"></i>'; // Taille agrandie à 2x
                break;
            case 'Régime':
                $icon = '<i class="fas fa-apple-alt mt-1 fa-2x" style="color: rgb(97, 74, 4);"></i>'; // Taille agrandie à 2x
                break;
            default:
                $icon = '<i class="fas fa-times-circle mt-1 fa-2x" style="color: gray;"></i>'; // Taille agrandie à 2x
                break;
        }
    }
}

        @endphp
        <div class="{{ $dayClass }}"
            data-date="{{ $dateString }}"
            data-plats="{{ $plats }}"
            data-status="{{ $reservation ? $reservation->status : 'available' }}"
            data-reason="{{ $reservation ? $reservation->reason : '' }}">
            {{ $day->day }}
            @if ($plats)
                <div class="plat-info">{{ $plats }}</div>
            @endif

            {!! $icon !!}
        </div>

        @if ($day->isSunday())
            @php
                $weekStartDate = $day->copy()->startOfWeek()->format('Y-m-d');
            @endphp
            <div class="download-container d-flex justify-content-center my-4">
                <a href="{{ route('download.menu', $weekStartDate) }}"
                class="btn download-btn d-flex justify-content-center align-items-center"
                style="width: 60px; height: 60px; border-radius: 50%; background-color: orange; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease;">
                    <i class="fa-regular fa-file-pdf" style="font-size: 24px; color: #ffffff;"></i>
                </a>
            </div>
        @endif
    @endforeach
@endforeach

    </div>
    <div class="icon-legend">
        <button class="reserve-week-btn" id="reserveWeekBtn">Réserver Toute La Semaine</button>
        <div id="processingMessage" class="alert alert-info" style="display: none;">Votre Opération est en cours veuillez attendre...</div>

        <div class="icon-list">
            <div class="icon-item">
                <i class="fas fa-check-circle" style="color: green;"></i>
                <div>Disponible</div>
            </div>
            <div class="icon-item">
                <i class="fas fa-umbrella-beach" style="color: rgb(97, 74, 4);"></i>
                <div>Congé</div>
            </div>
            <div class="icon-item">
                <i class="fas fa-car" style="color: rgb(97, 74, 4);"></i>
                <div>Déplacement</div>
            </div>
            <div class="icon-item">
                <i class="fas fa-apple-alt" style="color: rgb(97, 74, 4);"></i>
                <div>Régime</div>
            </div>
        </div>
    </div>


</div>


<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">Menu du Jour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Date:</strong> <span id="menuDate"></span></p>
                <p><strong>Plat:</strong> <span id="menuPlats"></span></p>
                <p><strong>Status:</strong></p>
                <div id="reservationOptions">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="available" id="availableRadio">
                        <label class="form-check-label" for="availableRadio">Disponible</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" value="unavailable" id="notAvailableRadio">
                        <label class="form-check-label" for="notAvailableRadio">Non Disponible</label>
                    </div>
                    <div id="nonAvailabilityReason" style="display: none; margin-top: 10px;">
                        <p><strong>Motif de non disponibilité:</strong></p>
                        <select class="form-control" id="reasonSelect">
                            <option value="Déplacement">Déplacement </option>
                            <option value="Congé">Congé </option>
                            <option value="Régime">Régime </option>
                        </select>
                    </div>
                </div>
                <p id="modalMessage" class="mt-3"></p> <!-- Ajout du message -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="reserveBtn" style="display: none;">Réserver</button>
                <button type="button" class="btn btn-danger" id="cancelButton" style="display: none;">Annuler Réservation</button>
            </div>
        </div>
    </div>
</div>




<script>
    let isProcessing = false;
    $(document).ready(function() {
      $('.clickable').on('click', function() {
          var date = $(this).data('date');
          var plats = $(this).data('plats');
          var status = $(this).data('status');
          var reason = $(this).data('reason');
          var isReserved = $(this).hasClass('reserved');

          $('#menuDate').text(date);
          $('#menuPlats').text(plats);

          if (isReserved) {
              $('#reservationOptions').hide();
              $('#reserveBtn').hide();
              $('#cancelButton').show();

              if (status === 'unavailable') {
                  $('#nonAvailabilityReason').show();
                  $('#reasonSelect').val(reason);
                  $('#modalMessage').text('Vous avez confirmé votre non disponibilité pour raison: ' + reason);
              } else {
                  $('#nonAvailabilityReason').hide();
                  $('#modalMessage').text('Vous avez confirmé votre disponibilité');
              }
          } else {
              $('#reservationOptions').show();
              $('#reserveBtn').show();
              $('#cancelButton').hide();
              $('#nonAvailabilityReason').hide();
              $('#modalMessage').text('');
          }

          $('#availableRadio').prop('checked', status === 'available');
          $('#notAvailableRadio').prop('checked', status === 'unavailable');

          $('#menuModal').modal('show');
      });


      $('input[name="status"]').change(function() {
          if ($(this).val() === 'unavailable') {
              $('#nonAvailabilityReason').show();
          } else {
              $('#nonAvailabilityReason').hide();
          }
      });

      $('#notAvailableRadio ').on('click', function() {
            // Modifier le texte du bouton "Réserver" en "Valider"
            $('#reserveBtn').text('Valider');
        });
        $('#availableRadio ').on('click', function() {
            // Modifier le texte du bouton "Réserver" en "Valider"
            $('#reserveBtn').text('Réserver');
        });

      $('#reserveBtn').on('click', function() {
          var date = $('#menuDate').text();
          var status = $('input[name="status"]:checked').val();
          var reason = $('#reasonSelect').val();

          $.ajax({
              url: '{{ route('reserve') }}',
              type: 'POST',
              data: {
                  date: date,
                  status: status,
                  reason: reason,
                  _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                  if (response.success) {
                      $('.calendar .clickable[data-date="' + date + '"]').addClass('reserved');
                      $('#modalMessage').text(status === 'available' ? 'Vous avez confirmé votre disponibilité' : 'Vous avez confirmé votre non disponibilité pour raison: ' + reason);
                      setTimeout(function() {
                        location.reload();
                    }, 1000);
                  }
                  $('#menuModal').modal('hide');
              },
              error: function(xhr) {
                  var errorMsg = 'Erreur lors de la réservation.';
                  if (xhr.responseJSON && xhr.responseJSON.message) {
                      errorMsg = xhr.responseJSON.message;
                  }
                  alert(errorMsg);
                  $('#menuModal').modal('hide');
              }
          });
      });

      $('#cancelButton').on('click', function() {
          var date = $('#menuDate').text();

          $.ajax({
              url: '{{ route("reservations.cancel") }}',
              type: 'POST',
              data: {
                  date: date,
                  _token: '{{ csrf_token() }}'
              },
              success: function(response) {
                  $('.calendar .clickable[data-date="' + date + '"]').removeClass('reserved');
                  $('#modalMessage').text('Votre réservation a été annulée.');

                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                  $('#menuModal').modal('hide');
              },
              error: function(response) {
                  console.error('Erreur:', response);
              }
          });
      });

$('#reserveWeekBtn').on('click', function() {
    var $button = $(this);
    var $message = $('#processingMessage');
    var reservableDays = [];

    $('.calendar .clickable.reservable-week').each(function() {
        var date = $(this).data('date');
        var plats = $(this).data('plats');
        if (plats) {
            reservableDays.push({
                date: date,
                plats: plats
            });
        }
    });

    if (reservableDays.length > 0) {
        // Griser le bouton et afficher le message
        $button.prop('disabled', true).addClass('btn-disabled'); // Ajouter la classe CSS
        $message.show();

        // Simuler une opération asynchrone (par exemple, une requête AJAX)
        setTimeout(function() {
            $.ajax({
                url: '{{ route('reserve.week') }}',
                type: 'POST',
                data: {
                    days: reservableDays,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        reservableDays.forEach(function(day) {
                            $('.calendar .clickable[data-date="' + day.date + '"]').addClass('reserved');
                        });
                        alert('Tous les jours disponibles pour la semaine ont été réservés.');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert('Erreur lors de la réservation de la semaine.');
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Erreur lors de la réservation.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                },
                complete: function() {
                    // Remettre le bouton dans son état initial et masquer le message
                    $button.prop('disabled', false).removeClass('btn-disabled'); // Retirer la classe CSS
                    $message.hide();
                }
            });
        }, 2000); // Simule un délai de 2 secondes pour l'opération
    } else {
        alert('Aucun jour disponible à réserver pour cette semaine.');
        // Remettre le bouton dans son état initial et masquer le message
        $button.prop('disabled', false).removeClass('btn-disabled'); // Retirer la classe CSS
        $message.hide();
    }
});





function handleReservation(response) {
    if (response.success) {
        alert(response.message);
        document.getElementById('message').innerHTML = `<div class="alert alert-success">${response.message}</div>`;
    } else {
        alert('Erreur : ' + response.message);
    }
}

function handleCancellation(response) {
    if (response.success) {
        alert(response.message);
        document.getElementById('message').innerHTML = `<div class="alert alert-success">${response.message}</div>`;
    } else {
        alert('Erreur : ' + response.message);
    }
}

function reserveDate(date) {
    fetch('/reserve', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ date: date })
    })
    .then(response => response.json())
    .then(data => handleReservation(data))
    .catch(error => console.error('Erreur:', error));
}

function cancelReservation(date) {
    fetch('/cancel', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ date: date })
    })
    .then(response => response.json())
    .then(data => handleCancellation(data))
    .catch(error => console.error('Erreur:', error));
}

  });
  </script>




@endsection
