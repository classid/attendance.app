@extends('layouts.app')

@section('content')
  <div class="card">
    <h2 class="card-header">Daftar Mesin FingerPrint</h2>
    <div class="card-body">
      <table id="table" data-toggle="table" data-height="460" data-ajax="dataLookup" data-ajax-options="ajaxOptions"
             data-search="true" data-side-pagination="server" data-pagination="true"
             data-show-refresh="true">
        <thead>
          <tr>
            <th data-field="id">ID</th>
            <th data-field="name">Item Name</th>
            <th data-field="price">Item Price</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $.ajaxOptions = {
      beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + $('meta[name="authorizeToken"]').attr('content'));
      }
    };

    $(document).ready(function () {
      dataLookup = function (params) {
        var url = '{{ route('api.machine.lookup') }}';
        $.get(url + '?' + $.param(params.data)).then(function (res) {
          params.success(res)
        });
      }
    });
  </script>
@endpush
