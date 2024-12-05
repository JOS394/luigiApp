<x-app-layout>
    @include('calendar.style')
    <x-slot name="header">
        <div class="flex justify-center items-center">
            <h1 class="mb-0 text-blue-500">Calendario</h1>
        </div>
    </x-slot>

    <div class="container-fluid px-10 my-8">
        <div id='calendar' class="mx-4"></div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@include('calendar.script')
</x-app-layout>
