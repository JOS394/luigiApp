<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        #calendar {
            font-size: 14px; 
        }
    }

    @media (max-width: 480px) {
        #calendar {
            font-size: 12px; 
        }
    }

    /* Botones verdes de calendario para todas las pantallas */
    .fc-direction-ltr .fc-button-group > .fc-button {
        font-size: 14px !important;
        background-color: green; /* Botones color verde */
        color: white; /* Texto en blanco para contraste */
    }

    .fc-direction-ltr .fc-button-group > .fc-button:not(:last-child) {
        margin-right: 5px; /* Espaciado entre botones */
    }

    .fc-direction-ltr .fc-toolbar > * > :not(:first-child) {
        margin-top: 10px;
    }
</style>