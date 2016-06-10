<?php

namespace App\lib;

use App\CatalogRelation;
use App\CatalogsParent;

class Catalog
{

    public static function manage_catalog_with_company($catalog_name, $company_id, $owner_id)
    {
        $zones = ['Eastern', 'Western'];
        $catalog_code = $catalog_name;
        foreach ($zones as $zone) {
            $catalogs_parent_id = self::create_catalog_parent($catalog_code, $owner_id, $company_id, 'non-standard');
            $catalogs = self::create_catalog($catalogs_parent_id, $zone);
        }
    }

    public static function create_catalog_parent($catalog_code, $owner_id, $company_id, $catalog_type)
    {
        $catalogs = CatalogsParent::firstOrCreate(['catalogs_code' => $catalog_code, 'owner_id' => $owner_id, 'company_id' => $company_id, 'catalog_type' => $catalog_type]);
        return $catalogs->id;
    }

    public static function create_catalog($catalogs_parent_id, $zone)
    {
        $catalogs = \App\Catalog::firstOrCreate(['catalogs_parent_id' => $catalogs_parent_id, 'zone' => $zone]);
        return $catalogs;
    }

    public static function create_catalog_relation($catalogs_parent_id, $principle_ids)
    {
        foreach ($principle_ids as $principle_id) {
            CatalogRelation::firstOrCreate(['catalogs_parent_id' => $catalogs_parent_id, 'principle_id' => $principle_id]);
        }
    }

    public static function make_catalog_pending_by_parent_id($catalogs_parent_id)
    {
        $catalogs = \App\Catalog::where('catalogs_parent_id', '=', $catalogs_parent_id)->get();
        foreach ($catalogs as $catalog) {
            $catalog->status = 'pending';
            $catalog->save();
        }
    }

    public static function make_catalog_pending_by_catalog_id($catalogs_id)
    {
        $catalog = \App\Catalog::where('id', '=', $catalogs_id)->first();
        $catalog->status = 'pending';
        $catalog->save();
    }

}