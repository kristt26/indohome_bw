<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div ng-controller="pengetahuanController">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Input Data Kriteria</h3>
                </div>
                <form ng-submit="save()">
                    <div class="card-body">
                        <div ng-class="{'form-group pmd-textfield pmd-textfield-floating-label': !model.id, 'form-group pmd-textfield': model.id}">
                            <label class="control-label">Gejala</label>
                            <select class="form-control" ng-options="item as (item.kode_gejala+' - '+item.gejala) for item in datas.gejala" ng-model="gejala" ng-change="model.gejala_id=gejala.id; model.kode_gejala=gejala.kode_gejala; model.gejala=gejala.gejala; model.kerusakan_id=datas.kerusakan.id">
                            </select>
                        </div>
                        <div ng-class="{'form-group pmd-textfield pmd-textfield-floating-label': !model.id, 'form-group pmd-textfield': model.id}">
                            <label class="control-label">Tujuan Jika Ya</label>
                            <input type="text" class="form-control" id="ya" ng-model="model.ya" required>
                        </div>
                        <div ng-class="{'form-group pmd-textfield pmd-textfield-floating-label': !model.id, 'form-group pmd-textfield': model.id}">
                            <label class="control-label">Tujuan Jika Tidak</label>
                            <input type="text" class="form-control" id="tidak" ng-model="model.tidak" required>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary pmd-ripple-effect btn-sm">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Daftar Kriteria</h3>
                    <button class="btn btn-secondary btn-sm" onclick="history.back()">Kembali</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Gejala</th>
                                    <th>Gejala</th>
                                    <th>Tujuan Jika Ya</th>
                                    <th>Tujuan Jika Tidak</th>
                                    <th><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas.kerusakan.pengetahuan">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.kode_gejala}}</td>
                                    <td>{{item.gejala}}</td>
                                    <td>{{item.ya}}</td>
                                    <td>{{item.tidak}}</td>
                                    <td>
                                        <button type="submit" class="btn btn-warning pmd-ripple-effect btn-sm" ng-click="edit(item)"><i class="fas fa-edit fa-sm fa-fw"></i></button>
                                        <button type="submit" class="btn btn-danger pmd-ripple-effect btn-sm" ng-click="delete(item)"><i class="fas fa-trash-alt fa-sm fa-fw"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>