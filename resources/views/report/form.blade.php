<form action="{{ url('report') }}" method="get">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Tanggal Awal</span>
                        <input class="form-control" name="start_date" type="date"
                            value="{{ request()->get('start_date') }}">
                    </div>
                    @error('start_date')
                        <span class="validation-error"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Tanggal Akhir</span>
                        <input class="form-control" name="end_date" type="date"
                            value="{{ request()->get('end_date') }}">
                    </div>
                    @error('end_date')
                        <span class="validation-error"> {{ $message }} </span>
                    @enderror
                </div>

            </div>

            <div class="row mb-3 justify-content-center">
                <div class="col-md-6">
                    <input class="btn btn-block btn-primary" type="submit" value="Cari">
                </div>
            </div>
        </div>
    </div>
</form>
