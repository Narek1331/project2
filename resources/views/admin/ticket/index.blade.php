<style>
  table {
    /* table-layout: fixed; */
    width: inherit !important;
  }
</style>

<x-app-layout :assets="$assets ?? []">
  <div class="container-fluid content-inner mt-n5 py-0">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div class="header-title">
              <h4 class="card-title">Тикет</h4>
            </div>
          </div>
          <div class="card-body">
            <div class="custom-datatable-entries">
              <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap5">

                <div class="table-responsive border-bottom my-3">
                  <table
                    id="datatable"
                    class="table table-striped dataTable"
                    data-toggle="data-table"
                    aria-describedby="datatable_info"
                  >
                    <thead>
                      <tr>
                        <th
                          class="sorting sorting_asc"
                          tabindex="0"
                          aria-controls="datatable"
                          rowspan="1"
                          colspan="1"
                          style="width: 176.567px;"
                          aria-sort="ascending"
                        >
                          Имя
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="datatable"
                          rowspan="1"
                          colspan="1"
                          style="width: 279.65px;"
                        >
                          Email
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="datatable"
                          rowspan="1"
                          colspan="1"
                          style="width: 132.633px;"
                        >
                          Заголовок
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="datatable"
                          rowspan="1"
                          colspan="1"
                          style="width: 46.5333px;"
                        >
                          Сообщение
                        </th>
                        <th
                          class="sorting"
                          tabindex="0"
                          aria-controls="datatable"
                          rowspan="1"
                          colspan="1"
                          style="width: 46.5333px;"
                        >
                          Дата
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr class="odd">
                                <td class="sorting_1">{{ $ticket->name }}</td>
                                <td>{{ $ticket->email }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->message }}</td>
                                <td>{{ $ticket->created_at }}</td>
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
