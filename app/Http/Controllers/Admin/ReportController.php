<?php

namespace App\Http\Controllers\Admin;

use App\BaseAnchorage;
use App\Boat;
use App\BoatOwnerProfile;
use App\BoatUserProfile;
use App\Http\Controllers\Controller;
use App\ShippingCompanyProfile;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Sentinel;

class ReportController extends Controller
{
    public function owner_reports()
    {
        $owners = BoatOwnerProfile::all();
        return view('admin.reports.owner_reports')->with('owners',$owners);
    }

    public function owner_reports_post()
    {
        //return Input::all();

        $rules = [
            'name' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect('/admin/dashboard/owner_reports/trips/'.Input::get('name'));
    }

    public function owner_trips_report($owner_id)
    {
        $data['customers'] = Trip::where('owner_id',$owner_id)->groupBy('user_id')->get();
        $data['boats'] = Boat::where('user_id', $owner_id)->get();
        $trips = '[]';
        if (Session::has('report_type')&&Session::has('type')) {
            $type = Session::get('type');
            $id = Session::get('id');
            if (Session::get('report_type') == 'daily') {
                $trips = $this->getDailyReport($type, $id,$owner_id);
            }
            if (Session::get('report_type') == 'yesterday') {
                $trips = $this->getYesterdayReport($type, $id,$owner_id);
            }
            elseif(Session::get('report_type') == 'weekly') {
                $trips = $this->getWeeklyReport($type, $id,$owner_id);
            }
            elseif(Session::get('report_type') == 'monthly') {
                $trips = $this->getMonthlyReport($type, $id,$owner_id);
            }
            elseif(Session::get('report_type') == 'last_month') {
                $trips = $this->getLastMonthReport($type, $id,$owner_id);
            }
            elseif(Session::get('report_type') == 'yearly') {
                $trips = $this->getYearlyReport($type, $id,$owner_id);
            }
            elseif (Session::get('report_type') == 'custom') {
                if (Session::has('from') && Session::has('to')) {
                    $from = createDbFormattedDateFromDatePicker(Session::get('from'));
                    $to = createDbFormattedDateFromDatePicker(Session::get('to'));
                    $trips = $this->getCustomReport($type, $id, $from, $to,$owner_id);
                }
            }
        }
        return view('admin.reports.owner_trips_report', $data)->with('trips', $trips)->with('from', Session::get('from'))->with('to', Session::get('to'))
            ->with('report_type', Session::get('report_type'))
            ->with('type', Session::get('type'))
            ->with('owner_id', $owner_id)
            ->with('id', Session::get('id'));
    }

    public function owner_trips_report_post($owner_id)
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
        return redirect('/admin/dashboard/owner_reports/trips/'.$owner_id)->with([
            'from' => Input::get('from'),
            'to' => Input::get('to'),
            'report_type' => Input::get('report_type'),
            'type' => $type,
            'id' => $id
        ]);
    }

    public function owner_trips_report_download_xlxs($owner_id)
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
            $trips = $this->getDailyReport($type, $id,$owner_id);
        }
        elseif(Input::get('report_type') == 'weekly') {
            $trips = $this->getWeeklyReport($type, $id,$owner_id);
        }
        elseif(Input::get('report_type') == 'monthly') {
            $trips = $this->getMonthlyReport($type, $id,$owner_id);
        }
        elseif (Input::get('report_type') == 'custom') {
            if (Input::has('from') && Session::has('to')) {
                $from = createDbFormattedDateFromDatePicker(Input::get('from'));
                $to = createDbFormattedDateFromDatePicker(Input::get('to'));
                $trips = $this->getCustomReport($type, $id, $from, $to,$owner_id);
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

    public function company_reports()
{
    $companies = ShippingCompanyProfile::all();
    return view('admin.reports.company_reports')->with('companies',$companies);
}

    public function company_reports_post()
    {
        //return Input::all();

        $rules = [
            'name' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect('/admin/dashboard/company_reports/trips/'.Input::get('name'));
    }

    public function company_trips_report($company_id)
    {
        $data['anchorages'] = BaseAnchorage::all();
        $data['employees'] = BoatUserProfile::where('company_id',$company_id)->get();
        $trips = '[]';
        if(Session::has('type'))
        {
            $type = Session::get('type');
            $id = Session::get('id');
            if($type=='1')
            {
                $trips = Trip::where('status', '=', 'completed')->where('contract_company',$company_id)
                    ->where('start_point',$id)->get();
            }
            elseif($type=='2')
            {
                $trips = Trip::where('status', '=', 'completed')->where('contract_company',$company_id)->where('user_id',$id)->get();
            }
            else
            {
                $trips = '[]';
            }
        }
        return view('admin.reports.company_trips_report',$data)->with([
            'trips' => $trips,
            'type' => Session::get('type'),
            'company_id' => $company_id,
            'id' => Session::get('id')
        ]);
    }

    public function company_trips_report_post($company_id)
    {
        //return Input::all();
        $type = Input::get('options');
        if($type=='1')
        {
            $id = Input::get('anchorage_id');
        }
        else
        {
            $id = Input::get('employee_id');
        }
        return redirect('/admin/dashboard/company_reports/trips/'.$company_id)->with([
            'type' => $type,
            'id' => $id
        ]);
    }

    public function company_trips_report_download_xlxs($company_id)
    {
        $trips = '[]';
        $type = Input::get('type');
        $id = Input::get('id');
        if($type=='1')
        {
            $trips = Trip::where('status', '=', 'completed')->where('contract_company',$company_id)
                ->where('start_point',$id)->get();
        }
        elseif($type=='2')
        {
            $trips = Trip::where('status', '=', 'completed')->where('contract_company',$company_id)->where('user_id',$id)->get();
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

    public function user_reports()
    {
        $users = BoatUserProfile::all();
        return view('admin.reports.user_reports')->with('users',$users);
    }

    public function user_reports_post()
    {
        //return Input::all();

        $rules = [
            'name' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return redirect('/admin/dashboard/user_reports/trips/'.Input::get('name'));
    }

    public function user_trips_report($user_id)
    {
        if(Session::has('from')&&Session::has('to'))
        {
            $from = createDbFormattedDateFromDatePicker(Session::get('from'));
            $to = createDbFormattedDateFromDatePicker(Session::get('to'));
            $trips = Trip::where('trip_date','>=',$from)->where('trip_date','<=',$to)->where('status','=','completed')->where('user_id','=',$user_id)->get();
            return view('admin.reports.user_trips_report')->with('trips',$trips)->with('from',Session::get('from'))->with('to',Session::get('to'))->with('user_id',$user_id);
        }
        else
        {
            $trips = '[]';
            return view('admin.reports.user_trips_report')->with('trips',$trips)->with('from',Session::get('from'))->with('to',Session::get('to'))->with('user_id',$user_id);
        }
    }

    public function user_trips_report_post($user_id)
    {
        $rules = [
            'from' => 'required',
            'to'=>'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput();
        }
        return redirect('/admin/dashboard/user_reports/trips/'.$user_id)->with('from',Input::get('from'))->with('to',Input::get('to'));
    }

    public function user_trips_report_download_xlxs($user_id)
    {
        // return Input::all();

        $rules = [
            'from' => 'required',
            'to'=>'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','No Date Given');
        }
        $from = createDbFormattedDateFromDatePicker(Input::get('from'));
        $to = createDbFormattedDateFromDatePicker(Input::get('to'));
        $trips = Trip::where('trip_date','>=',$from)->where('trip_date','<=',$to)->where('status','=','completed')->where('user_id','=',$user_id)->get();
        if($trips=='[]')
        {
            return redirect()->back()->withInput()->withErrors($validator)->with('error','No Trip Found');
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
        $objSheet->getCell(chr($char) . '2')->setValue('Owner Name');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Trip ID');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('PickUp Point');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Drop-off Point');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Invoice No.');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Date of Invoice');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Amount');
        $row = 3; $total = 0;
        foreach ($trips as $trip) {
            $char2 = 65;
            $objSheet->getCell(chr($char2) . $row)->setValue();
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->owner->name);
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

    private function getDailyReport($type, $id, $owner_id)
    {
        if($type=='1'){
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getYesterdayReport($type, $id, $owner_id)
    {
        if($type=='1'){
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->subDay()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->subDay()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->subDay()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', Carbon::now()->subDay()->toDateString())->where('trip_date', '<=', Carbon::now()->toDateString())->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getWeeklyReport($type, $id, $owner_id)
    {
        $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
        $tillDate = Carbon::now()->toDateString();
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', $fromDate)->where('trip_date', '<=',$tillDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', $fromDate)->where('trip_date', '<=',$tillDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', $fromDate)->where('trip_date', '<=',$tillDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', $fromDate)->where('trip_date', '<=',$tillDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getMonthlyReport($type, $id, $owner_id)
    {
        $fromDate = Carbon::now()->month; // or ->format(..)
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=',$owner_id)->get();
            }else
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }else
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getLastMonthReport($type, $id, $owner_id)
    {
        $fromDate = Carbon::now()->month-1; // or ->format(..)
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }else
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }else
            {
                $trips = Trip::where(DB::raw('MONTH(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getYearlyReport($type, $id, $owner_id)
    {
        $fromDate = Carbon::now()->year; // or ->format(..)
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('YEAR(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }else
            {
                $trips = Trip::where(DB::raw('YEAR(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where(DB::raw('YEAR(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }else
            {
                $trips = Trip::where(DB::raw('YEAR(trip_date)'),'=', $fromDate)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
    private function getCustomReport($type, $id, $from, $to, $owner_id)
    {
        if($type == '1')
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', $from)->where('trip_date', '<=', $to)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', $from)->where('trip_date', '<=', $to)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('boat_id','=',$id)->get();
            }
        }
        else
        {
            if($id==0)
            {
                $trips = Trip::where('trip_date', '>=', $from)->where('trip_date', '<=', $to)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('user_id','=',$id)->get();
            }
            else
            {
                $trips = Trip::where('trip_date', '>=', $from)->where('trip_date', '<=', $to)->where('status', '=', 'completed')
                    ->where('owner_id', '=', $owner_id)->where('user_id','=',$id)->get();
            }
        }
        return $trips;
    }
}
