<?php

namespace App\Http\Controllers\Coordinator;

use App\Boat;
use App\BoatUserProfile;
use App\Contracts;
use File;
use App\Http\Requests;
use Auth;
use Validator;
use Sentinel;
use App\Catalog;
use App\CatalogInfo;
use \App\BaseAnchorage;

class CatalogController extends DashboardController
{

    public function catalogs($id)
    {
        $data['current_page'] = 'Catalogs';
        $boat = Boat::find($id);
        $companies = Contracts::where('owner_id', '=', $boat->user_id)->get();
        $one_way = Catalog::where('contract_id', '=', null)->where('owner_id', '=',$boat->user_id)->where('zone', '=', $boat->operating_zone)->where('boat_type', '=', $boat->manning_type)->where('trip_type', '=', 'one way')->where('status', '=', 'active')->first();
        $returning = Catalog::where('contract_id', '=', null)->where('owner_id', '=',$boat->user_id)->where('zone', '=', $boat->operating_zone)->where('boat_type', '=', $boat->manning_type)->where('trip_type', '=', 'returning')->where('status', '=', 'active')->first();
        return view('coordinator.dashboard.catalog.catalogs', $data)->with([
            'companies' => $companies,
            'one_way' => $one_way,
            'returning' => $returning,
            'boat' => $boat
        ]);
    }
    public function manage_catalogs($boat_type, $trip_type, $zone, $owner_id,$company_id = null)
    {
        $data['current_page'] = 'Catalogs : Manage Catalog';
        $anchorages = BaseAnchorage::where('type', $zone)->get();
        $catalogs = getCatalog($owner_id, $company_id, $trip_type, $boat_type, $zone);
        if($catalogs==null)
        {
            return view('coordinator.dashboard.catalog.manage_catalog', $data)->with([
                'anchorages' => $anchorages,
                'catalogs' => $catalogs,
            ]);
        }
        $check_catalog = \App\CatalogInfo::where('catalogs_id', '=', $catalogs->id)->first();
        $data2 = [];
        $count = 0;
        foreach ($anchorages as $anchorage) {
            $count++;
            $count2 = 0;
            foreach ($anchorages as $anchorage2) {
                $count2++;
                if ($catalogs) {
                    $catalog_data = \App\CatalogInfo::where('start_point', '=', $anchorage->id)->where('destination_point', '=', $anchorage2->id)->where('catalogs_id', '=', $catalogs->id)->first();
                } else {
                    $catalog_data = null;
                }

                if ($catalog_data == null) {
                    $cost = '';
                } else {
                    $cost = $catalog_data->cost;
                }
                $data2[$count][$count2]['title'] = $anchorage->title;
                $data2[$count][$count2]['cost'] = $cost;
            }

        }

        return view('coordinator.dashboard.catalog.manage_catalog', $data)->with([
            'anchorages' => $anchorages,
            'catalogs' => $catalogs,
            'data2' => $data2,
            'check_catalog'=>$check_catalog
        ]);
    }

    public function downloadExcel($catalog_id,$zone)
    {
        $starts = CatalogInfo::where('catalogs_id','=',$catalog_id)->groupBY('start_point')->get();
        $destinations = CatalogInfo::where('catalogs_id','=',$catalog_id)->groupBY('destination_point')->get();
        if($starts=='[]')
        {
            return redirect()->back()->with('error','No Catalog Found');
        }
        // return $starts;
        $objPHPExcel = new \PHPExcel();
        $objSheet = $objPHPExcel->getActiveSheet();
        $objSheet->setTitle($zone);
        $objSheet->getStyle('A1:AD1')->getFont()->setBold(true)->setSize(12);
        $char =65;
        $objSheet->getCell(chr($char).'1')->setValue();
        $char++;
        foreach($starts as $start)
        {
            $objSheet->getCell(chr($char).'1')->setValue($start->start->title);
            $char++;
        }
        $row = 2;
        foreach($starts as $start){
            $char2 =65;
            $objSheet->getCell(chr($char2).$row)->setValue($start->start->title);
            $char2++;
            foreach($destinations as $destination)
            {
                $data = CatalogInfo::where('catalogs_id','=',$catalog_id)->where('start_point','=',$start->start_point)->where('destination_point','=',$destination->destination_point)->first();
                if($data!=null)
                {
                    $objSheet->getCell(chr($char2).$row)->setValue($data->cost);
                }
                $char2++;
            }
            $row++;
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"rate.xlsx\"");
        header("Cache-Control: max-age=0");
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');
    }

}
