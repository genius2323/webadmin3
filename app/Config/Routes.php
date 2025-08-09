<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =================================================================
// RUTE PUBLIK & AUTENTIKASI
// =================================================================

$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/login/process', 'Auth::process');
$routes->get('/logout', 'Auth::logout');


// =================================================================
// RUTE TERPROTEKSI (WAJIB LOGIN)
// =================================================================
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Otorisasi Master Barang
    $routes->get('otorisasi/otorisasi_masterbarang', 'Otorisasi\OtorisasiMasterBarang::index');
    // Tambahkan POST/aksi lain jika diperlukan, contoh:
    $routes->post('otorisasi/otorisasi_masterbarang/setOtorisasiMasterBarang', 'Otorisasi\OtorisasiMasterBarang::setOtorisasiMasterBarang');
    // Otorisasi User
    $routes->get('otorisasi/otorisasi_user', 'Otorisasi\OtorisasiUser::index');
    $routes->post('otorisasi/otorisasi_user/setOtorisasiUser', 'Otorisasi\OtorisasiUser::setOtorisasiUser');
    // Otorisasi Customer
    $routes->get('otorisasi/otorisasi_customer', 'Otorisasi\OtorisasiCustomer::index');
    $routes->post('otorisasi/otorisasi_customer/setOtorisasiCustomer', 'Otorisasi\OtorisasiCustomer::setOtorisasiCustomer');
    // Otorisasi Sales
    $routes->get('otorisasi/otorisasi_sales', 'OtorisasiSales::index');
    $routes->post('otorisasi/otorisasi_sales/setOtorisasiSales', 'OtorisasiSales::setOtorisasiSales');
    // Profile
    $routes->get('profile', 'Profile::index');
    $routes->post('profile/update', 'Profile::update');
    $routes->get('profile/security', 'Profile::security');
    $routes->post('profile/updateSecurity', 'Profile::updateSecurity');
    // Master Customer
    $routes->get('mastercustomer', 'MasterCustomer::index');
    $routes->get('mastercustomer/create', 'MasterCustomer::create');
    $routes->post('mastercustomer/save', 'MasterCustomer::save');
    $routes->get('mastercustomer/edit/(:num)', 'MasterCustomer::edit/$1');
    $routes->post('mastercustomer/update/(:num)', 'MasterCustomer::update/$1');
    $routes->get('mastercustomer/delete/(:num)', 'MasterCustomer::delete/$1');
    // Master Sales
    $routes->get('mastersales', 'MasterSales::index');
    $routes->get('mastersales/create', 'MasterSales::create');
    $routes->post('mastersales/save', 'MasterSales::save');
    $routes->get('mastersales/edit/(:num)', 'MasterSales::edit/$1');
    $routes->post('mastersales/update/(:num)', 'MasterSales::update/$1');
    $routes->get('mastersales/delete/(:num)', 'MasterSales::delete/$1');
    // API untuk modal pilih sales
    $routes->get('salesapi', 'SalesApi::index');
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Manajemen User
    $routes->get('user', 'User::index');
    $routes->post('user/store', 'User::store');
    $routes->get('user/create', 'User::create');
    $routes->get('user/edit/(:num)', 'User::edit/$1');
    $routes->post('user/update/(:num)', 'User::update/$1');
    $routes->get('user/delete/(:num)', 'User::delete/$1');

    // --- Rute Penjualan (CRUD Lengkap) ---
    $routes->get('penjualan/edit/(:num)', 'Penjualan::edit/$1'); // Edit penjualan
    $routes->get('penjualan/delete/(:num)', 'Penjualan::delete/$1'); // Soft delete penjualan
    $routes->get('datapenjualan', 'Penjualan::datapenjualan'); // Halaman Data Penjualan
    $routes->get('penjualan', 'Penjualan::index'); // Daftar semua penjualan
    $routes->get('penjualan/new', 'Penjualan::new'); // Form tambah penjualan baru
    $routes->post('penjualan/create', 'Penjualan::create'); // Proses pembuatan penjualan baru
    $routes->get('penjualan/detail/(:num)', 'Penjualan::detail/$1'); // Lihat detail penjualan
    $routes->post('penjualan/addItem/(:num)', 'Penjualan::addItem/$1'); // Tambah item ke penjualan
    $routes->get('penjualan/deleteItem/(:num)', 'Penjualan::deleteItem/$1'); // Hapus item dari penjualan
    $routes->get('penjualan/finalize/(:num)', 'Penjualan::finalize/$1'); // Finalisasi penjualan

    // Batas Tanggal
    $routes->get('batas-tanggal', 'BatasTanggal::index');
    $routes->post('batas-tanggal/update', 'BatasTanggal::update');

    // --- Master Data ---

    // --- Master Data Manual Route ---
    $routes->get('masterkategori', 'MasterKategori::index');
    $routes->get('masterkategori/create', 'MasterKategori::create');
    $routes->post('masterkategori/store', 'MasterKategori::store');
    $routes->get('masterkategori/edit/(:num)', 'MasterKategori::edit/$1');
    $routes->post('masterkategori/update/(:num)', 'MasterKategori::update/$1');
    $routes->post('masterkategori/delete/(:num)', 'MasterKategori::delete/$1');

    $routes->get('masterdaya', 'MasterDaya::index');
    $routes->get('masterdaya/create', 'MasterDaya::create');
    $routes->post('masterdaya/save', 'MasterDaya::save');
    $routes->get('masterdaya/edit/(:num)', 'MasterDaya::edit/$1');
    $routes->post('masterdaya/update/(:num)', 'MasterDaya::update/$1');
    $routes->post('masterdaya/delete/(:num)', 'MasterDaya::delete/$1');

    $routes->get('masterdimensi', 'MasterDimensi::index');
    $routes->get('masterdimensi/create', 'MasterDimensi::create');
    $routes->post('masterdimensi/save', 'MasterDimensi::save');
    $routes->get('masterdimensi/edit/(:num)', 'MasterDimensi::edit/$1');
    $routes->post('masterdimensi/update/(:num)', 'MasterDimensi::update/$1');
    $routes->post('masterdimensi/delete/(:num)', 'MasterDimensi::delete/$1');

    $routes->get('masterfiting', 'MasterFiting::index');
    $routes->get('masterfiting/create', 'MasterFiting::create');
    $routes->post('masterfiting/save', 'MasterFiting::save');
    $routes->get('masterfiting/edit/(:num)', 'MasterFiting::edit/$1');
    $routes->post('masterfiting/update/(:num)', 'MasterFiting::update/$1');
    $routes->post('masterfiting/delete/(:num)', 'MasterFiting::delete/$1');

    $routes->get('mastergondola', 'MasterGondola::index');
    $routes->get('mastergondola/create', 'MasterGondola::create');
    $routes->post('mastergondola/save', 'MasterGondola::save');
    $routes->get('mastergondola/edit/(:num)', 'MasterGondola::edit/$1');
    $routes->post('mastergondola/update/(:num)', 'MasterGondola::update/$1');
    $routes->post('mastergondola/delete/(:num)', 'MasterGondola::delete/$1');

    $routes->get('masterjenis', 'MasterJenis::index');
    $routes->get('masterjenis/create', 'MasterJenis::create');
    $routes->post('masterjenis/save', 'MasterJenis::save');
    $routes->get('masterjenis/edit/(:num)', 'MasterJenis::edit/$1');
    $routes->post('masterjenis/update/(:num)', 'MasterJenis::update/$1');
    $routes->post('masterjenis/delete/(:num)', 'MasterJenis::delete/$1');

    $routes->get('masterjumlahmata', 'MasterJumlahMata::index');
    $routes->get('masterjumlahmata/create', 'MasterJumlahMata::create');
    $routes->post('masterjumlahmata/save', 'MasterJumlahMata::save');
    $routes->get('masterjumlahmata/edit/(:num)', 'MasterJumlahMata::edit/$1');
    $routes->post('masterjumlahmata/update/(:num)', 'MasterJumlahMata::update/$1');
    $routes->post('masterjumlahmata/delete/(:num)', 'MasterJumlahMata::delete/$1');

    $routes->get('masterkaki', 'MasterKaki::index');
    $routes->get('masterkaki/create', 'MasterKaki::create');
    $routes->post('masterkaki/save', 'MasterKaki::save');
    $routes->get('masterkaki/edit/(:num)', 'MasterKaki::edit/$1');
    $routes->post('masterkaki/update/(:num)', 'MasterKaki::update/$1');
    $routes->post('masterkaki/delete/(:num)', 'MasterKaki::delete/$1');

    $routes->get('masterkategori', 'MasterKategori::index');
    $routes->get('masterkategori/create', 'MasterKategori::create');
    $routes->post('masterkategori/save', 'MasterKategori::save');
    $routes->get('masterkategori/edit/(:num)', 'MasterKategori::edit/$1');
    $routes->post('masterkategori/update/(:num)', 'MasterKategori::update/$1');
    $routes->post('masterkategori/delete/(:num)', 'MasterKategori::delete/$1');

    $routes->get('mastermerk', 'MasterMerk::index');
    $routes->get('mastermerk/create', 'MasterMerk::create');
    $routes->post('mastermerk/save', 'MasterMerk::save');
    $routes->get('mastermerk/edit/(:num)', 'MasterMerk::edit/$1');
    $routes->post('mastermerk/update/(:num)', 'MasterMerk::update/$1');
    $routes->post('mastermerk/delete/(:num)', 'MasterMerk::delete/$1');

    $routes->get('mastermodel', 'MasterModel::index');
    $routes->get('mastermodel/create', 'MasterModel::create');
    $routes->post('mastermodel/save', 'MasterModel::save');
    $routes->get('mastermodel/edit/(:num)', 'MasterModel::edit/$1');
    $routes->post('mastermodel/update/(:num)', 'MasterModel::update/$1');
    $routes->post('mastermodel/delete/(:num)', 'MasterModel::delete/$1');

    $routes->get('masterpelengkap', 'MasterPelengkap::index');
    $routes->get('masterpelengkap/create', 'MasterPelengkap::create');
    $routes->post('masterpelengkap/save', 'MasterPelengkap::save');
    $routes->get('masterpelengkap/edit/(:num)', 'MasterPelengkap::edit/$1');
    $routes->post('masterpelengkap/update/(:num)', 'MasterPelengkap::update/$1');
    $routes->post('masterpelengkap/delete/(:num)', 'MasterPelengkap::delete/$1');

    $routes->get('mastersatuan', 'MasterSatuan::index');
    $routes->get('mastersatuan/create', 'MasterSatuan::create');
    $routes->post('mastersatuan/save', 'MasterSatuan::save');
    $routes->get('mastersatuan/edit/(:num)', 'MasterSatuan::edit/$1');
    $routes->post('mastersatuan/update/(:num)', 'MasterSatuan::update/$1');
    $routes->post('mastersatuan/delete/(:num)', 'MasterSatuan::delete/$1');

    $routes->get('masterukuranbarang', 'MasterUkuranBarang::index');
    $routes->get('masterukuranbarang/create', 'MasterUkuranBarang::create');
    $routes->post('masterukuranbarang/save', 'MasterUkuranBarang::save');
    $routes->get('masterukuranbarang/edit/(:num)', 'MasterUkuranBarang::edit/$1');
    $routes->post('masterukuranbarang/update/(:num)', 'MasterUkuranBarang::update/$1');
    $routes->post('masterukuranbarang/delete/(:num)', 'MasterUkuranBarang::delete/$1');

    $routes->get('mastervoltase', 'MasterVoltase::index');
    $routes->get('mastervoltase/create', 'MasterVoltase::create');
    $routes->post('mastervoltase/save', 'MasterVoltase::save');
    $routes->get('mastervoltase/edit/(:num)', 'MasterVoltase::edit/$1');
    $routes->post('mastervoltase/update/(:num)', 'MasterVoltase::update/$1');
    $routes->post('mastervoltase/delete/(:num)', 'MasterVoltase::delete/$1');

    $routes->get('masterwarnabibir', 'MasterWarnaBibir::index');
    $routes->get('masterwarnabibir/create', 'MasterWarnaBibir::create');
    $routes->post('masterwarnabibir/save', 'MasterWarnaBibir::save');
    $routes->get('masterwarnabibir/edit/(:num)', 'MasterWarnaBibir::edit/$1');
    $routes->post('masterwarnabibir/update/(:num)', 'MasterWarnaBibir::update/$1');
    $routes->post('masterwarnabibir/delete/(:num)', 'MasterWarnaBibir::delete/$1');

    $routes->get('masterwarnabody', 'MasterWarnaBody::index');
    $routes->get('masterwarnabody/create', 'MasterWarnaBody::create');
    $routes->post('masterwarnabody/save', 'MasterWarnaBody::save');
    $routes->get('masterwarnabody/edit/(:num)', 'MasterWarnaBody::edit/$1');
    $routes->post('masterwarnabody/update/(:num)', 'MasterWarnaBody::update/$1');
    $routes->post('masterwarnabody/delete/(:num)', 'MasterWarnaBody::delete/$1');

    $routes->get('masterwarnasinar', 'MasterWarnaSinar::index');
    $routes->get('masterwarnasinar/create', 'MasterWarnaSinar::create');
    $routes->post('masterwarnasinar/save', 'MasterWarnaSinar::save');
    $routes->get('masterwarnasinar/edit/(:num)', 'MasterWarnaSinar::edit/$1');
    $routes->post('masterwarnasinar/update/(:num)', 'MasterWarnaSinar::update/$1');
    $routes->post('masterwarnasinar/delete/(:num)', 'MasterWarnaSinar::delete/$1');

    // Master Barang
    $routes->get('masterbarang', 'MasterBarang::index');
    $routes->get('masterbarang/create', 'MasterBarang::create');
    $routes->post('masterbarang/store', 'MasterBarang::store');
    $routes->get('masterbarang/edit/(:num)', 'MasterBarang::edit/$1');
    $routes->post('masterbarang/update/(:num)', 'MasterBarang::update/$1');
    $routes->get('masterbarang/delete/(:num)', 'MasterBarang::delete/$1');

    $routes->get('otorisasi_klasifikasi/otorisasi_kategori', 'Otorisasi_klasifikasi\\OtorisasiKategori::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_kategori/setOtorisasiKategori', 'Otorisasi_klasifikasi\\OtorisasiKategori::setOtorisasiKategori');
    // Otorisasi Klasifikasi Daya
    $routes->get('otorisasi_klasifikasi/otorisasi_daya', 'Otorisasi_klasifikasi\\OtorisasiDaya::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_daya/setOtorisasiDaya', 'Otorisasi_klasifikasi\\OtorisasiDaya::setOtorisasiDaya');
    // Otorisasi Klasifikasi Dimensi
    $routes->get('otorisasi_klasifikasi/otorisasi_dimensi', 'Otorisasi_klasifikasi\\OtorisasiDimensi::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_dimensi/setOtorisasiDimensi', 'Otorisasi_klasifikasi\\OtorisasiDimensi::setOtorisasiDimensi');
    // Otorisasi Klasifikasi Jenis
    $routes->get('otorisasi_klasifikasi/otorisasi_jenis', 'Otorisasi_klasifikasi\\OtorisasiJenis::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_jenis/setOtorisasiJenis', 'Otorisasi_klasifikasi\\OtorisasiJenis::setOtorisasiJenis');
    // Otorisasi Klasifikasi Fiting
    $routes->get('otorisasi_klasifikasi/otorisasi_fiting', 'Otorisasi_klasifikasi\\OtorisasiFiting::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_fiting/setOtorisasiFiting', 'Otorisasi_klasifikasi\\OtorisasiFiting::setOtorisasiFiting');
    // Otorisasi Klasifikasi Gondola
    $routes->get('otorisasi_klasifikasi/otorisasi_gondola', 'Otorisasi_klasifikasi\\OtorisasiGondola::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_gondola/setOtorisasiGondola', 'Otorisasi_klasifikasi\\OtorisasiGondola::setOtorisasiGondola');
    // Otorisasi Klasifikasi Jumlah Mata
    $routes->get('otorisasi_klasifikasi/otorisasi_jumlahmata', 'Otorisasi_klasifikasi\OtorisasiJumlahMata::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_jumlahmata/setOtorisasiJumlahMata', 'Otorisasi_klasifikasi\OtorisasiJumlahMata::setOtorisasiJumlahMata');
    // Otorisasi Klasifikasi Kaki
    $routes->get('otorisasi_klasifikasi/otorisasi_kaki', 'Otorisasi_klasifikasi\OtorisasiKaki::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_kaki/setOtorisasiKaki', 'Otorisasi_klasifikasi\OtorisasiKaki::setOtorisasiKaki');
    // Otorisasi Klasifikasi Merk
    $routes->get('otorisasi_klasifikasi/otorisasi_merk', 'Otorisasi_klasifikasi\\OtorisasiMerk::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_merk/setOtorisasiMerk', 'Otorisasi_klasifikasi\\OtorisasiMerk::setOtorisasiMerk');
    // Otorisasi Klasifikasi Model
    $routes->get('otorisasi_klasifikasi/otorisasi_model', 'Otorisasi_klasifikasi\\OtorisasiModel::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_model/setOtorisasiModel', 'Otorisasi_klasifikasi\\OtorisasiModel::setOtorisasiModel');
    // Otorisasi Klasifikasi Satuan
    $routes->get('otorisasi_klasifikasi/otorisasi_satuan', 'Otorisasi_klasifikasi\\OtorisasiSatuan::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_satuan/setOtorisasiSatuan', 'Otorisasi_klasifikasi\\OtorisasiSatuan::setOtorisasiSatuan');
    // Otorisasi Klasifikasi Pelengkap
    $routes->get('otorisasi_klasifikasi/otorisasi_pelengkap', 'Otorisasi_klasifikasi\\OtorisasiPelengkap::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_pelengkap/setOtorisasiPelengkap', 'Otorisasi_klasifikasi\\OtorisasiPelengkap::setOtorisasiPelengkap');
    // Otorisasi Klasifikasi Ukuran Barang
    $routes->get('otorisasi_klasifikasi/otorisasi_ukuranbarang', 'Otorisasi_klasifikasi\\OtorisasiUkuranBarang::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_ukuranbarang/setOtorisasiUkuranBarang', 'Otorisasi_klasifikasi\\OtorisasiUkuranBarang::setOtorisasiUkuranBarang');
    // Otorisasi Klasifikasi Voltase
    $routes->get('otorisasi_klasifikasi/otorisasi_voltase', 'Otorisasi_klasifikasi\\OtorisasiVoltase::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_voltase/setOtorisasiVoltase', 'Otorisasi_klasifikasi\\OtorisasiVoltase::setOtorisasiVoltase');
    // Otorisasi Klasifikasi Warna Bibir
    $routes->get('otorisasi_klasifikasi/otorisasi_warnabibir', 'Otorisasi_klasifikasi\\OtorisasiWarnaBibir::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_warnabibir/setOtorisasiWarnaBibir', 'Otorisasi_klasifikasi\\OtorisasiWarnaBibir::setOtorisasiWarnaBibir');
    // Otorisasi Klasifikasi Warna Body
    $routes->get('otorisasi_klasifikasi/otorisasi_warnabody', 'Otorisasi_klasifikasi\\OtorisasiWarnaBody::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_warnabody/setOtorisasiWarnaBody', 'Otorisasi_klasifikasi\\OtorisasiWarnaBody::setOtorisasiWarnaBody');
    // Otorisasi Klasifikasi Warna Sinar
    $routes->get('otorisasi_klasifikasi/otorisasi_warnasinar', 'Otorisasi_klasifikasi\\OtorisasiWarnaSinar::index');
    $routes->post('otorisasi_klasifikasi/otorisasi_warnasinar/setOtorisasiWarnaSinar', 'Otorisasi_klasifikasi\\OtorisasiWarnaSinar::setOtorisasiWarnaSinar');
});
