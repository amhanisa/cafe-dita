<form action="{{ url('report') }}" method="get">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Pilih Tipe Laporan</label>
                <select class="form-select" id="report-type" name="type">
                    <option value="monthly" {{ request()->get('type') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="yearly" {{ request()->get('type') == 'yearly' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </div>

            <div class="row mb-3">
                <div class="col" id="month-selector">
                    <div class="mb-3">
                        <select class="form-select" id="month-select" name="month">
                            <option value="1" {{ request()->get('month') == 1 ? 'selected' : '' }}>Januari
                            </option>
                            <option value="2" {{ request()->get('month') == 2 ? 'selected' : '' }}>Februari
                            </option>
                            <option value="3" {{ request()->get('month') == 3 ? 'selected' : '' }}>Maret
                            </option>
                            <option value="4" {{ request()->get('month') == 4 ? 'selected' : '' }}>April
                            </option>
                            <option value="5" {{ request()->get('month') == 5 ? 'selected' : '' }}>Mei
                            </option>
                            <option value="6" {{ request()->get('month') == 6 ? 'selected' : '' }}>Juni
                            </option>
                            <option value="7" {{ request()->get('month') == 7 ? 'selected' : '' }}>Juli
                            </option>
                            <option value="8" {{ request()->get('month') == 8 ? 'selected' : '' }}>Agustus
                            </option>
                            <option value="9" {{ request()->get('month') == 9 ? 'selected' : '' }}>September
                            </option>
                            <option value="10" {{ request()->get('month') == 10 ? 'selected' : '' }}>Oktober
                            </option>
                            <option value="11" {{ request()->get('month') == 11 ? 'selected' : '' }}>November
                            </option>
                            <option value="12" {{ request()->get('month') == 12 ? 'selected' : '' }}>Desember
                            </option>
                        </select>
                    </div>
                    @error('month')
                        <span class="validation-error"> {{ $message }} </span>
                    @enderror
                </div>
                <div class="col">
                    <div class="mb-3">
                        <select class="form-select" name="year">
                            <option {{ request()->get('year') == 2022 ? 'selected' : '' }}>2022</option>
                            <option {{ request()->get('year') == 2021 ? 'selected' : '' }}>2021</option>
                            <option {{ request()->get('year') == 2020 ? 'selected' : '' }}>2020</option>
                        </select>
                    </div>
                    @error('year')
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

@push('script')
    <script>
        $(document).ready(function() {
            if ($('#report-type').val() == 'yearly') {

                $('#month-selector').hide();
                $('#month-select').prop('disabled', true);
                $("#month-select option").prop("selected", false);
            }
        });

        $('#report-type').on('change', function() {
            if ($(this).val() == 'yearly') {
                $('#month-selector').hide();
                $('#month-select').prop('disabled', true);
                $("#month-select option").prop("selected", false);
            } else {
                $('#month-selector').show();
                $('#month-select').prop('disabled', false);
            }
        })
    </script>
@endpush
