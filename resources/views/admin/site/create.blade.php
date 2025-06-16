<x-app-layout :assets="$assets ?? []">
    <div class="card" >
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.site.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="form-label" for="domain">Домен <sup class="text-danger">*</sup></label>
                            <input required type="text" class="form-control" id="domain" name="domain">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="region">
                                Регион
                            </label>
                            <select class="form-select" id="region" name="region">
                                <option value="">Выберите регион</option>
                                @php
                                    $regions = [
                                        'Республики' => [
                                            'Республика Адыгея' => 'Республика Адыгея',
                                            'Республика Алтай' => 'Республика Алтай',
                                        ],
                                        'Края' => [
                                            'Алтайский край' => 'Алтайский край',
                                        ],
                                        'Области' => [
                                            'Амурская область' => 'Амурская область',
                                        ],
                                        'Города федерального значения' => [
                                            'Москва' => 'Москва',
                                        ],
                                        'Автономные округа' => [
                                            'Чукотский автономный округ' => 'Чукотский автономный округ',
                                        ],
                                        'Автономная область' => [
                                            'Еврейская автономная область' => 'Еврейская автономная область',
                                        ],
                                    ];
                                @endphp

                                @foreach($regions as $group => $items)
                                    <optgroup label="{{ $group }}">
                                        @foreach($items as $key => $value)
                                            <option value="{{ $value }}" >{{ $value }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="container mt-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ключевые слова</label>
                    </div>

                    <div id="repeater-container">
                        <div class="repeater-item border p-3 rounded mb-3 bg-light position-relative">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="keyword-name-1" class="form-label">Название <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" id="keyword-name-1" name="keywords[0][name]" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="keyword-url-1" class="form-label">URL</label>
                                    <input type="text" class="form-control" id="keyword-url-1" name="keywords[0][url]">
                                </div>

                                <div class="col-md-3">
                                    <label for="keyword-clicks-1" class="form-label">Кликов в день</label>
                                    <input type="number" min="0" class="form-control no-spinner" id="keyword-clicks-1" name="keywords[0][clicks_per_day]">
                                </div>

                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-item">Удалить</button>
                                </div>
                            </div>
                        </div>
                    </div>

    </div>

    <div class="d-flex justify-content-center">
        <button type="button" class="btn btn-primary" id="add-item">Добавить</button>
    </div>




                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="{{ route('admin.site') }}" type="submit" class="btn btn-danger">Отмена</a>
                    </form>
                </div>
            </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addBtn = document.getElementById('add-item');
    const container = document.getElementById('repeater-container');

    addBtn.addEventListener('click', function () {
        // Узнаём текущий индекс по количеству repeater-item
        const currentIndex = Math.floor(Math.random() * (1_000_000_000_000 - 100 + 1)) + 100;
        // const currentIndex = container.querySelectorAll('.repeater-item').length;

        // Создаем новый элемент с нужной разметкой, подставляя индекс currentIndex
        const newItem = document.createElement('div');
        newItem.classList.add('repeater-item', 'border', 'p-3', 'rounded', 'mb-3', 'bg-light', 'position-relative');
        newItem.innerHTML = `
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="keyword-name-${currentIndex}" class="form-label">Название <sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" id="keyword-name-${currentIndex}" name="keywords[${currentIndex}][name]" required>
                </div>

                <div class="col-md-4">
                    <label for="keyword-url-${currentIndex}" class="form-label">URL</label>
                    <input type="text" class="form-control" id="keyword-url-${currentIndex}" name="keywords[${currentIndex}][url]">
                </div>

                <div class="col-md-3">
                    <label for="keyword-clicks-${currentIndex}" class="form-label">Кликов в день</label>
                    <input type="number" min="0" class="form-control no-spinner" id="keyword-clicks-${currentIndex}" name="keywords[${currentIndex}][clicks_per_day]">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-item">Удалить</button>
                </div>
            </div>
        `;

        container.appendChild(newItem);
    });

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.repeater-item').remove();

        }
    });
});
</script>
