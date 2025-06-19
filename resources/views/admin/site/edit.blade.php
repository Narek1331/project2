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

                       <label for="region" class="form-label">Регион</label>
                        <div id="region-selects"></div>


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
    const container = document.getElementById('region-selects');
    const selectedRegionName = '{{ $site->region }}'; // выбранный регион из Blade

    async function fetchRegions() {
        const res = await fetch('/api/region');
        if (!res.ok) {
            alert('Ошибка загрузки регионов');
            return [];
        }
        const json = await res.json();
        return json.data || [];
    }

    function findPathToRegion(tree, targetName, path = []) {
        for (const region of tree) {
            const newPath = [...path, region];
            if (region.name === targetName) {
                return newPath;
            }
            const children = region.children_recursive || region.children || [];
            if (children.length > 0) {
                const result = findPathToRegion(children, targetName, newPath);
                if (result) return result;
            }
        }
        return null;
    }

    function createSelect(options, level = 0, selectedName = '') {
        const select = document.createElement('select');
        select.name = 'region';
        select.dataset.level = level;

        const defaultOption = document.createElement('option');
        defaultOption.text = 'Выберите регион';
        defaultOption.value = '';
        select.appendChild(defaultOption);

        options.forEach(region => {
            const option = document.createElement('option');
            option.value = region.name;
            option.textContent = region.name;
            option.dataset.children = JSON.stringify(region.children_recursive || region.children || []);
            if (region.name === selectedName) {
                option.selected = true;
            }
            select.appendChild(option);
        });

        select.addEventListener('change', onSelectChange);
        return select;
    }

    function onSelectChange(event) {
        const select = event.target;
        const level = parseInt(select.dataset.level);
        const selectedOption = select.options[select.selectedIndex];
        const children = selectedOption.dataset.children ? JSON.parse(selectedOption.dataset.children) : [];

        // Удаляем селекты с уровнем больше текущего
        const selects = container.querySelectorAll('select');
        selects.forEach(s => {
            if (parseInt(s.dataset.level) > level) {
                container.removeChild(s);
            }
        });

        if (children.length > 0) {
            const nextSelect = createSelect(children, level + 1);
            container.appendChild(nextSelect);
        }
    }

    async function init() {
        const regionsTree = await fetchRegions();
        if (!regionsTree.length) return;

        // Если есть выбранный регион — ищем путь к нему
        const path = selectedRegionName ? findPathToRegion(regionsTree, selectedRegionName) : null;

        if (path) {
            // Создаём селекты с выбранными значениями по пути
            for (let level = 0; level < path.length; level++) {
                const options = level === 0 ? regionsTree : (path[level - 1].children_recursive || path[level - 1].children || []);
                const selectedName = path[level].name;
                const select = createSelect(options, level, selectedName);
                container.appendChild(select);
            }
        } else {
            // Просто создаём первый селект, если выбранный регион не найден
            const firstSelect = createSelect(regionsTree, 0);
            container.appendChild(firstSelect);
        }
    }

    document.addEventListener('DOMContentLoaded', init);
</script>

