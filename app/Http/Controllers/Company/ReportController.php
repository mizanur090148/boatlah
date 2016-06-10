<?php

namespace App\Http\Controllers\Company;

use App\BaseAnchorage;
use App\BoatUserProfile;
use App\Trip;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class ReportController extends DashboardController
{
    public function report()
    {
        $data['current_page'] = 'Reports';
        $data['anchorages'] = BaseAnchorage::all();
        $data['employees'] = BoatUserProfile::where('company_id',$this->companyUserID)->get();
        $trips = '[]';
        if(Session::has('type'))
        {
            $type = Session::get('type');
            $id = Session::get('id');
            if($type=='1')
            {
                $trips = Trip::where('status', '=', 'completed')->where('contract_company',$this->companyUserID)
                    ->where('start_point',$id)->get();
            }
            elseif($type=='2')
            {
                $trips = Trip::where('status', '=', 'completed')->where('contract_company',$this->companyUserID)->where('user_id',$id)->get();
            }
            else
            {
                $trips = '[]';
            }
        }
        return view('company.dashboard.report.report',$data)->with([
            'trips' => $trips,
            'type' => Session::get('type'),
            'id' => Session::get('id')
        ]);
    }

    public function report_post()
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
        return redirect('/company/dashboard/report')->with([
            'type' => $type,
            'id' => $id
        ]);
    }

    public function download_xlxs()
    {
        $trips = '[]';
        $type = Input::get('type');
        $id = Input::get('id');
        if($type=='1')
        {
            $trips = Trip::where('status', '=', 'completed')->where('contract_company',$this->companyUserID)
                ->where('start_point',$id)->get();
        }
        elseif($type=='2')
        {
            $trips = Trip::where('status', '=', 'completed')->where('contract_company',$this->companyUserID)->where('user_id',$id)->get();
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

    public function billing_statements()
    {
        $data['current_page'] = 'Reports';
        $data['anchorages'] = BaseAnchorage::all();
        $data['employees'] = BoatUserProfile::where('company_id',$this->companyUserID)->get();
        $trips = '[]';
        if(Session::has('type'))
        {
            $type = Session::get('type');
            $id = Session::get('id');
            if($type=='1')
            {
                $trips = Trip::where('status', '=', 'completed')->where('contract_company',$this->companyUserID)
                    ->where('start_point',$id)->get();
            }
            elseif($type=='2')
            {
                $trips = Trip::where('status', '=', 'completed')->where('contract_company',$this->companyUserID)->where('user_id',$id)->get();
            }
            else
            {
                $trips = '[]';
            }
        }
        return view('company.dashboard.report.billing_statements',$data)->with([
            'trips' => $trips,
            'type' => Session::get('type'),
            'id' => Session::get('id')
        ]);
    }

    public function billing_statements_post()
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
        return redirect('/company/dashboard/billing_statements')->with([
            'type' => $type,
            'id' => $id
        ]);
    }

    public function download_billing_statements_xlxs()
    {
        $trips = '[]';
        $type = Input::get('type');
        $id = Input::get('id');
        if($type=='1')
        {
            $trips = Trip::where('status', '=', 'completed')->where('contract_company',$this->companyUserID)
                ->where('start_point',$id)->get();
        }
        elseif($type=='2')
        {
            $trips = Trip::where('status', '=', 'completed')->where('contract_company',$this->companyUserID)->where('user_id',$id)->get();
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
        $objSheet->getCell(chr($char) . '2')->setValue('Invoice No.');
        $char++;
        $objSheet->getCell(chr($char) . '2')->setValue('Date of Invoice');
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
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->invoice->invoice_code);
            $char2++;
            $objSheet->getCell(chr($char2) . $row)->setValue($trip->invoice->created_at->format('Y-m-d'));
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
        $objSheet->getCell(chr($char3+8) . $row)->setValue($total);

        $objSheet->getStyle('B2:J'.$row)->applyFromArray($styleArray);

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"invoice.xlsx\"");
        header("Cache-Control: max-age=0");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');
    }
}
