<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class RoomsAvailabilityExport implements FromView, ShouldAutoSize, ShouldQueue {

    use Exportable;
    use Queueable;

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }


    public function view(): View {
        return view('exports.rooms_availability', [
            'hotel' => $this->data['hotel'],
            'rooms' => $this->data['rooms'],
            'dates' => $this->data['dates'],
        ]);
    }

}
