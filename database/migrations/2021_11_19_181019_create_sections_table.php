<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        DB::table('sections')->insert([
            'name' => 'علوم أساسية'
        ]);
        DB::table('sections')->insert([
            'name' => 'برمجيات'
        ]);
        DB::table('sections')->insert([
            'name' => 'شبكات'
        ]);
        DB::table('sections')->insert([
            'name' => 'ذكاء صنعي'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
