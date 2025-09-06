<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DiscountSettingsModel;

class DiscountSettings extends BaseController
{
    public function index()
    {
        $model = new DiscountSettingsModel();
        $settings = $model->findAll();
        return view('fasilitas/discount_settings', ['settings' => $settings]);
    }

    public function create()
    {
        $model = new DiscountSettingsModel();
        $data = [
            'discount_type' => $this->request->getPost('discount_type'),
            'active' => $this->request->getPost('active') ? true : false,
            'value_nominal' => $this->request->getPost('value_nominal'),
            'value_percent' => $this->request->getPost('value_percent'),
            'tier_json' => $this->request->getPost('tier_json'),
            'customer_type' => $this->request->getPost('customer_type'),
            'nota_nominal' => $this->request->getPost('nota_nominal'),
            'nota_percent' => $this->request->getPost('nota_percent'),
        ];
        if ($data['active']) {
            // Nonaktifkan semua setting lain
            $model->where('active', 1)->set(['active' => 0])->update();
        }
        $model->insert($data);
        return redirect()->to('/discountsettings');
    }

    public function edit($id)
    {
        $model = new DiscountSettingsModel();
        $setting = $model->find($id);
        return view('fasilitas/discount_settings_edit', ['setting' => $setting]);
    }

    public function update($id)
    {
        $model = new DiscountSettingsModel();
        $data = [
            'discount_type' => $this->request->getPost('discount_type'),
            'active' => $this->request->getPost('active') ? true : false,
            'value_nominal' => $this->request->getPost('value_nominal'),
            'value_percent' => $this->request->getPost('value_percent'),
            'tier_json' => $this->request->getPost('tier_json'),
            'customer_type' => $this->request->getPost('customer_type'),
            'nota_nominal' => $this->request->getPost('nota_nominal'),
            'nota_percent' => $this->request->getPost('nota_percent'),
        ];
        if ($data['active']) {
            $model->where('active', 1)->set(['active' => 0])->update();
        }
        $model->update($id, $data);
        return redirect()->to('/discountsettings');
    }

    public function delete($id)
    {
        $model = new DiscountSettingsModel();
        $model->delete($id);
        return redirect()->to('/discountsettings');
    }
}
