<?php

namespace App\Listeners\TripWasCompleted;

use App\Events\TripWasCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Vsmoraes\Pdf\Pdf;
use App\Invoice;

class GenerateInvoice implements ShouldQueue
{
    private $pdf;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Handle the event.
     *
     * @param  TripWasCompleted  $event
     * @return void
     */
    public function handle(TripWasCompleted $event)
    {
        $trip = $event->trip;

        if ($trip->contract_company!=null){
            $user_data['name'] = $trip->company->name;
            $user_data['address'] = $trip->companyProfile->address;
        } else {
            $user_data['name'] = $trip->user->name;
            $user_data['address'] = $trip->userProfile->address;
        }

        $invoice_header_image = $trip->boat->owner->invoice_header_image;
        $invoice_footer_image = $trip->boat->owner->invoice_footer_image;

        //$converts = new \NumberFormatter('en',\NumberFormatter::SPELLOUT);
        //$amount_in_words =  $converts->format($trip->cost);
        //
        $amount_in_words = $trip->cost;

        $html = view('invoice.trips_invoice2')->with('trip',$trip)->with('invoice_header_image',$invoice_header_image)
            ->with('invoice_footer_image',$invoice_footer_image)->with('amount_in_words',$amount_in_words)
            ->with('user_data',$user_data)->render();
        $filename = '/uploads/invoice/'.$trip->trip_id.'.pdf';
        $this->pdf->load($html,'A3')->filename(public_path().$filename)->output();
        $check = Invoice::where('trip_id','=',$trip->id)->first();
        if($check!=null)
        {
            $check->trip_id = $trip->id;
            $check->filename = $filename;
            $check->save();
        }
        else
        {
            $invoice = new Invoice();
            $invoice->trip_id = $trip->id;
            $invoice->filename = $filename;
            $invoice->invoice_code = uniqid();
            $invoice->save();
        }
    }
}
