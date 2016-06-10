<?php
namespace App\Http\Controllers\User;

use App\BoatOwnerProfile;
use App\BoatUserProfile;
use App\Trip;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ReportController extends DashboardController
{
    public function report()
    {
        $data['current_page'] = 'Reports';
        if(Session::has('from')&&Session::has('to'))
        {
            $from = createDbFormattedDateFromDatePicker(Session::get('from'));
            $to = createDbFormattedDateFromDatePicker(Session::get('to'));
            $trips = Trip::where('trip_date','>=',$from)->where('trip_date','<=',$to)->where('status','=','completed')->where('user_id','=',$this->boatUserID)->get();
            return view('user.dashboard.report.report',$data)->with('trips',$trips)->with('from',Session::get('from'))->with('to',Session::get('to'));
        }
        else
        {
            $trips = '[]';
            return view('user.dashboard.report.report',$data)->with('trips',$trips)->with('from',Session::get('from'))->with('to',Session::get('to'));
        }
    }

    public function report_post()
    {
        $rules = [
            'from' => 'required',
            'to'=>'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput();
        }
        return redirect('/user/dashboard/report')->with('from',Input::get('from'))->with('to',Input::get('to'));
    }

    public function download_xlxs()
    {
        // return Input::all();

        $rules = [
            'from' => 'required',
            'to'=>'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput();
        }
        $from = createDbFormattedDateFromDatePicker(Input::get('from'));
        $to = createDbFormattedDateFromDatePicker(Input::get('to'));
        $trips = Trip::where('trip_date','>=',$from)->where('trip_date','<=',$to)->where('status','=','completed')->where('user_id','=',$this->boatUserID)->get();
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
}
