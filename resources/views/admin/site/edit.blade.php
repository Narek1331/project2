<x-app-layout :assets="$assets ?? []">
    <div class="card" >
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.site.update',['id'=>$site->id]) }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="form-label" for="domain">Домен <sup class="text-danger">*</sup></label>
                            <input required type="text" class="form-control" id="domain" name="domain" value="{{ $site->domain }}">
                        </div>

                       <div class="row g-3">
                            <div class="col-md-6">
                                <label for="region" class="form-label">Регион</label>
                                <select id="region" name="region" class="form-select">
                                <option value="">Выберите регион</option>
                                <option value="{{ $site->domain }}">{{ $site->domain }}/option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">Город</label>
                                <select id="city" name="city" class="form-select">
                                <option value="{{ $site->city }}">{{ $site->city }}</option>
                                </select>
                            </div>
                        </div>


                        <div class="container mt-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ключевые слова</label>
                    </div>

                    <div id="repeater-container">
                        @foreach ($site->keywords as $num => $keyword)
                            <div class="repeater-item border p-3 rounded mb-3 bg-light position-relative">
                                <input type="text" name="keywords[{{ $num }}][id]" value="{{ $keyword['id'] }}" hidden>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="keyword-name-1" class="form-label">Название <sup class="text-danger">*</sup></label>
                                        <input value="{{ $keyword->name }}" type="text" class="form-control" id="keyword-name-1" name="keywords[{{ $num }}][name]" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="keyword-url-1" class="form-label">URL</label>
                                        <input value="{{ $keyword->url }}" type="text" class="form-control" id="keyword-url-1" name="keywords[{{ $num }}][url]">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="keyword-clicks-1" class="form-label">Кликов в день</label>
                                        <input value="{{ $keyword->clicks_per_day }}" type="number" min="0" class="form-control no-spinner" id="keyword-clicks-1" name="keywords[{{ $num }}][clicks_per_day]">
                                    </div>

                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-item">Удалить</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

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


<script>
document.addEventListener('DOMContentLoaded', function () {
    const regionSelect = document.getElementById('region');
    const citySelect = document.getElementById('city');

    const country = 'Russia';

    // Load regions (states) for Russia
    fetch('https://countriesnow.space/api/v0.1/countries/states', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ country })
    })
    .then(res => res.json())
    .then(data => {
        const states = data.data?.states || [];
        regionSelect.innerHTML = '<option value="">Выберите регион</option>';
        states.forEach(state => {
            const opt = document.createElement('option');
            opt.value = state.name;
            opt.textContent = state.name;
            regionSelect.appendChild(opt);
        });
    });

    // When a region is selected → load its cities
    regionSelect.addEventListener('change', () => {
        const state = regionSelect.value;
        citySelect.innerHTML = '<option value="">Загрузка...</option>';

        fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ country, state })
        })
        .then(res => res.json())
        .then(data => {
            const cities = data.data || [];
            citySelect.innerHTML = '<option value="">Выберите город</option>';
            cities.forEach(city => {
                const opt = document.createElement('option');
                opt.value = city;
                opt.textContent = city;
                citySelect.appendChild(opt);
            });
        });
    });
});
</script>
