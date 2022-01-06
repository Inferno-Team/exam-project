<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('years')->insert([
            'name' => 'السنة الأولى'
        ]);
        DB::table('years')->insert([
            'name' => 'السنة الثانية'
        ]);
        DB::table('years')->insert([
            'name' => 'السنة الثالثة'
        ]);
        DB::table('years')->insert([
            'name' => 'السنة الرابعة'
        ]);
        DB::table('years')->insert([
            'name' => 'السنة الخامسة'
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('years');
    }
}
