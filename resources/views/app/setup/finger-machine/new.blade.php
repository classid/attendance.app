@extends('layouts.app')

@section('content')
  <div class="card">
    <h2 class="card-header">Daftar Mesin FingerPrint</h2>

    <form action="{{ route('setup.fingerMachine.store') }}" method="post">
      @csrf
      <div class="card-body">
        <div class="form-group form-floating-label">
          <input id="name" name="name" type="text" class="form-control input-border-bottom" required autofocus>
          <label for="name" class="placeholder">Nama Mesin</label>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group form-floating-label">
              <input id="host" name="host" type="text" class="form-control input-border-bottom" value="{{ old('host', '127.0.0.1') }}" required>
              <label for="host" class="placeholder">Host</label>
            </div>
          </div>
          <div class="col">
            <div class="form-group form-floating-label">
              <input id="port" name="port" type="number" class="form-control input-border-bottom" value="{{ old('port', '80') }}" required>
              <label for="port" class="placeholder">Port</label>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{ route('setup.fingerMachine') }}" class="btn btn-link">Batal</a>
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
