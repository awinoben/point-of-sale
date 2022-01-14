<?php

namespace App\Exports;

use App\Price;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ItemReport implements FromView
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
        return view('user.export.item', [
            'prices' => Price::query()
                ->with(['stock', 'supply', 'sale'])
                ->latest()
                ->whereDate('updated_at', '>=', date('Y-m-d', strtotime($this->from_date)))
                ->whereDate('updated_at', '<=', date('Y-m-d', strtotime($this->to_date)))
                ->get()
        ]);
    }
}
