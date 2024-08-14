

@extends('FrontOffice.layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    .calendar {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 1px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        max-width: 800px;
        margin: auto;
    }
    .calendar div {
        padding: 10px;
        text-align: center;
        border: 1px solid #dee2e6;
        background-color: #ffffff;
        transition: background-color 0.3s, color 0.3s;
    }
    .calendar .header {
        background-color: #007bff;
        color: #ffffff;
        font-weight: bold;
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
    .calendar .download {
        background-color: #28a745;
        color: #ffffff;
        cursor: pointer;
        text-align: center;
        transition: background-color 0.3s;
    }
    .calendar .download:hover {
        background-color: #218838;
    }
    .modal-body {
        padding: 1.5rem;
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
        margin-top: 5px;
    }
    .btn-custom {
        background-color: #007bff;
        color: #ffffff;
        transition: background-color 0.3s;
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
    .reserve-week-btn {
        position: absolute;
        left: -50px;
        top: 380px;

        background-color: #007bff;
        color: #ffffff;
        border: none;
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .reserve-week-btn:hover {
        background-color: #0056b3;
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
    .icon-legend {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .icon-legend div {
        margin: 0 15px;
        text-align: center;
    }
    .icon-legend i {
        font-size: 24px;
        margin-bottom: 5px;
    }
</style>
@section('content')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>




<div class="container" style="margin-top: 10%; margin-bottom: 5%; position: relative;">

    <h1 class="text-center mb-4">Réservations de Repas</h1>
    <button class="reserve-week-btn" id="reserveWeekBtn">Réserver Toute la Semaine</button>


    <div class="calendar">
        <!-- Headers for days of the week and download buttons -->
        <div class="header">Lun</div>
        <div class="header">Mar</div>
        <div class="header">Mer</div>
        <div class="header">Jeu</div>
        <div class="header">Ven</div>
        <div class="header">Sam</div>
        <div class="header">Dim</div>
        <div class="header">Télécharger</div>

        <!-- Generate calendar days -->
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

                    // Déterminer l'icône à afficher
                    $icon = '';
                    if ($isReserved) {
                        if ($reservation->status === 'available') {
                            $icon = '<i class="fas fa-check-circle mt-1" style="color: green;"></i>';
                        } elseif ($reservation->status === 'unavailable') {
                            switch ($reservation->reason) {
                                case 'Déplacement':
                                    $icon = '<i class="fas fa-car mt-1" style="color: rgb(97, 74, 4);"></i>';
                                    break;
                                case 'Congé':
                                    $icon = '<i class="fas fa-umbrella-beach mt-1" style="color: rgb(97, 74, 4);"></i>';
                                    break;
                                case 'Régime':
                                    $icon = '<i class="fas fa-apple-alt mt-1" style="color: rgb(97, 74, 4);"></i>';
                                    break;
                                default:
                                    $icon = '<i class="fas fa-times-circle mt-1" style="color: gray;"></i>';
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
                    <!-- Afficher l'icône -->
                    {!! $icon !!}
                </div>

                @if ($day->isSunday())
                    @php
                        $weekStartDate = $day->copy()->startOfWeek()->format('Y-m-d');
                    @endphp
                    <div class="download">
                        <a href="{{ route('download.menu', $weekStartDate) }}" class="btn btn-success download">Télécharger le Menu</a>
                    </div>
                @endif
            @endforeach
        @endforeach
    </div>
    <div class="icon-legend">
        <div>
            <i class="fas fa-check-circle" style="color: green;"></i>
            <div>Disponible</div>
        </div>
        <div>
            <i class="fas fa-umbrella-beach" style="color: rgb(97, 74, 4);"></i>
            <div>Congé</div>
        </div>
        <div>
            <i class="fas fa-car" style="color: rgb(97, 74, 4);"></i>
            <div>Déplacement</div>
        </div>
        <div>
            <i class="fas fa-apple-alt" style="color: rgb(97, 74, 4);"></i>
            <div>Régime</div>
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
    $(document).ready(function() {
      $('.clickable').on('click', function() {
          var date = $(this).data('date');
          var plats = $(this).data('plats');
          var status = $(this).data('status'); // Assurez-vous que ces données sont passées
          var reason = $(this).data('reason'); // Assurez-vous que ces données sont passées
          var isReserved = $(this).hasClass('reserved');

          $('#menuDate').text(date);
          $('#menuPlats').text(plats);

          if (isReserved) {
              $('#reservationOptions').hide();
              $('#reserveBtn').hide();
              $('#cancelButton').show();

              if (status === 'unavailable') {
                  $('#nonAvailabilityReason').show();
                  $('#reasonSelect').val(reason); // Prend la valeur de la raison de non-disponibilité
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

      // Option pour la raison de non-disponibilité
      $('input[name="status"]').change(function() {
          if ($(this).val() === 'unavailable') {
              $('#nonAvailabilityReason').show();
          } else {
              $('#nonAvailabilityReason').hide();
          }
      });

      // Gestion des boutons de réservation et d'annulation
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
                  $('#modalMessage').text('');
                  $('#menuModal').modal('hide');
              },
              error: function(response) {
                  console.error('Erreur:', response);
              }
          });
      });

      $('#reserveWeekBtn').on('click', function() {
    var reservableDays = [];

    $('.calendar .clickable.reservable-week').each(function() {
        var date = $(this).data('date');
        var plats = $(this).data('plats');
        if (plats) { // Vérifie qu'il y a bien un plat pour ce jour
            reservableDays.push({
                date: date,
                plats: plats
            });
        }
    });

    if (reservableDays.length > 0) {
        $.ajax({
            url: '{{ route('reserve.week') }}', // Créez cette route pour gérer la réservation de toute la semaine
            type: 'POST',
            data: {
                days: reservableDays,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Mettez à jour le calendrier pour afficher les jours réservés
                    reservableDays.forEach(function(day) {
                        $('.calendar .clickable[data-date="' + day.date + '"]').addClass('reserved');
                    });
                    alert('Tous les jours disponibles pour la semaine ont été réservés.');
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
            }
        });
    } else {
        alert('Aucun jour disponible à réserver pour cette semaine.');
    }
});



function handleReservation(response) {
    if (response.success) {
        alert(response.message); // Affiche 'Réservation Réussie'
        // Vous pouvez aussi afficher ce message dans un élément spécifique de votre page
        document.getElementById('message').innerHTML = `<div class="alert alert-success">${response.message}</div>`;
    } else {
        alert('Erreur : ' + response.message);
    }
}

function handleCancellation(response) {
    if (response.success) {
        alert(response.message); // Affiche 'Annulation Réussie'
        document.getElementById('message').innerHTML = `<div class="alert alert-success">${response.message}</div>`;
    } else {
        alert('Erreur : ' + response.message);
    }
}

// Exemple de fonction pour effectuer une réservation
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

// Exemple de fonction pour annuler une réservation
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

  {{-- <script> --}}
    {{-- $(document).ready(function() {
        $('.clickable').on('click', function() {
            var date = $(this).data('date');
            var plats = $(this).data('plats');
            var status = $(this).data('status'); // Assurez-vous que ces données sont passées
            var reason = $(this).data('reason'); // Assurez-vous que ces données sont passées
            var isReserved = $(this).hasClass('reserved');

            $('#menuDate').text(date);
            $('#menuPlats').text(plats);

            if (isReserved) {
                $('#reservationOptions').hide();
                $('#reserveBtn').hide();
                $('#cancelButton').show();

                if (status === 'unavailable') {
                    $('#nonAvailabilityReason').show();
                    $('#reasonSelect').val(reason); // Prend la valeur de la raison de non-disponibilité
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

        // Option pour la raison de non-disponibilité
        $('input[name="status"]').change(function() {
            if ($(this).val() === 'unavailable') {
                $('#nonAvailabilityReason').show();
            } else {
                $('#nonAvailabilityReason').hide();
            }
        });

        // Gestion des boutons de réservation et d'annulation
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
                    $('#modalMessage').text('Réservation annulée pour la date: ' + date);
                    $('#menuModal').modal('hide');
                },
                error: function(response) {
                    var errorMsg = 'Erreur lors de l\'annulation.';
                    if (response.responseJSON && response.responseJSON.message) {
                        errorMsg = response.responseJSON.message;
                    }
                    alert(errorMsg);
                    $('#menuModal').modal('hide');
                }
            });
        });
    });
    </script> --}}



@endsection
