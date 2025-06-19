<style>
    table {
  /* table-layout:fixed; */
  width: inherit !important;
}

</style>

<x-app-layout :assets="$assets ?? []">
    <div class="container-fluid content-inner mt-5 py-0" >
        <div>
            {{ env('APP_URL') . '/pdf-editor?token=' . auth()->user()->token }}
        </div>
        <div class="d-flex justify-content-end">
            <div class="d-flex justify-content-between" style="width: 300px;">
                <a href="{{ route('admin.site.create') }}" class="btn btn-sm btn-primary">
                    Добавить сайт
                </a>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#firstModal">
                    Импорт Excel
                </button>

                <div class="modal fade" id="firstModal" tabindex="-1" aria-labelledby="firstModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="firstModalLabel">Импорт сайтов из Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="{{ route('admin.site.import-excel') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Выберите файл</label>
                                <input class="form-control" type="file" id="formFile" name="file">
                            </div>
                            <br>
                            <button class="btn btn-secondary mt-3" data-bs-toggle="modal" data-bs-target="#secondModal">
                                Импорт
                            </button>
                        </form>

                    </div>
                    </div>
                </div>
                </div>


            </div>
        </div>
        <div class="row" style="margin-top: 10px !important;">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-datatable-entries">
                            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap5">


                                <div class="table-responsive border-bottom my-3">
                                    <table id="datatable" class="table table-striped dataTable" data-toggle="data-table" aria-describedby="datatable_info">
                                        <thead>
                                            <tr>
                                                <th scope="col">URL</th>
                                                <th scope="col">Ключевых слов</th>
                                                <th scope="col">Стоимость в сутки </th>
                                                <th>Клики/Час </th>
                                                <th>Клики/Сегодня </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sites as $site)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <p>{{ $site->domain }}</p>
                                                            <span>{{ $site->region }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $site->keywords->count() ?? 0 }}</td>
                                                    <td>{{ $adminParam->one_click_price * $site->keywords->sum('clicks_per_day') }}</td>
                                                    <td>{{ $site->click_in_hour ?? 0 }}</td>
                                                    <td>{{ $site->click_per_day ?? 0 }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3 flex-nowrap">

                                                            {{-- Status Switch --}}
                                                        <form method="POST" action="{{ route('admin.site.update-status', ['id' => $site->id]) }}" class="m-0 p-0">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="form-check form-switch d-flex align-items-center m-0">
                                                                <input class="form-check-input" type="checkbox" id="switch1" onchange="this.form.submit()" @if ($site->status) checked @endif>
                                                                {{-- <label class="form-check-label ms-2 mb-0" for="switch1">Статус</label> --}}
                                                            </div>
                                                        </form>

                                                        {{-- Edit Button --}}
                                                        <a class="btn btn-outline-primary d-flex align-items-center justify-content-center p-2"
                                                        href="{{ route('admin.site.edit', ['id' => $site->id]) }}">
                                                            <svg class="icon-24" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                                    d="M16.6653 2.01034C18.1038 1.92043 19.5224 2.41991 20.5913 3.3989C21.5703 4.46779 22.0697 5.88633 21.9898 7.33483V16.6652C22.0797 18.1137 21.5703 19.5322 20.6013 20.6011C19.5323 21.5801 18.1038 22.0796 16.6653 21.9897H7.33487C5.88636 22.0796 4.46781 21.5801 3.39891 20.6011C2.41991 19.5322 1.92043 18.1137 2.01034 16.6652V7.33483C1.92043 5.88633 2.41991 4.46779 3.39891 3.3989C4.46781 2.41991 5.88636 1.92043 7.33487 2.01034H16.6653ZM10.9811 16.845L17.7042 10.102C18.3136 9.4826 18.3136 8.48364 17.7042 7.87427L16.4056 6.57561C15.7862 5.95625 14.7872 5.95625 14.1679 6.57561L13.4985 7.25491C13.3986 7.35481 13.3986 7.52463 13.4985 7.62453C13.4985 7.62453 15.0869 9.20289 15.1169 9.24285C15.2268 9.36273 15.2967 9.52256 15.2967 9.70238C15.2967 10.062 15.007 10.3617 14.6374 10.3617C14.4675 10.3617 14.3077 10.2918 14.1978 10.1819L12.5295 8.5236C12.4496 8.44368 12.3098 8.44368 12.2298 8.5236L7.46474 13.2887C7.13507 13.6183 6.94527 14.0579 6.93528 14.5274L6.87534 16.8949C6.87534 17.0248 6.9153 17.1447 7.00521 17.2346C7.09512 17.3245 7.21499 17.3744 7.34486 17.3744H9.69245C10.172 17.3744 10.6315 17.1846 10.9811 16.845Z"
                                                                    fill="currentColor"></path>
                                                            </svg>
                                                        </a>


                                                        {{-- Delete Button --}}
                                                        <form method="POST" action="{{ route('admin.site.delete', ['id' => $site->id]) }}" class="m-0 p-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-outline-danger d-flex align-items-center justify-content-center p-2" type="submit">
                                                                <svg class="icon-24" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path opacity="0.4"
                                                                        d="M19.643 9.48851C19.643 9.5565 19.11 16.2973 18.8056 19.1342C18.615 20.8751 17.4927 21.9311 15.8092 21.9611C14.5157 21.9901 13.2494 22.0001 12.0036 22.0001C10.6809 22.0001 9.38741 21.9901 8.13185 21.9611C6.50477 21.9221 5.38147 20.8451 5.20057 19.1342C4.88741 16.2873 4.36418 9.5565 4.35445 9.48851C4.34473 9.28351 4.41086 9.08852 4.54507 8.93053C4.67734 8.78453 4.86796 8.69653 5.06831 8.69653H18.9388C19.1382 8.69653 19.3191 8.78453 19.4621 8.93053C19.5953 9.08852 19.6624 9.28351 19.643 9.48851Z"
                                                                        fill="currentColor"></path>
                                                                    <path
                                                                        d="M21 5.97686C21 5.56588 20.6761 5.24389 20.2871 5.24389H17.3714C16.7781 5.24389 16.2627 4.8219 16.1304 4.22692L15.967 3.49795C15.7385 2.61698 14.9498 2 14.0647 2H9.93624C9.0415 2 8.26054 2.61698 8.02323 3.54595L7.87054 4.22792C7.7373 4.8219 7.22185 5.24389 6.62957 5.24389H3.71385C3.32386 5.24389 3 5.56588 3 5.97686V6.35685C3 6.75783 3.32386 7.08982 3.71385 7.08982H20.2871C20.6761 7.08982 21 6.75783 21 6.35685V5.97686Z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </button>
                                                        </form>



                                                        <p style="display: none">{{ $site->status }}</p>
                                                    </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
