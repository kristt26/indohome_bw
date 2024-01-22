<?php

namespace App\Controllers;

use App\Models\GejalaModel;
use App\Models\KerusakanModel;
use App\Models\PengetahuanModel;

class Pengetahuan extends BaseController
{

    protected $kerusakan;
    protected $pengetahuan;
    protected $gejala;
    public function __construct() {
        $this->kerusakan = new KerusakanModel();
        $this->pengetahuan = new PengetahuanModel();
        $this->gejala = new GejalaModel();
    }

    public function read($id = null): object
    {
        $kerusakan = $this->kerusakan->where("id", $id)->first();
        $kerusakan->pengetahuan = $this->pengetahuan->select("pengetahuan.*, gejala.gejala, gejala.kode_gejala")->join("gejala", "gejala.id=pengetahuan.gejala_id")->where("kerusakan_id", $id)->findAll();
        $gejala = $this->gejala->findAll();
        return $this->respond(['kerusakan'=>$kerusakan, 'gejala'=>$gejala]);
    }

    public function post(): object
    {
        $data = $this->request->getJSON();
        try {
            $this->pengetahuan->insert($data);
            $data->id = $this->pengetahuan->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put(): object
    {
        $data = $this->request->getJSON();
        try {
            $this->pengetahuan->update($data->id, $data);
            return $this->respondUpdated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null): object
    {
        try {
            $this->pengetahuan->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
