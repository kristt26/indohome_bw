<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div ng-controller="keluhanController" ng-init="init()">
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
    <div class="row" ng-show="peta==false">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Daftar Keluhan Anda</h3>
                    <?php if (session()->get('akses') != 'Admin') : ?>
                        <button class="btn btn-primary btn-sm" ng-click="mulai()"><i class="fas fa-plus"></i></button>
                    <?php endif; ?>
                    <?php if (session()->get('akses') == 'Admin') : ?>
                        <button type="submit" class="btn btn-info pmd-ripple-effect btn-sm" ng-click="allMarker()"><i class="fas fa-map-marker fa-sm fa-fw"></i>All Location</button>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Laporan</th>
                                    <th>Tanggal Lapor</th>
                                    <th>Nama Pelapor</th>
                                    <th>Kontak</th>
                                    <th>Keluhan Kerusakan</th>
                                    <th>Status</th>
                                    <th width="10%"><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas.keluhan">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nomor}}</td>
                                    <td>{{item.tanggal}}</td>
                                    <td>{{item.nama}}</td>
                                    <td>{{item.kontak}}</td>
                                    <td>{{item.kerusakan}}</td>
                                    <td>{{item.status}}</td>
                                    <td>
                                        <button type="submit" class="btn btn-danger pmd-ripple-effect btn-sm" ng-click="delete(item)"><i class="fas fa-trash-alt fa-sm fa-fw"></i></button>
                                        <?php if (session()->get('akses') == 'Admin') : ?>
                                            <button type="submit" class="btn btn-warning pmd-ripple-effect btn-sm" ng-click="ubah(item)"><i class="fas fa-edit fa-sm fa-fw"></i></button>
                                            <button type="submit" class="btn btn-info pmd-ripple-effect btn-sm" ng-click="tampilPeta(item)"><i class="fas fa-map-marker fa-sm fa-fw"></i></button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div ng-show="peta">
        <div class="card">
            <div class="card-header d-flex bd-highlight">
                <h3 class="p-2 flex-grow-1 bd-highlight">Lokasi Rumah</h3>
                <div class="form-check p-2 bd-highlight">
                    <input class="form-check-input" type="checkbox" ng-model="arah" ng-change="setDirection(arah)" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                        Direction
                    </label>
                </div>
                <button class="p-2 bd-highlight btn btn-secondary btn-sm" ng-click="kembali()">Kembali</button>
            </div>
            <div class="card-body" style="height: 600px;">
                <div id="map"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mulai" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Silahkan jawab pertanyaan berikut!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form ng-submit="save()">
                    <div class="modal-body">
                        <div ng-if="!hasil" class="alert alert-primary" role="alert">Apakah Terjadi {{pertanyaan.gejala}}</div>
                        <div ng-if="hasil" class="alert alert-warning" role="alert">Permasalahan: <br>{{hasil.kerusakan}}</div>
                    </div>
                    <div class="modal-footer">
                        <button ng-if="!hasil" type="button" class="btn btn-info" ng-click="check('Ya')">Ya</button>
                        <button ng-if="!hasil" type="button" class="btn btn-warning" ng-click="check('Tidak')">Tidak</button>
                        <button ng-if="hasil && hasil.id" type="submit" class="btn btn-primary">Simpan</button>
                        <button ng-if="hasil" type="button" class="btn btn-secondary" ng-click="mulai()">Ulang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" type="text/css">
    <style>
        #map {
            position: absolute;
            top: 70px;
            bottom: 10px;
            width: 99%;
        }

        .mapboxgl-popup {
            max-width: 200px;
        }

        .mapboxgl-popup-content {
            text-align: center;
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</div>
<?= $this->endSection() ?>