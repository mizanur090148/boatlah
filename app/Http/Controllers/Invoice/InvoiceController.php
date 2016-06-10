<?php

namespace App\Http\Controllers\Invoice;

use App\Invoice;
use App\Trip;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Sentinel;
use Vsmoraes\Pdf\Pdf;

use Event;
use App\Events\TripWasCompleted;

class InvoiceController extends Controller
{
    private $pdf;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function trip_invoice($trip_unique_id)
    {
        Event::fire(new TripWasCompleted($trip_unique_id));
    }

    public function download($id)
    {
        $invoice = Invoice::where('trip_id','=',$id)->first();
        if($invoice!=null){
            $file=  public_path().$invoice->filename;
            $headers = array(
                'Content-Type: application/pdf',
            );
            return Response::download($file, 'invoice.pdf', $headers);
        }
    }
}
