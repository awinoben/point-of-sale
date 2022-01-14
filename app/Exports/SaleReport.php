<?php

namespace App\Exports;

use App\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SaleReport implements FromView
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
        return view('user.export.sale', [
            'sells' => Sale::query()
                ->with(['user', 'purchase', 'payment_mode', 'stock'])
                ->latest()
                ->whereDate('updated_at', '>=', date('Y-m-d', strtotime($this->from_date)))
                ->whereDate('updated_at', '<=', date('Y-m-d', strtotime($this->to_date)))
                ->get()
        ]);
    }
}
