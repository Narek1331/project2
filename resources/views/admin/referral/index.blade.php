<x-app-layout :assets="$assets ?? []">
    <div class="container-fluid content-inner mt-n5 py-0">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Моя реферальная система</h4>
                <button class="btn btn-primary" onclick="copyReferralLink()">Скопировать ссылку</button>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Ваша реферальная ссылка:</label>
                    <input type="text" class="form-control" id="referralLink"
                           value="{{ route('register', ['ref' => auth()->user()->referral_token]) }}" readonly>
                </div>

                <div class="row text-center mb-4">
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <h5 class="mb-0">{{ $referralsCount ?? 0 }}</h5>
                            <small>Приглашённых пользователей</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border rounded bg-light">
                            <h5 class="mb-0">{{ $referralEarnings ?? 0 }} ₽</h5>
                            <small>Доход с рефералов</small>
                        </div>
                    </div>
                </div>

                <h5>Список приглашённых пользователей:</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Дата регистрации</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($referrals as $index => $refUser)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $refUser->full_name }}</td>
                                    <td>{{ $refUser->email }}</td>
                                    <td>{{ $refUser->created_at->format('d.m.Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Нет приглашённых пользователей</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Copy to Clipboard Script --}}
    <script>
        function copyReferralLink() {
            const link = document.getElementById("referralLink");
            link.select();
            link.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert("Ссылка скопирована!");
        }
    </script>
</x-app-layout>
