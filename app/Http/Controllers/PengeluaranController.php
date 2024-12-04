<?php

namespace App\Http\Controllers;

use App\Exports\PengeluaranExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PengeluaranController extends Controller
{
    public function downloadExcel(Request $request)
{
    return Excel::download(new PengeluaranExport(), 'pengeluaran.xlsx');
}
}
