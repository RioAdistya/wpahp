@php
    use App\Http\Controllers\NilaiController;
    $saw = new NilaiController();
    $totalalts = count($data['alternatif']);
@endphp
@extends('layout')
@section('title', 'Hasil Penilaian Alternatif')
@section('subtitle', 'Hasil Penilaian Alternatif')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Matriks Perbandingan Alternatif-Kriteria</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>A</th>
                            @foreach ($data['kriteria'] as $krit)
                                <th data-bs-toggle="tooltip" title="{{ $krit->name }}">
                                    C{{ $krit->id }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['alternatif'] as $alter)
                            @php
                                $analys = $hasil->where('alternatif_id', $alter->id)->all();
                            @endphp
                            @if (count($analys) > 0)
                                <tr>
                                    <th data-bs-toggle="tooltip" title="{{ $alter->name }}">
                                        A{{ $alter->id }}
                                    </th>
                                    @foreach ($analys as $normalt)
                                        <td data-bs-toggle="tooltip" title="{{ $normalt->subkriteria->name }}">
                                            {{ round($normalt->subkriteria->bobot, 2) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Perhitungan Nilai W</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th>Cost/Benefit</th>
                            <th>Bobot</th>
                            <th>Nilai W</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['kriteria'] as $krit)
                            <tr>
                                <th data-bs-toggle="tooltip" title="{{ $krit->name }}">
                                    C{{ $krit->id }}
                                </th>
                                <th>{{ $krit->type }}</th>
                                <th>{{ round($krit->bobot, 2) }}</th>
                                @php
                                    $arrayw = $krit->bobot;
                                    $resultw = $saw->pangkatBobot($arrayw, $krit->type);
                                @endphp
                                <th>{{ round($resultw, 4) }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Perhitungan Nilai Vektor S dan Vektor V</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>Alternatif</th>
                            <th>Nilai Vektor S</th>
                            <th>Nilai Vektor V</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $arrS = [];
                            $sumS = 0;
                            foreach ($data['alternatif'] as $alts) {
                                // $counter = 0;
                                $norm = $hasil->where('alternatif_id', $alts->id)->all();
                                if (count($norm) == 0) {
                                    continue;
                                }

                                $res = [];
                                foreach ($norm as $nilai) {
                                    $arrays = $nilai->kriteria->bobot;
                                    $result = $saw->vektorS(
                                        $arrays,
                                        $nilai->kriteria->type,
                                        $nilai->subkriteria->bobot,
                                    );
                                    // $counter++;
                                    // $lresult[$alts->id][$counter] = $result;
                                    array_push($res, $result);
                                }
                                $totalVektorS = $saw->multiplyVectorS($res);
                                array_push($arrS, $totalVektorS);

                                $sumS += $totalVektorS;
                            }
                        @endphp
                        @foreach ($data['alternatif'] as $key => $alts)
                            {{-- @php
                                if (!isset($arrS[$key])) {
                                    continue; // Skip alternatives with no calculated vector S
                                }

                                $vValue = $arrS[$key] / $sumS;
                                $lresult[$alts->id] = $vValue;
                            @endphp --}}
                            <tr>
                                <th data-bs-toggle="tooltip" title="{{ $alts->name }}">
                                    A{{ $alts->id }}
                                </th>
                                @php
                                    if (!isset($arrS[$key])) {
                                        continue; // Skip alternatives with no calculated vector S
                                    }
                                    $counter = 0;
                                    $vValue = $arrS[$key] / $sumS;
                                    $counter++;
                                    $lresult[$alts->id][$counter] = $vValue;
                                @endphp
                                <th>{{ round($arrS[$key], 4) }}</th>
                                <th>{{ round($vValue, 4) }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="RankModal" tabindex="-1" role="dialog" aria-labelledby="RankLabel"
        aria-hidden="true">
        <div @class([
            'modal-dialog',
            'modal-dialog-centered',
            'modal-dialog-scrollable',
            'modal-fullscreen-md-down' => $totalalts <= 5,
            'modal-fullscreen-lg-down' => $totalalts > 5 && $totalalts <= 10,
            'modal-lg' => $totalalts > 5 && $totalalts <= 10,
            'modal-fullscreen-xl-down' => $totalalts > 10 && $totalalts <= 18,
            'modal-xl' => $totalalts > 10 && $totalalts <= 18,
            'modal-fullscreen' => $totalalts > 18,
        ]) role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="RankLabel">Grafik hasil penilaian</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="chart-ranking"></div>
                    <p>Jadi, nilai tertingginya diraih oleh
                        <b><span id="SkorTertinggi">...</span></b>
                        (A<span id="AltID">x</span>) dengan nilai
                        <b><span id="SkorHasil">...</span></b>
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Memuat grafik...</span>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        {{-- <div class="card-header">
            <h4 class="card-title">Ranking</h4>
        </div> --}}
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#RankModal"
                id="spare-button">
                <i class="bi bi-bar-chart-line-fill"></i> Lihat Grafik
            </button>
            <table class="table table-hover table-striped text-center" id="table-hasil" style="width: 100%">
                <thead class="text-center">
                    <tr>
                        <th>A</th>
                        @foreach ($data['kriteria'] as $krit)
                            <th data-bs-toggle="tooltip" title="{{ $krit->name }}">
                                C{{ $krit->id }} <span class="visually-hidden">{{ $krit->name }}</span>
                            </th>
                        @endforeach
                        <th>V</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['alternatif'] as $alts)
                        @php
                            $rank = $hasil->where('alternatif_id', $alts->id)->all();
                            $hasSubcriteria = count($rank) > 0;
                        @endphp
                        @if ($hasSubcriteria)
                            <tr>
                                <th data-bs-toggle="tooltip" title="{{ $alts->name }}">
                                    A{{ $alts->id }} <span class="visually-hidden">{{ $alts->name }}</span>
                                </th>
                                @foreach ($rank as $normalt)
                                    <td data-bs-toggle="tooltip" title="{{ $normalt->subkriteria->name }}">
                                        {{ round($normalt->subkriteria->bobot, 2) }}
                                    </td>
                                @endforeach
                                @php
                                    $jml = 0;
                                    foreach ($lresult[$alts->id] as $datas) {
                                        $jml += round($datas, 3);
                                    }
                                @endphp
                                <td>{{ round($jml, 3) }}</td>
                                @php $saw->simpanHasil($alts->id, $jml); @endphp
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Ranking</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover table-striped text-center" id="table-hasil" style="width: 100%">
                <thead class="text-center">
                    <tr>
                        <th>Peringkat</th>
                        <th>Alternatif</th>
                        <th>Nilai Vektor V</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Urutkan alternatif berdasarkan nilai vektor v
                        $sortedAlternatif = $data['alternatif']->sortByDesc(function ($alternatif) use ($lresult) {
                            return $lresult[$alternatif->id] ?? 0;
                        });

                        $rank = 1;
                        $prevValue = null;
                        $displayRank = 1;
                    @endphp
                    @foreach ($sortedAlternatif as $alts)
                        @php
                            // Pastikan nilai vektor V ada untuk alternatif ini
                            if (!isset($lresult[$alts->id]) || empty($lresult[$alts->id])) {
                                continue; // Skip alternatives without vektor V values
                            }

                            $jml = 0;
                            foreach ($lresult[$alts->id] as $datas) {
                                $jml += round($datas, 3);
                            }

                            // Tentukan apakah nilai vektor V sama dengan nilai sebelumnya
                            if ($prevValue !== null && $jml !== $prevValue) {
                                $displayRank = $rank;
                            }

                            $prevValue = $jml;
                        @endphp
                        <tr>
                            <td>{{ $displayRank }}</td>
                            <th data-bs-toggle="tooltip" title="{{ $alts->name }}">
                                A{{ $alts->id }} <span class="visually-hidden">{{ $alts->name }}</span>
                            </th>
                            <td>{{ round($jml, 3) }}</td>
                        </tr>
                        @php
                            $rank++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
@section('js')
    <script type="text/javascript">
        let dt_hasil = $('#table-hasil'),
            loaded = false,
            errmsg;
        const options = {
            chart: {
                height: 320,
                type: 'bar'
            },
            dataLabels: {
                enabled: true
            },
            legend: {
                show: false
            },
            series: [],
            title: {
                text: 'Hasil Penilaian'
            },
            noData: {
                text: 'Memuat grafik...'
            },
            xaxis: {
                categories: [
                    @foreach ($data['alternatif'] as $alts)
                        ["A{{ $alts->id }}", "{{ $alts->name }}"],
                    @endforeach
                ]
            },
            plotOptions: {
                bar: {
                    distributed: true
                }
            }
        };
        const chart = new ApexCharts(document.querySelector("#chart-ranking"), options);
        $(document).ready(function() {
            try {
                $.fn.dataTable.ext.errMode = "none";
                dt_hasil = dt_hasil.DataTable({
                    lengthChange: false,
                    searching: false,
                    responsive: true,
                    order: [
                        [1 + {{ count($data['kriteria']) }}, 'desc']
                    ],
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/2.0.0/i18n/id.json"
                    },
                    columnDefs: [{
                            targets: 0,
                            type: "natural"
                        }, //Alternatif
                        @foreach ($data['kriteria'] as $krit)
                            { //Nilai Kriteria
                                targets: 1 + {{ $loop->index }},
                                render: function(data) {
                                    return parseFloat(data);
                                }
                            },
                        @endforeach { //Jumlah
                            targets: -1,
                            render: function(data) {
                                return parseFloat(data);
                            }
                        }
                    ],
                    layout: {
                        topStart: {
                            buttons: [{
                                text: '<i class="bi bi-bar-chart-line-fill me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Lihat Grafik</span>',
                                className: 'btn',
                                attr: {
                                    'data-bs-toggle': 'modal',
                                    'data-bs-target': '#RankModal'
                                }
                            }, {
                                extend: 'collection',
                                text: '<i class="bi bi-printer me-2"></i> Cetak',
                                className: 'btn dropdown-toggle',
                                buttons: [{
                                    extend: 'print',
                                    title: 'Alternatif Tertinggi',
                                    text: '<i class="bi bi-person me-2"></i> Alternatif saja',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [0],
                                        format: {
                                            body: function(inner) {
                                                return inner.substring(inner.indexOf(
                                                    '>') + 1);
                                            }
                                        }
                                    },
                                    customize: function(win) {
                                        $(win.document.body).find('table').addClass(
                                                'table-bordered')
                                            .removeClass(
                                                'table-hover table-striped text-center')
                                            .css('width', '');
                                    }
                                }, {
                                    extend: 'print',
                                    title: 'Hasil Penilaian',
                                    text: '<i class="bi bi-clipboard-data me-2"></i> Semua data',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: ':visible',
                                        format: {
                                            header: function(data, columnIdx) {
                                                // Menghilangkan tag HTML dari judul kolom
                                                return $('<div>').html(data).text();
                                            },
                                            body: function(data, rowIdx, columnIdx, node) {
                                                // Menghilangkan tag HTML dari sel data
                                                return $('<div>').html(data).text();
                                            }
                                        }
                                    },
                                    customize: function(win) {
                                        $(win.document.body).find('table').addClass(
                                                'table-bordered')
                                            .removeClass(
                                                'table-hover table-striped text-center')
                                            .css('width', '');
                                    }
                                }]
                            }]
                        }
                    }
                }).on('draw', setTableColor).on('init.dt', function() {
                    $('#spare-button').addClass('d-none');
                }).on('error.dt', function(e, settings, techNote, message) {
                    errorDT(message, techNote);
                });
            } catch (dterr) {
                swal.fire({
                    icon: 'error',
                    title: "Gagal mengurutkan hasil penilaian"
                });
                console.error(dterr.message);
            }
        });
        chart.render();
        $('#RankModal').on('show.bs.modal', function() {
            if (!loaded) {
                $.getJSON("{{ route('hasil.ranking') }}", function(response) {
                    $('#SkorHasil').text(response.score);
                    $('#SkorTertinggi').text(response.nama);
                    $('#AltID').text(response.alt_id);
                    chart.updateSeries([{
                        name: 'Nilai',
                        data: response.result.skor
                    }]);
                    loaded = true;
                }).fail(function(xhr, st) {
                    if (xhr.status === 400) errmsg = xhr.responseJSON.message;
                    else {
                        console.warn(xhr.responseJSON.message ?? st);
                        errmsg = `Kesalahan HTTP ${xhr.status}. ${xhr.statusText}`;
                    }
                    swal.fire({
                        title: 'Gagal memuat grafik',
                        text: errmsg,
                        icon: 'error'
                    });
                }).always(function() {
                    $(".spinner-grow").addClass("d-none");
                });
            }
        }).on('hidden.bs.modal', function() {
            if (!loaded) $(".spinner-grow").removeClass("d-none");
        });
    </script>
@endsection
