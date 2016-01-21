<?php

use Illuminate\Database\Seeder;

class PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persons')->delete();

        DB::table('persons')->insert([
            'id' => 1,
            'first_name' => 'A',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 1,
            'ancestor_id_1' => 1,
            'ancestor_id_2' => 1
        ]);

        DB::table('persons')->insert([
            'id' => 2,
            'first_name' => 'B',
            'gender' => 0
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 2,
            'ancestor_id_1' => 2,
            'ancestor_id_2' => 2
        ]);

        DB::table('persons')->insert([
            'id' => 3,
            'first_name' => 'C',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 3,
            'ancestor_id_1' => 3,
            'ancestor_id_2' => 3
        ]);

        DB::table('persons')->insert([
            'id' => 4,
            'first_name' => 'D',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 4,
            'ancestor_id_1' => 4,
            'ancestor_id_2' => 4
        ]);

        DB::table('persons')->insert([
            'id' => 5,
            'first_name' => 'E',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 5,
            'ancestor_id_1' => 5,
            'ancestor_id_2' => 5
        ]);

        DB::table('persons')->insert([
            'id' => 6,
            'first_name' => 'F',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 6,
            'ancestor_id_1' => 6,
            'ancestor_id_2' => 6
        ]);

        DB::table('persons')->insert([
            'id' => 7,
            'first_name' => 'G',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 7,
            'ancestor_id_1' => 7,
            'ancestor_id_2' => 7
        ]);

        DB::table('persons')->insert([
            'id' => 8,
            'first_name' => 'H',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 8,
            'ancestor_id_1' => 8,
            'ancestor_id_2' => 8
        ]);

        DB::table('persons')->insert([
            'id' => 9,
            'first_name' => 'I',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 9,
            'ancestor_id_1' => 9,
            'ancestor_id_2' => 9
        ]);

        DB::table('persons')->insert([
            'id' => 10,
            'first_name' => 'J',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 10,
            'ancestor_id_1' => 10,
            'ancestor_id_2' => 10
        ]);

        DB::table('persons')->insert([
            'id' => 11,
            'first_name' => 'K',
            'gender' => 1
        ]);
        DB::table('person_closures')->insert([
            'person_id' => 11,
            'ancestor_id_1' => 11,
            'ancestor_id_2' => 11
        ]);

    }
}
