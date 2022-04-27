<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateStudentDamyData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $male_names = ['حسن', 'محمد', 'حسين', 'حسان', 'حسنين', 'علي', 'مصطفى', 'ياسين', 'عبدالسلام', 'عبدالله', 'اسامة'];
        $female_names = ['نرمين', 'ريم', 'جودي', 'سهى', 'ايمان', 'نجلاء', 'لينه', 'ليندا', 'جمانة', 'حسناء', 'فاطمة'];
        $places = ['حمدانية', 'حلب جديدة', 'اعظمية', 'فرقان', 'اكرمية', 'محافظة', 'موغامبو', 'جميلية', 'سيف الدولة', 'صلاح الدين', 'حي البيل'];

        $is_male = false;
        for ($i = 0; $i < 1000; $i++) {
            $student_name = '';
            $father_index = rand(0, 10);
            $last_name_index = rand(0, 10);
            $mother_index = rand(0, 10);
            $place_index = rand(0, 10);
            $index = rand(0, 10);
            if ($is_male) {
                $student_name = $male_names[$index];
            } else {
                $student_name = $female_names[$index];
            }

            $univ_id = rand(0, 99999);
            $student = DB::table('students')->select('*')->where('univ_id', $univ_id)->first();
            while ($student != NULL) {
                $univ_id = rand(0, 99999);
                $student = DB::table('students')->select('*')->where('univ_id', $univ_id)->first();
            }
            DB::table('students')->insert([
                'univ_id' => $univ_id,
                'name' => $student_name,
                'father_name' => $male_names[$father_index],
                'last_name' => $male_names[$last_name_index],
                'mother_name' => $female_names[$mother_index],
                'birth_place' => "حلب - " . $places[$place_index],
                'address' => "حلب - " . $places[$place_index],
                'gender' => $is_male ? "ذكر" : "انثى",
                'field_number' => 20,
                'recruitment_division' => $is_male ? "حلب" : NULL,
                'city' => "حلب",
                'nationalty' => "عربي-سوري",
            ]);
            $is_male = !$is_male;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_damy_data');
    }
}
