<x-app-layout :assets="$assets ?? []">
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Создать тикет</h4>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.ticket.store') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Имя</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ auth()->user()->first_name ?? '' }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ auth()->user()->email ?? '' }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="title">Заголовок</label>
                        <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="message">Сообщение</label>
                        <textarea name="message" class="form-control" id="message" rows="5" required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Отправить</button>
                    <a href="{{ url()->previous() }}" class="btn btn-danger">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
