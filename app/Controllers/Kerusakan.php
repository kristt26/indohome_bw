<?php

namespace App\Controllers;

use App\Models\KerusakanModel;

class Kerusakan extends BaseController
{

    protected $kerusakan;
    public function __construct() {
        $this->kerusakan = new KerusakanModel();
    }

    public function index(): string
    {
        return view('kerusakan');
    }

    public function read(): object
    {
        return $this->respond($this->kerusakan->findAll());
    }

    public function post(): object
    {
        $data = $this->request->getJSON();
        try {
            $this->kerusakan->insert($data);
            $data->id = $this->kerusakan->getInsertID();
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function put(): object
    {
        $data = $this->request->getJSON();
        try {
            $this->kerusakan->update($data->id, $data);
            return $this->respondUpdated($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function delete($id = null): object
    {
        try {
            $this->kerusakan->delete($id);
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function pengetahuan($id = null): string
    {
        return view('pengetahuan');
    }
}
