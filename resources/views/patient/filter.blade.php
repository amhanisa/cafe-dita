<form id="form-filter" action="{{ route('patien.index') }}" method="get">
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Status</span>
                        <select id="status_id" name="status" id="status">
                            <option></option>
                            <option value="1">Tidak Terkendali</option>
                            <option value="2">Terkendali</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input class="btn btn-block btn-primary" type="submit" value="Filter">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>