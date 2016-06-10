<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoicePrefixToContractsTable extends Migration
{
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('invoice_prefix')->after('contract_code');
        });
    }
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('invoice_prefix');
        });
    }
}
