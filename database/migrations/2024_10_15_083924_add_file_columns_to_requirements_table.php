<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileColumnsToRequirementsTable extends Migration
{
    public function up()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->string('file_name')->after('requirement_name'); // Add file_name column
            $table->string('file_path')->after('file_name'); // Add file_path column
        });
    }

    public function down()
    {
        Schema::table('requirements', function (Blueprint $table) {
            $table->dropColumn(['file_name', 'file_path']); // Drop columns if rolling back
        });
    }
}
