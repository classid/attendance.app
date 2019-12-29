@extends('layouts.app')

@section('content')
  <div class="card">
    <h2 class="card-header">Edit Mesin FingerPrint</h2>

    <form action="{{ route('setup.machine.update', ['machine' => $machine->id]) }}" method="post">
      @csrf
      @method('put')
      <input type="hidden" name="_id" value="{{ $machine->id }}">
      <div class="card-body">
        <div class="form-group form-floating-label">
          <input id="name" name="name" type="text" class="form-control input-border-bottom" value="{{ old('name', $machine->name) }}" required autofocus>
          <label for="name" class="placeholder">Nama Mesin</label>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group form-floating-label">
              <input id="host" name="host" type="text" class="form-control input-border-bottom" value="{{ old('host', $machine->host) }}" required>
              <label for="host" class="placeholder">Host</label>
            </div>
          </div>
          <div class="col">
            <div class="form-group form-floating-label">
              <input id="port" name="port" type="number" class="form-control input-border-bottom" value="{{ old('port', $machine->port) }}" required>
              <label for="port" class="placeholder">Port</label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="form-floating-label checkbox-inline">
            <span style="margin-right: 30px;">Status</span>
            <input type="checkbox" name="enable" id="macStatus" value="1" {{ old('enable', $machine->enable)==1 ? 'checked="checked':'' }}
                   onchange="$(this).val(!$(this).parent().is('.toggle.off'))"
                   data-toggle="toggle" data-onstyle="primary" data-style="btn-round" data-on="Enabled" data-off="Disabled">
          </label>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('setup.machine') }}" class="btn btn-link">Batal</a>
        <button class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function () {
    });
  </script>
@endpush
