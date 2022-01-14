<?php

namespace App\Exports;

use App\Supplier;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SupplierReport implements FromView
{
    private $from_date;
    private $to_date;

    public function __construct($from_date, $to_date)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function view(): View
    {
        return view('user.export.supplier', [
            'suppliers' => Supplier::query()
                ->with(['supply', 'supplier_arrear'])
                ->latest()
                ->whereDate('updated_at', '>=', date('Y-m-d', strtotime($this->from_date)))
                ->whereDate('updated_at', '<=', date('Y-m-d', strtotime($this->to_date)))
                ->get()
        ]);
    }
}
