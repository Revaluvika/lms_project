@extends('layouts.dashboard')
@section('title', 'Kalender Akademik')
@section('header', 'Kalender Akademik')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md">
    <div id="calendar"></div>
</div>

<!-- Modal Create/Edit Event -->
<div x-data="eventModal()">
    <x-modal name="event-modal" focusable>
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4" x-text="mode === 'create' ? 'Tambah Agenda' : 'Edit Agenda'"></h2>
            
            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Judul</label>
                    <input type="text" x-model="form.title" class="w-full border rounded px-3 py-2" required>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">Mulai</label>
                        <input type="datetime-local" x-model="form.start_date" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-2">Selesai</label>
                        <input type="datetime-local" x-model="form.end_date" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Tipe</label>
                    <select x-model="form.type" class="w-full border rounded px-3 py-2">
                        <option value="event">Event</option>
                        <option value="holiday">Hari Libur</option>
                        <option value="exam">Ujian</option>
                        <option value="meeting">Rapat</option>
                        <option value="other">Lainnya</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold mb-2">Deskripsi</label>
                    <textarea x-model="form.description" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" x-model="form.is_holiday" class="mr-2">
                        <span class="text-sm">Tandai sebagai Hari Libur Sekolah</span>
                    </label>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="button" @click="deleteEvent" x-show="mode === 'edit'" class="px-4 py-2 bg-red-500 text-white rounded">Hapus</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </x-modal>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route("academic.calendar.events") }}',
            selectable: true,
            editable: true,
            select: function(info) {
                // Open Create Modal
                window.dispatchEvent(new CustomEvent('open-event-modal', { 
                    detail: { 
                        mode: 'create', 
                        start: info.startStr, 
                        end: info.endStr 
                    } 
                }));
            },
            eventClick: function(info) {
                // Open Edit Modal
                window.dispatchEvent(new CustomEvent('open-event-modal', { 
                    detail: { 
                        mode: 'edit', 
                        event: info.event 
                    } 
                }));
            }
        });
        calendar.render();

        // Refresh calendar on save
        window.addEventListener('event-saved', () => {
            calendar.refetchEvents();
        });
    });

    function eventModal() {
        return {
            mode: 'create',
            eventId: null,
            form: {
                title: '',
                start_date: '',
                end_date: '',
                type: 'event',
                description: '',
                is_holiday: false
            },
            init() {
                window.addEventListener('open-event-modal', (e) => {
                    this.mode = e.detail.mode;
                    
                    if (this.mode === 'create') {
                        this.form = {
                            title: '',
                            start_date: e.detail.start + 'T08:00',
                            end_date: e.detail.end ? (new Date(new Date(e.detail.end).setDate(new Date(e.detail.end).getDate() -1))).toISOString().split('T')[0] + 'T09:00' : e.detail.start + 'T09:00',
                            type: 'event',
                            description: '',
                            is_holiday: false
                        };
                        this.eventId = null;
                    } else {
                        let event = e.detail.event;
                        this.eventId = event.id;
                        this.form = {
                            title: event.title,
                            start_date: event.start.toISOString().slice(0, 16),
                            end_date: event.end ? event.end.toISOString().slice(0, 16) : event.start.toISOString().slice(0, 16),
                            type: event.extendedProps.type,
                            description: event.extendedProps.description,
                            is_holiday: event.extendedProps.is_holiday
                        };
                    }

                    // Open the modal via existing component event
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'event-modal' }));
                });
            },
            closeModal() {
                window.dispatchEvent(new CustomEvent('close-modal', { detail: 'event-modal' }));
            },
            async submit() {
                let url = this.mode === 'create' ? '/academic/events' : '/academic/events/' + this.eventId;
                let method = this.mode === 'create' ? 'POST' : 'PUT';

                try {
                    let response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    });
                    
                    if (response.ok) {
                        this.closeModal();
                        window.dispatchEvent(new CustomEvent('event-saved'));
                        // Simple toast
                        alert('Agenda berhasil disimpan');
                    } else {
                        let error = await response.json();
                        alert('Error: ' + (error.message || 'Gagal menyimpan'));
                    }
                } catch (e) {
                    console.error(e);
                    alert('Terjadi kesalahan');
                }
            },
            async deleteEvent() {
                if (!confirm('Hapus agenda ini?')) return;
                
                try {
                    let response = await fetch('/academic/events/' + this.eventId, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (response.ok) {
                        this.closeModal();
                        window.dispatchEvent(new CustomEvent('event-saved'));
                    }
                } catch (e) {
                    console.error(e);
                }
            }
        }
    }
</script>
@endsection
