<?php namespace ShahiemSeymor\Todo\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class RenameProgressField extends Migration
{

    public function up()
    {
        Schema::table('shahiemseymor_todo', function($table)
        {
            $table->renameColumn('progress', 'progress_val');
        });
    }

    public function down()
    {
        Schema::table('shahiemseymor_todo', function($table)
        {
            $table->dropColumn('progress');
        });
    }

}
