import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',    // Para archivos JavaScript
        './resources/js/**/*.vue',   // Si usas Vue.js
        './resources/js/**/*.jsx',   // Si usas React
        './node_modules/@fullcalendar/**/*.js',  // Para FullCalendar
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Puedes añadir colores personalizados para el calendario
            colors: {
                'calendar': {
                    'event': '#3788d8',     // Color para eventos
                    'header': '#2c3e50',    // Color para encabezados
                    'today': '#2ecc71',     // Color para el día actual
                },
            },
            // Configuración específica para el calendario
            minHeight: {
                'calendar': '500px',
            },
        },
    },

    plugins: [
        forms,
        // Puedes añadir más plugins si los necesitas
    ],

    // Si necesitas estilos específicos para FullCalendar
    safelist: [
        'fc',             // Clases de FullCalendar
        'fc-toolbar',
        'fc-header-toolbar',
        'fc-button',
        'fc-button-primary',
        'fc-today-button',
        'fc-prev-button',
        'fc-next-button',
        {
            pattern: /^fc-.+/,  // Esto incluirá todas las clases que empiecen con fc-
        },
    ],
};