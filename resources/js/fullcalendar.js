// resources/js/fullcalendar.js

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, interactionPlugin ],
        eventContent: function(arg) {
            // Fonction pour personnaliser le contenu et les styles de chaque événement
            return {
                html: '<b>' + arg.timeText + '</b><br/>' + arg.event.title,
                classList: ['custom-event'], // Classes CSS supplémentaires si nécessaires
                backgroundColor: '#ffffff', // Couleur de fond
                borderColor: '#2e6da4', // Couleur de la bordure
                textColor: '#000000' // Couleur du texte
            };
        },

        initialView: 'dayGridMonth', // Vue initiale du calendrier (mois par défaut)
        events: [
            // Liste d'exemples d'événements (à personnaliser selon vos besoins)
            { title: 'Event 1', start: '2024-07-15' },
            { title: 'Event 2', start: '2024-07-16' }
            // Ajoutez d'autres événements ici
        ]
    });

    calendar.render();
});
