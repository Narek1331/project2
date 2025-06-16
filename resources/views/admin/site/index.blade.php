<x-app-layout :assets="$assets ?? []">
    <div class="container-fluid content-inner mt-5 py-0" >
        <div>
            {{ env('APP_URL') . '/pdf-editor?token=' . auth()->user()->token }}
        </div>
        <div class="d-flex justify-content-end">
            <div class="d-flex justify-content-between" style="width: 300px;">
                <a href="{{ route('admin.site.create') }}" class="btn btn-primary">
                    Создать
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#firstModal">
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
                                                <th>URL</th>
                                                <th>Ключевых слов</th>
                                                <th>Стоимость в сутки </th>
                                                <th>Клики/Час </th>
                                                <th>Клики/Сегодня </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sites as $site)
                                                <tr>
                                                    <td>{{ $site->domain }}</td>
                                                    <td>{{ $site->keywords->count() ?? 0 }}</td>
                                                    <td>{{ $adminParam->one_click_price * $site->keywords->sum('clicks_per_day') }}</td>
                                                    <td>{{ $site->click_in_hour ?? 0 }}</td>
                                                    <td>{{ $site->click_per_day ?? 0 }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a class="btn" href="{{ route('admin.site.edit',['id'=>$site->id]) }}">Изменить </a>
                                                            <form method="POST" action="{{ route('admin.site.update-status',['id'=>$site->id]) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="text" name="status" value="1" hidden>
                                                                <button class="btn">
                                                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                            <path d="M16.6308 13.131C16.5743 13.189 16.3609 13.437 16.1622 13.641C14.9971 14.924 11.9576 17.024 10.3668 17.665C10.1252 17.768 9.51437 17.986 9.18802 18C8.8753 18 8.5772 17.928 8.29274 17.782C7.93814 17.578 7.65368 17.257 7.49781 16.878C7.39747 16.615 7.2416 15.828 7.2416 15.814C7.08573 14.953 7 13.554 7 12.008C7 10.535 7.08573 9.193 7.21335 8.319C7.22796 8.305 7.38383 7.327 7.55431 6.992C7.86702 6.38 8.47784 6 9.13151 6H9.18802C9.61374 6.015 10.509 6.395 10.509 6.409C12.0141 7.051 14.9834 9.048 16.1768 10.375C16.1768 10.375 16.5129 10.716 16.659 10.929C16.887 11.235 17 11.614 17 11.993C17 12.416 16.8724 12.81 16.6308 13.131Z" fill="currentColor"></path></svg>
                                                                </button>
                                                            </form>
                                                            <form method="POST" action="{{ route('admin.site.update-status',['id'=>$site->id]) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="text" name="status" value="0" hidden>
                                                                <button class="btn">
                                                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M6 5H10V19H6V5Z" fill="currentColor"/>
                                                                        <path d="M14 5H18V19H14V5Z" fill="currentColor"/>
                                                                    </svg>
                                                                </button>
                                                            </form>

                                                            <form method="POST" action="{{ route('admin.site.delete',['id'=>$site->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn">
                                                                    <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path opacity="0.4" d="M19.643 9.48851C19.643 9.5565 19.11 16.2973 18.8056 19.1342C18.615 20.8751 17.4927 21.9311 15.8092 21.9611C14.5157 21.9901 13.2494 22.0001 12.0036 22.0001C10.6809 22.0001 9.38741 21.9901 8.13185 21.9611C6.50477 21.9221 5.38147 20.8451 5.20057 19.1342C4.88741 16.2873 4.36418 9.5565 4.35445 9.48851C4.34473 9.28351 4.41086 9.08852 4.54507 8.93053C4.67734 8.78453 4.86796 8.69653 5.06831 8.69653H18.9388C19.1382 8.69653 19.3191 8.78453 19.4621 8.93053C19.5953 9.08852 19.6624 9.28351 19.643 9.48851Z" fill="currentColor"></path>                                <path d="M21 5.97686C21 5.56588 20.6761 5.24389 20.2871 5.24389H17.3714C16.7781 5.24389 16.2627 4.8219 16.1304 4.22692L15.967 3.49795C15.7385 2.61698 14.9498 2 14.0647 2H9.93624C9.0415 2 8.26054 2.61698 8.02323 3.54595L7.87054 4.22792C7.7373 4.8219 7.22185 5.24389 6.62957 5.24389H3.71385C3.32386 5.24389 3 5.56588 3 5.97686V6.35685C3 6.75783 3.32386 7.08982 3.71385 7.08982H20.2871C20.6761 7.08982 21 6.75783 21 6.35685V5.97686Z" fill="currentColor"></path>
                                                                    </svg>
                                                                </button>
                                                            </form>

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
