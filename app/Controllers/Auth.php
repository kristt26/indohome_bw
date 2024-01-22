<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\UserModel;

class Auth extends BaseController
{

    protected $user;
    protected $pelanggan;
    public function __construct()
    {
        $this->user = new UserModel();
        $this->pelanggan = new PelangganModel();
    }

    public function index(): string
    {
        if ($this->user->countAllResults() == 0) {
            $this->user->insert(['username' => 'Administrator', 'password' => password_hash('Administrator#1', PASSWORD_DEFAULT), 'akses' => 'Admin']);
        }
        return view('login');
    }

    public function register(): string
    {
        return view('register');
    }

    public function post(): object
    {
        $data = $this->request->getJSON();
        $conn = \Config\Database::connect();
        try {
            $conn->transBegin();
            $user = [
                'username' => $data->nomor_pelanggan,
                'password' => password_hash($data->nomor_pelanggan, PASSWORD_DEFAULT),
                'akses' => 'Pelanggan'
            ];
            $this->user->insert($user);
            $data->user_id = $this->user->getInsertID();
            $this->pelanggan->insert($data);
            if ($conn->transStatus()) {
                $conn->transCommit();
                return $this->respondCreated(true);
            } else {
                throw new \Exception("Gagal membuat akun", 1);
            }
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function login(): object
    {
        $data = $this->request->getJSON();
        $q = $this->user->where('username', $data->username)->first();
        if ($q) {
            if (password_verify($data->password, $q->password)) {
                if($q->akses == "Admin"){
                    session()->set(['uid'=>$q->id,'nama' => 'Administrator', 'akses'=>$q->akses, 'isRole' => true]);
                }else{
                    $pelanggan = $this->pelanggan->where('user_id', $q->id)->first();
                    session()->set(['uid'=>$q->id,'nama' => $pelanggan->nama, 'akses'=>$q->akses, 'isRole' => true]);
                }
                return $this->respond(true);
            } else return $this->fail("Password salah");
        } else return $this->fail("Username tidak ditemukan");
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }
}
