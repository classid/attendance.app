@extends('layouts.app')

@section('content')
  <div class="card">
    <h2 class="card-header">Daftar Mesin FingerPrint</h2>
    <div class="card-body">
      <div class="row">
        <div class="col text-right">
          <a href="{{ route('setup.machine.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
        </div>
      </div>
    </div>
    <table id="table" class="table table-striped table-hover">
      <thead>
      <tr>
        <th width="2%">#</th>
        <th>Nama</th>
        <th width="20%">Host</th>
        <th width="5%">Enable</th>
        <th width="5%">Status</th>
        <th width="5%">&nbsp;</th>
      </tr>
      </thead>
      <tbody>
      @forelse($machines as $row)
        <tr>
          <td class="text-right">{{ $loop->iteration }}.</td>
          <td class="text-left">{{ $row->name }}</td>
          <td class="text-left">{{ $row->host }}:{{ $row->port }}</td>
          <td class="text-center">{!! config('cid.status.enable.icons.' . $row->enable) !!}</td>
          <td class="text-center">
            @if(deviceConnected($row->host, $row->port))
              <i class="fas fa-window-restore fa-2x text-success" title="Connected"></i>
            @else
              <i class="fas fa-window-close fa-2x text-danger" title="Disconnected"></i>
            @endif
          </td>
          <td class="text-left text-nowrap">
            <button type="button" class="btn btn-warning btn-round btn-icon btn-sm btn-quick-href" data-href="{{ route('setup.machine.edit', ['machine' => $row->id]) }}"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-round btn-icon btn-sm btn-quick-href" data-method="delete" data-href="{{ route('setup.machine.destroy', ['machine' => $row->id]) }}"><i class="fa fa-trash"></i></button>
          </td>
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
