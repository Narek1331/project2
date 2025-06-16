<x-app-layout :assets="$assets ?? []">
    <div class="container py-4">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4">
        <h1 class="h2 mb-2 mb-sm-0">Баланс</h1>
        <!-- Можно добавить кнопки справа -->
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p class="text-muted mb-2">Текущий баланс</p>
            <h2 class="text-success fw-bold">₽ {{ number_format(auth()->user()->balance, 2) }}</h2>

            <!-- Кнопка вызова модального окна -->
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#topUpModal">
                Пополнить баланс
            </button>
        </div>
    </div>

    <div class="modal fade" id="topUpModal" tabindex="-1" aria-labelledby="topUpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.balance.top-up') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="topUpModalLabel">Пополнить баланс</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="topUpAmount" class="form-label">Сумма</label>
                            <input name="price" type="number" class="form-control" id="topUpAmount" min="0" placeholder="Введите сумму">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Пополнить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h3 class="h4 mt-5 mb-3">История транзакций</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Дата</th>
                    <th>Описание</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach (auth()->user()->balanceTransactions
                    ->where('status', true)
                    ->sortByDesc('created_at')
                        as $balanceTransaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $balanceTransaction->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $balanceTransaction->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">
                            @if ($balanceTransaction->type == 'increment')
                                +
                            @else
                                -
                            @endif
                            ₽{{ number_format($balanceTransaction->price, 2, '.', ' ') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-app-layout>
