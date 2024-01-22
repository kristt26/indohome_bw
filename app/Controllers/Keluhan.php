<?php

namespace App\Controllers;

use App\Models\GejalaModel;
use App\Models\KeluhanModel;
use App\Models\KerusakanModel;
use App\Models\PelangganModel;
use App\Models\PengetahuanModel;

class Keluhan extends BaseController
{
    protected $kerusakan;
    protected $gejala;
    protected $pengetahuan;
    protected $keluhan;
    protected $pelanggan;
    protected $conn;

    public function __construct()
    {
        $this->kerusakan = new KerusakanModel();
        $this->gejala = new GejalaModel();
        $this->pengetahuan = new PengetahuanModel();
        $this->keluhan = new KeluhanModel();
        $this->pelanggan = new PelangganModel();
        $this->conn = \Config\Database::connect();

    }
    public function index(): string
    {
        return view('keluhan');
    }

    public function read(): object
    {
        $data['kerusakan'] = $this->kerusakan->findAll();
        $data['gejala'] = $this->gejala->findAll();
        $data['pengetahuan'] = $this->pengetahuan
            ->select("pengetahuan.*, gejala.gejala, gejala.kode_gejala, kerusakan.kerusakan, kerusakan.kode_kerusakan")
            ->join('gejala', 'gejala.id=pengetahuan.gejala_id')
            ->join('kerusakan', 'kerusakan.id=pengetahuan.kerusakan_id')
            ->findAll();
        if (session()->get('akses') == 'Admin') $data['keluhan'] = $this->keluhan
            ->select("keluhan.*, kerusakan.kerusakan, pelanggan.lat, pelanggan.long, pelanggan.nama, pelanggan.alamat, pelanggan.kontak")
            ->join('kerusakan', 'kerusakan.id=keluhan.kerusakan_id')
            ->join('pelanggan', 'pelanggan.id=keluhan.pelanggan_id')
            ->findAll();
        return $this->respond($data);
    }

    public function post(): object
    {
        $data = $this->request->getJSON();
        try {
            $this->conn->transBegin();
            $pelanggan = [
                'nomor_pelanggan'=>$data->nomor_pelanggan,
                'nama'=>$data->nama,
                'alamat'=>$data->alamat,
                'kontak'=>$data->kontak,
                'lat'=>$data->lat,
                'long'=>$data->long,
            ];
            $this->pelanggan->insert($pelanggan);
            $keluhan = [
                'pelanggan_id'=>$this->pelanggan->getInsertID(),
                'kerusakan_id'=>$data->kerusakan_id,
                'nomor'=>random_int(10000, 99999),
                'status'=>'Diajukan',
            ];
            $this->keluhan->insert($keluhan);
            if($this->conn->transStatus()){
                $this->conn->transCommit();
                return $this->respond($keluhan);
            }
        } catch (\Throwable $th) {
            $this->conn->transRollback();
            return $this->fail($th->getMessage());
        }
    }

    public function put(): object
    {
        return view('layout');
    }
    public function delete(): object
    {
        return view('layout');
    }
}
