<?php

namespace App\Http\Controllers\Owner;

use App\Boat;
use App\BoatCoardinatorProfile;
use App\BoatOwnerProfile;
use App\RelBoatsCaptains;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReportController extends DashboardController
{
    public function report()
    {
        $data['current_page'] = 'Reports';
        $data['customers'] = Trip::where('owner_id', $this->ownerUserID)->groupBy('user_id')->get();
        $data['boats'] = Boat::where('user_id', $this->ownerUserID)->get();
        $trips = '[]';
        if (Session::has('report_type')&&Session::has('type')) {
            $type = Session::get('type');
            $id = Session::get('id');
            if (Session::get('report_type') == 'daily') {
                $trips = $this->getDailyReport($type, $id);
            }
            if (Session::get('report_type') == 'yesterday') {
                $trips = $this->getYesterdayReport($type, $id);
            }
            elseif(Session::get('report_type') == 'weekly') {
               $trips = $this->getWeeklyReport($type, $id);
            }
            elseif(Session::get('report_type') == 'monthly') {
                $trips = $this->getMonthlyReport($type, $id);
            }
            elseif(Session::get('report_type') == 'last_month') {
                $trips = $this->getLastMonthReport($type, $id);
            }
            elseif(Session::get('report_type') == 'yearly') {
                $trips = $this->getYearlyReport($type, $id);
            }
            elseif (Session::get('report_type') == 'custom') {
                if (Session::has('from') && Session::has('to')) {
                    $from = createDbFormattedDateFromDatePicker(Session::get('from'));
                    $to = createDbFormattedDateFromDatePicker(Session::get('to'));
                    $trips = $this->getCustomReport($type, $id, $from, $to);
                }
            }
        }
        return view('owner.dashboard.report.report', $data)->with('trips', $trips)->with('from', Session::get('from'))->with('to', Session::get('to'))
            ->with('report_type', Session::get('report_type'))
            ->with('type', Session::get('type'))
            ->with('id', Session::get('id'));
    }

    public function report_post()
    {
       // return Input::all();
        if (Input::get('report_type') == 'custom'){
            $rules = [
                'from' => 'required',
                'to' => 'required',
            ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->withInput();
        }
    }
        $type = Input::get('options');
        if($type=='1')
        {
            $id = Input::get('boat_id');
        }
        elseif($type=='2')
        {
            $id = Input::get('customer_id');
        }
        else
        {
            $id = null;
        }
        return redirect('/owner/dashboard/report/trips')->with([
            'from' => Input::get('from'),
            'to' => Input::get('to'),
            'report_type' => Input::get('report_type'),
            'type' => $type,
            'id' => $id,
            'check_session' => 1
        ]);
    }

    public function download_xlxs()
    {
        //return Input::all();
        $rules = [
            'report_type' => 'required',
        ];

        $validator2 = Validator::make(Input::all(), $rules);
        if ($validator2->fails()) {
            return redirect()->back()->withErrors($validator2)->withInput()->withInput();
        }

        if (Input::get('report_type') == 'custom'){
            $rules = [
                'from' => 'required',
                'to' => 'required',
            ];

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->withInput();
            }
        }

        $trips = '[]';
            $type = Input::get('type');
            $id =  Input::get('id');
            if (Input::get('report_type') == 'daily') {
                $trips = $this->getDailyReport($type, $id);
            }
            elseif(Input::get('report_type') == 'weekly') {
                $trips = $this->getWeeklyReport($type, $id);
            }
            elseif(Input::get('report_type') == 'monthly') {
                $trips = $this->getMonthlyReport($type, $id);
            }
            elseif (Input::get('report_type') == 'custom') {
                if (Input::has('from') && Session::has('to')) {
                    $from = createDbFormattedDateFromDatePicker(Input::get('from'));
                    $to = createDbFormattedDateFromDatePicker(Input::get('to'));
                    $trips = $this->getCustomReport($type, $id, $from, $to);
                }
            }

        if($trips=='[]')
        {
            return redirect()->back()->withInput()->withErrors($validator2)->with('error','No Trip Found');
        }
       $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                ),
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        );
            $objPHPExcel = new \PHPExcel();
            $objSheet = $objPHPExcel->getActiveSheet();
            $objSheet->getDefaultColumnDimension()->setWidth(20);
            $objSheet->setTitle('Invoice Report');
            $objSheet->getStyle('A2:AD2')->getFont()->setBold(true)->setSize(12);
            $char = 65;
            $objSheet->getCell(chr($char) . '2')->setValue();
            $char++;
            $objSheet->getCell(chr($char) . '2')->setValue('Customer Name');
            $char++;
            $objSheet->getCell(chr($char) . '2')->setValue('Trip ID');
            $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('PickUp Point');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Drop-off Point');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Amount');
            $row = 3; $total = 0;
            foreach ($trips as $trip) {
                $date = $trip->invoice->created_at;

                $char2 = 65;
                $objSheet->getCell(chr($char2) . $row)->setValue();
                $char2++;
                $objSheet->getCell(chr($char2) . $row)->setValue($trip->user->name);
                $char2++;
                $objSheet->getCell(chr($char2) . $row)->setValue($trip->trip_id);
                $char2++;
                $objSheet->getCell(chr($char2) . $row)->setValue($trip->start->title);
                $char2++;
                $objSheet->getCell(chr($char2) . $row)->setValue($trip->destination->title);
                $char2++;
                $objSheet->getCell(chr($char2) . $row)->setValue($trip->cost);
                $total += $trip->cost;
                $row++;
            }
        $char3 = 65;
        $objSheet->getCell(chr($char3) . $row)->setValue();
        $char3++;
        $objSheet->getCell(chr($char3) . $row)->setValue('Total');
        $objSheet->mergeCells(chr($char3+1) . $row.':'.chr($char3+3) . $row);
        $objSheet->getCell(chr($char3+4) . $row)->setValue($total);

            $objSheet->getStyle('B2:F'.$row)->applyFromArray($styleArray);

            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=\"invoice.xlsx\"");
            header("Cache-Control: max-age=0");
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $objWriter->save('php://output');

    }

    public function collections()
    {
        $data['current_page'] = 'Reports';
        $data['coordinators'] = BoatCoardinatorProfile::where('boat_owner',$this->ownerUserID)->get();
        $boats = Boat::where('user_id',$this->ownerUserID)->get();
        $captains = [];
        foreach($boats as $boat)
        {
            $captains[] =  RelBoatsCaptains::where('boat_id',$boat->id)->get();
        }
        $trips = '[]';
        if(Session::has('type'))
        {
            $type = Session::get('type');
            $id = Session::get('id');
            if($type=='1')
            {
                $trips = Trip::where('status', '=', 'completed')->where('owner_id', '=', $this->ownerUserID)->where('collected_user_type','=','captain')
                    ->where('collected_by_user','=',$id)->get();
            }
            elseif($type=='2')
            {
                $trips = Trip::where('status', '=', 'completed')->where('owner_id', '=', $this->ownerUserID)->where('collected_user_type','=','coordinator')
                    ->where('collected_by_user','=',$id)->get();
            }
            else
            {
                $trips = '[]';
            }
        }
        return view('owner.dashboard.report.collections',$data)->with([
            'captains' => $captains,
            'trips' => $trips,
            'type' => Session::get('type'),
            'id' => Session::get('id')
        ]);
    }

    public function post_collections()
    {
        //return Input::all();
        $type = Input::get('options');
        if($type=='1')
        {
            $id = Input::get('captain_id');
        }
        else
        {
            $id = Input::get('coordinator_id');
        }
        return redirect('owner/dashboard/report/collections')->with([
           'type' => $type,
            'id' => $id
        ]);
    }

    public function download_collections_xlxs()
    {
        $trips = '[]';
        $type = Input::get('type');
        $id = Input::get('id');
        if($type=='1')
        {
            $trips = Trip::where('status', '=', 'completed')->where('owner_id', '=', $this->ownerUserID)->where('collected_user_type','=','captain')
                ->where('collected_by_user','=',$id)->get();
        }
        elseif($type=='2')
        {
            $trips = Trip::where('status', '=', 'completed')->where('owner_id', '=', $this->ownerUserID)->where('collected_user_type','=','coordinator')
                ->where('collected_by_user','=',$id)->get();
        }
        else
        {
            $trips = '[]';
        }
        if($trips=='[]')
        {
            return redirect()->back()->withInput()->with('error','No Trip Found');
        }
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                ),
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        );
        $objPHPExcel = new \PHPExcel();
        $objSheet = $objPHPExcel->getActiveSheet();
        $objSheet->getDefaultColumnDimension()->setWidth(20);
        $objSheet->setTitle('Invoice Report');
        $objSheet->getStyle('A2:AD2')->getFont()->setBold(true)->setSize(12);
        $char = 65;
        $objSheet->getCell(chr($char) . '2')->setValue();
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Customer Name');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Trip ID');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('PickUp Point');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Drop-off Point');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Collected User Type');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Payment Method');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Amount');
        $row = 3; $total = 0;
        foreach ($trips as $trip) {
            $date = $trip->invoice->created_at;

            $char2 = 65;
            $objSheet->getCell(chr($char2) . $row)->setValue();
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->user->name);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->trip_id);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->start->title);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->destination->title);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->collected_user_type);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->payment_method);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->cost);
            $total += $trip->cost;
            $row++;
        }
        $char3 = 65;
        $objSheet->getCell(chr($char3) . $row)->setValue();
        $char3++;
        $objSheet->getCell(chr($char3) . $row)->setValue('Total');
        $objSheet->mergeCells(chr($char3+1) . $row.':'.chr($char3+5) . $row);
        $objSheet->getCell(chr($char3+6) . $row)->setValue($total);

        $objSheet->getStyle('B2:H'.$row)->applyFromArray($styleArray);

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"invoice.xlsx\"");
        header("Cache-Control: max-age=0");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');
    }

    public function billing_statements()
    {
        $data['current_page'] = 'Reports';
        $data['customers'] = Trip::where('owner_id', $this->ownerUserID)->groupBy('user_id')->get();
        $data['boats'] = Boat::where('user_id', $this->ownerUserID)->get();
        $trips = '[]';
        if (Session::has('report_type')&&Session::has('type')) {
            $type = Session::get('type');
            $id = Session::get('id');
            if (Session::get('report_type') == 'daily') {
                $trips = $this->getDailyReport($type, $id);
            }
            if (Session::get('report_type') == 'yesterday') {
                $trips = $this->getYesterdayReport($type, $id);
            }
            elseif(Session::get('report_type') == 'weekly') {
                $trips = $this->getWeeklyReport($type, $id);
            }
            elseif(Session::get('report_type') == 'monthly') {
                $trips = $this->getMonthlyReport($type, $id);
            }
            elseif(Session::get('report_type') == 'last_month') {
                $trips = $this->getLastMonthReport($type, $id);
            }
            elseif(Session::get('report_type') == 'yearly') {
                $trips = $this->getYearlyReport($type, $id);
            }
            elseif (Session::get('report_type') == 'custom') {
                if (Session::has('from') && Session::has('to')) {
                    $from = createDbFormattedDateFromDatePicker(Session::get('from'));
                    $to = createDbFormattedDateFromDatePicker(Session::get('to'));
                    $trips = $this->getCustomReport($type, $id, $from, $to);
                }
            }
        }
        return view('owner.dashboard.report.billing_statements', $data)->with('trips', $trips)->with('from', Session::get('from'))->with('to', Session::get('to'))
            ->with('report_type', Session::get('report_type'))
            ->with('type', Session::get('type'))
            ->with('id', Session::get('id'));
    }

    public function post_billing_statements()
    {
        // return Input::all();
        if (Input::get('report_type') == 'custom'){
            $rules = [
                'from' => 'required',
                'to' => 'required',
            ];

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->withInput();
            }
        }
        $type = Input::get('options');
        if($type=='1')
        {
            $id = Input::get('boat_id');
        }
        elseif($type=='2')
        {
            $id = Input::get('customer_id');
        }
        else
        {
            $id = null;
        }
        return redirect('/owner/dashboard/report/billing_statements')->with([
            'from' => Input::get('from'),
            'to' => Input::get('to'),
            'report_type' => Input::get('report_type'),
            'type' => $type,
            'id' => $id
        ]);
    }

    public function download_billing_statements_xlxs()
    {
        //return Input::all();
        $rules = [
            'report_type' => 'required',
        ];

        $validator2 = Validator::make(Input::all(), $rules);
        if ($validator2->fails()) {
            return redirect()->back()->withErrors($validator2)->withInput()->withInput();
        }

        if (Input::get('report_type') == 'custom'){
            $rules = [
                'from' => 'required',
                'to' => 'required',
            ];

            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->withInput();
            }
        }

        $trips = '[]';
        $type = Input::get('type');
        $id =  Input::get('id');
        if (Input::get('report_type') == 'daily') {
            $trips = $this->getDailyReport($type, $id);
        }
        elseif(Input::get('report_type') == 'weekly') {
            $trips = $this->getWeeklyReport($type, $id);
        }
        elseif(Input::get('report_type') == 'monthly') {
            $trips = $this->getMonthlyReport($type, $id);
        }
        elseif (Input::get('report_type') == 'custom') {
            if (Input::has('from') && Session::has('to')) {
                $from = createDbFormattedDateFromDatePicker(Input::get('from'));
                $to = createDbFormattedDateFromDatePicker(Input::get('to'));
                $trips = $this->getCustomReport($type, $id, $from, $to);
            }
        }

        if($trips=='[]')
        {
            return redirect()->back()->withInput()->withErrors($validator2)->with('error','No Trip Found');
        }
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                ),
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        );
        $objPHPExcel = new \PHPExcel();
        $objSheet = $objPHPExcel->getActiveSheet();
        $objSheet->getDefaultColumnDimension()->setWidth(20);
        $objSheet->setTitle('Invoice Report');
        $objSheet->getStyle('A2:AD2')->getFont()->setBold(true)->setSize(12);
        $char = 65;
        $objSheet->getCell(chr($char) . '2')->setValue();
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Customer Name');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Trip ID');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('PickUp Point');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Drop-off Point');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Invoice Code');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Invoice Date');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Amount');
        $row = 3; $total = 0;
        foreach ($trips as $trip) {
            $date = $trip->invoice->created_at;

            $char2 = 65;
            $objSheet->getCell(chr($char2) . $row)->setValue();
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->user->name);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->trip_id);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->start->title);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->destination->title);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->invoice->invoice_code);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->invoice->created_at->format('Y-m-d'));
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->cost);
            $total += $trip->cost;
            $row++;
        }
        $char3 = 65;
        $objSheet->getCell(chr($char3) . $row)->setValue();
        $char3++;
        $objSheet->getCell(chr($char3) . $row)->setValue('Total');
        $objSheet->mergeCells(chr($char3+1) . $row.':'.chr($char3+5) . $row);
        $objSheet->getCell(chr($char3+6) . $row)->setValue($total);

        $objSheet->getStyle('B2:H'.$row)->applyFromArray($styleArray);

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"invoice.xlsx\"");
        header("Cache-Control: max-age=0");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');

    }

    private function getDailyReport($type, $id)
    {
        if($type=='1'){
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('user_id','=',$id)->get();
            }
        }
       return $trips;
    }
    private function getYesterdayReport($type, $id)
    {
        if($type=='1'){
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->subDay()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->subDay()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->subDay()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->subDay()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getWeeklyReport($type, $id)
    {
        $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
        $tillDate = Carbon::now()->toDateString();
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', $fromDate)->where('trip_date', '<=',$tillDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', $fromDate)->where('trip_date', '<=',$tillDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', $fromDate)->where('trip_date', '<=',$tillDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', $fromDate)->where('trip_date', '<=',$tillDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getMonthlyReport($type, $id)
    {
        $fromDate = Carbon::now()->month; // or ->format(..)
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }else
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }else
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('user_id','=',$id)->get();
            }
        }
         return $trips;
    }
    private function getLastMonthReport($type, $id)
    {
        $fromDate = Carbon::now()->month-1; // or ->format(..)
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }else
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }else
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getYearlyReport($type, $id)
    {
        $fromDate = Carbon::now()->year; // or ->format(..)
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('YEAR(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }else
            {
                $trips = Trip::where(DB::raw('YEAR(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('YEAR(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }else
            {
                $trips = Trip::where(DB::raw('YEAR(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getCustomReport($type, $id, $from, $to)
    {
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', $from)->where('trip_date', '<=', $to)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', $from)->where('trip_date', '<=', $to)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', $from)->where('trip_date', '<=', $to)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('user_id','=',$id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', $from)->where('trip_date', '<=', $to)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $this->ownerUserID)->where('user_id','=',$id)->get();
            }
        }
         return $trips;
    }

}
