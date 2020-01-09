@extends('layouts.app')

@section('content')
  <div class="card">
    <h2 class="card-header">Daftar Presensi</h2>
    <div class="card-body">
    </div>
    <table id="table" class="table table-striped table-hover">
      <thead>
      <tr>
        <th width="2%">#</th>
        <th>PIN</th>
        <th width="20%">Waktu</th>
        {{--<th width="5%">&nbsp;</th>--}}
      </tr>
      </thead>
      <tbody>
      @forelse($presences as $row)
        <tr>
          <td class="text-right">{{ $loop->iteration }}.</td>
          <td class="text-left">{{ $row->pin }}</td>
          <td class="text-left">{{ carbon($row->datetime)->isoFormat('L LTS') }}</td>
          {{--<td class="text-left text-nowrap">
            <button type="button" class="btn btn-warning btn-round btn-icon btn-sm btn-quick-href" data-href="{{ route('setup.machine.edit', ['machine' => $row->id]) }}"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-round btn-icon btn-sm btn-quick-href" data-method="delete" data-href="{{ route('setup.machine.destroy', ['machine' => $row->id]) }}"><i class="fa fa-trash"></i></button>
          </td>--}}
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">Tidak ada data</td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
@endsection
