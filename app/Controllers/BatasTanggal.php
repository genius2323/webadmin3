<?php
namespace App\Controllers;
// use App\Models\BatasTanggalModel;
use CodeIgniter\Controller;

class BatasTanggal extends Controller
{
    public function index()
    {
        $model = new \App\Models\SystemDateLimitsModel();
        $data['batas'] = $model->orderBy('id', 'desc')->first();
        $data['title'] = 'Batas Tanggal Sistem';
        return view('batas_tanggal/index', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $batas_tanggal = $this->request->getPost('batas_tanggal');
        // Konversi format tgl/bln/tahun ke Y-m-d
        if ($batas_tanggal && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $batas_tanggal)) {
            $parts = explode('/', $batas_tanggal);
            $batas_tanggal = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        $mode_batas_tanggal = $this->request->getPost('mode');
        $menu = $this->request->getPost('menu');
        $data = [
            'batas_tanggal' => $batas_tanggal,
            'mode_batas_tanggal' => $mode_batas_tanggal,
            'menu' => $menu
        ];
        // Proses di database utama
        $modelDefault = new \App\Models\SystemDateLimitsModel();
        $modelDefault->DBGroup = 'default';
        if ($id) {
            $modelDefault->update($id, $data);
        } else {
            $id = $modelDefault->insert($data);
        }
        // Proses di database kedua (db2) dengan query builder
        $db2 = \Config\Database::connect('db2');
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        if ($id) {
            $db2->table('system_date_limits')->where('id', $id)->update($dataDb2);
        } else {
            $db2->table('system_date_limits')->insert($dataDb2);
        }
        return redirect()->to('batas-tanggal')->with('success', 'Batas tanggal sistem berhasil diupdate di kedua database.');
    }
}
