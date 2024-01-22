<?php

namespace App\Controllers;

use App\Models\GejalaModel;

class Gejala extends BaseController
{

    protected $gejala;
    public function __construct() {
        $this->gejala = new GejalaModel();
    }

    public function index(): string
    {
        return view('gejala');
    }

    public function read(): object
    {
        return $this->respond($this->gejala->findAll());
    }

    public function post(): object
    {
        $data = $this->request->getJSON();
        try {
            $this->gejala->insert($data);
            $data->id = $this->gejala->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put(): object
    {
        $data = $this->request->getJSON();
        try {
            $this->gejala->update($data->id, $data);
            return $this->respondUpdated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null): object
    {
        try {
            $this->gejala->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
