<script>
    let calendar;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'litera', // Changed to 'litera'
            locale: 'es', // Establecer el idioma español
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista'
            },
            events: '{{ route("calendar.getEvents") }}',
            dateClick: function(info) {
                const existingEvent = calendar.getEvents().find(event => 
                    event.startStr === info.dateStr
                );
                
                if (existingEvent) {
                    handleEventEdit(existingEvent);
                } else {
                    addAmount(info.dateStr);
                }
            },
            eventDidMount: function(info) {
                info.el.title = `Monto: $${info.event.extendedProps.amount}\n${info.event.extendedProps.description}`;
            }
        });
        calendar.render();
    });

    const handleEventEdit = (event) => {
        const today = new Date();
        const eventDate = new Date(event.start);
        
        // Comparar solo las fechas (ignorando las horas)
        const isToday = today.toISOString().split('T')[0] === eventDate.toISOString().split('T')[0];
        
        if (!isToday) {
            Swal.fire({
                icon: 'error',
                title: 'No permitido',
                text: 'Solo puedes editar montos del día actual'
            });
            return;
        }

        Swal.fire({
            title: 'Editar monto',
            icon: 'info',
            input: 'number',
            inputValue: event.extendedProps.amount,
            inputAttributes: {
                step: 'any'
            },
            confirmButtonText: 'Actualizar',
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                updateAmount(event, parseFloat(result.value).toFixed(2));
            }
        });
    };

    const updateAmount = (event, newAmount) => {
        fetch('{{ route("calendar.updateAmount") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                amount: newAmount,
                id: event.id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {                
                event.setProp('title', `$${newAmount}`);
                event.setExtendedProp('amount', newAmount);
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'El monto ha sido actualizado'
                });
            } else {
                throw new Error(data.message || 'Error al actualizar el monto');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'No se pudo actualizar el monto'
            });
        });
    };

    const addAmount = (selectedDate) => {
    Swal.fire({
        title: 'Agregar monto',
        text: 'Ingrese el monto para este día',
        icon: 'info',
        input: 'number',
        inputAttributes: {
            step: 'any', // Permite decimales
            min: '0', // No permite números negativos
            required: true
        },
        inputValidator: (value) => {
            if (!value) {
                return 'Debe ingresar un monto';
            }
            if (value < 0) {
                return 'El monto no puede ser negativo';
            }
            if (value > 1000000) {
                return 'El monto es demasiado alto';
            }
        },
        showCancelButton: true,
        confirmButtonText: 'Agregar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            const amount = parseFloat(result.value).toFixed(2);
            
            fetch('{{ route("calendar.addAmount") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    amount: amount,
                    date: selectedDate,
                    title: `$${amount}`,
                    description: 'Monto agregado para este día'
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    calendar.addEvent({
                        id: data.data.id,
                        title: `$${amount}`,
                        start: selectedDate,
                        color: data.data.color,
                        extendedProps: {
                            description: data.data.description,
                            amount: amount
                        }
                    });
                    
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'El monto ha sido agregado correctamente',
                        icon: 'success',
                        confirmButtonColor: '#28a745',
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else {
                    throw new Error(data.message || 'Error al agregar el monto');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: error.message || 'No se pudo agregar el monto',
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    });
};
</script>