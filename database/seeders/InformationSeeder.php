<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InformationSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_information')->insert([
            'info_address' => '123 Đường A, Quận B, Thành phố C',
            'info_phone'   => '0123 456 789',
            'info_email'   => 'contact@abc.com',
            'info_contact' => 'Liên hệ với chúng tôi để biết thêm thông tin.',
            'info_map'     => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7452.243076030728!2d105.72463290000002!3d20.947633800000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1764618351102!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
        ]);
    }
}
