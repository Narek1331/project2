<x-app-layout :assets="$assets ?? []">
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="card">
            <div class="row justify-content-center mt-4">
                <div class="col-md-8">

                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-primary text-white p-3 rounded-3">
                                <strong>{{ $ticket['name'] ?? 'Пользователь' }}</strong><br>
                                <small class="text-white-50">{{ $ticket['email'] }}</small>
                                <div class="mt-2">{{ $ticket['title'] }}</div>
                                <div class="mt-2">{{ $ticket['message'] }}</div>
                                <div class="text-end mt-1">
                                    <small>{{ \Carbon\Carbon::parse($ticket['created_at'])->format('d.m.Y H:i') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($ticket->messages as $message)
                        @if($message->user_id != auth()->user()->id)
                            <div class="d-flex justify-content-end mb-3">
                                <div class="ms-3">
                                    <div class="bg-light border p-3 rounded-3">
                                        <strong>Админ</strong><br>
                                        <div class="mt-2">{{ $message['message'] }}</div>
                                        <div class="text-end mt-1">
                                            <small>{{ \Carbon\Carbon::parse($message['created_at'])->format('d.m.Y H:i') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                             <div class="d-flex mb-3">
                                <div class="me-3">
                                    <div class="bg-primary text-white p-3 rounded-3">
                                        <strong>Я</strong><br>
                                        <div class="mt-2">{{ $message['message'] }}</div>
                                        <div class="text-end mt-1">
                                            <small>{{ \Carbon\Carbon::parse($message['created_at'])->format('d.m.Y H:i') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    {{-- Форма ответа --}}
                    <form method="POST" action="{{ route('ticket-messages.store') }}">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket['id'] }}">
                        <div class="mb-3">
                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Введите сообщение..." required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Отправить</button>
                        </div>
                    </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
