<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;
use App\Drug;
use App\MedicalDevice;
use App\Cashier;
use App\DrugCategory;
use App\DrugType;
use App\Supplement;
use App\Supplier;

class ReportController extends Controller
{
    public function CashierReport(Request $request)
    {
        $data['kasir'] = Cashier::select('kode_kasir','foto_kasir','nama_kasir','jumlah_transaksi')
        ->get();
        $pdf = PDF::loadView('pdf.cashier', $data);
        return $pdf->stream();
    }

    public function DrugCategoryReport(Request $request)
    {
        $data['kategori'] = DrugCategory::select('kode_kategoriobat','nama_kategoriobat','deskripsi_kategoriobat')
        ->get();
        $pdf = PDF::loadView('pdf.drug-category', $data);
        return $pdf->stream();
    }

    public function DrugTypeReport(Request $request)
    {
        $data['jenisobat'] = DrugType::select('kode_jenisobat','nama_jenisobat','deskripsi_jenisobat')
        ->get();
        $pdf = PDF::loadView('pdf.drug-type', $data);
        return $pdf->stream();
    }

    public function DrugReport(Request $request)
    {
        $data['obat'] = Drug::select('kode_obat','foto_obat','nama_obat')
        ->get();
        $pdf = PDF::loadView('pdf.drug', $data);
        return $pdf->stream();
    }

    public function MedicalDeviceReport(Request $request)
    {
        $data['alatkesehatan'] = MedicalDevice::select('kode_alatkesehatan','foto_alatkesehatan','nama_alatkesehatan')
        ->get();
        $pdf = PDF::loadView('pdf.medical-device', $data);
        return $pdf->stream();
    }  

    public function SupplementReport(Request $request)
    {
        $data['suplemen'] = Supplement::select('kode_suplemen','foto_suplemen','nama_suplemen')
        ->get();
        $pdf = PDF::loadView('pdf.supplement', $data);
        return $pdf->stream();
    }

    public function SupplierReport(Request $request)
    {
        $data['supplier'] = Supplier::select('kode_supplier','nama_supplier','status')
        ->get();
        $pdf = PDF::loadView('pdf.supplier', $data);
        return $pdf->stream();
    }    
}
