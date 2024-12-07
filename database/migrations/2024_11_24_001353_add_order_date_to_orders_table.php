<?php 
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderDateToOrdersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('orders', 'claim_date')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->date('claim_date')->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('orders', 'claim_date')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('claim_date');
            });
        }
    }
}
