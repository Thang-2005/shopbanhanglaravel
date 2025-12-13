<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tinh;
use App\Models\huyen;
use App\Models\xa;
use App\Models\Feeship;


class Deliverycontroller extends Controller
{
    public function delivery(Request $request){
        $tinh= tinh::orderby('matp','ASC')->get();
        $huyen= huyen::orderby('maqh','ASC')->get();
        $xa= xa::orderby('maxa','ASC')->get();
        return view('admin.delivery.add_delivery')->with(compact('tinh','huyen','xa'));
}
    
    // public function select_delivery(Request $request){
    // $data = $request->all();
    
    // if(isset($data['action'])) {
    //     $output = '';

    //     if($data['action'] == "tinh") {
    //         // Lấy huyện theo tỉnh
    //         $select_huyen = huyen::where('matp', $data['matp'])->orderby('maqh','ASC')->get();
    //         $output .= '<option value="">--Chọn huyện--</option>';
    //         foreach($select_huyen as $key => $huyen){
    //             $output .= '<option value="'.$huyen->maqh.'">'.$huyen->name_huyen.'</option>';
    //         }

    //     } elseif($data['action'] == "huyen") {
    //         // Lấy xã theo huyện
    //         $select_xa = xa::where('maqh', $data['maqh'])->orderby('maxa','ASC')->get(); 
    //         // Lưu ý: gửi data['matp'] từ select huyện
    //         $output .= '<option value="">--Chọn xã--</option>';
    //         foreach($select_xa as $key => $xa){
    //             $output .= '<option value="'.$xa->maxa.'">'.$xa->name_xa.'</option>';
    //         }
    //     }

    //     return $output;
    // }

    // }

    public function select_delivery(Request $request){
    $data = $request->all();
    $output = '';

    if(isset($data['action'])) {

        if($data['action'] == "Tinh") {
            // Lấy huyện theo tỉnh
            $select_huyen = Huyen::where('matp', $data['matp'])->orderby('maqh','ASC')->get();
            $output .= '<option value="">--Chọn huyện--</option>';
            foreach($select_huyen as $huyen){
                $output .= '<option value="'.$huyen->maqh.'">'.$huyen->name_huyen.'</option>';
            }

        } elseif($data['action'] == "Huyen") {
            // Lấy xã theo huyện
            // SỬA: kiểm tra tồn tại key 'maqh'
            $maqh = $data['maqh'] ?? null; 
            if($maqh){
                $select_xa = Xa::where('maqh', $maqh)->orderby('maxa','ASC')->get(); 
                $output .= '<option value="">--Chọn xã--</option>';
                foreach($select_xa as $xa){
                    $output .= '<option value="'.$xa->maxa.'">'.$xa->name_xa.'</option>';
                }
            }
        }

    }

    return $output;
}

    public function save_delivery(Request $request){
        $data = $request->all();
        $fee_ship = new Feeship();
        $fee_ship->fee_maqh = $data['Huyen'];
        $fee_ship->fee_maxa = $data['Xa'];
        $fee_ship->fee_matp = $data['Tinh'];
        $fee_ship->fee_ship = $data['fee_ship'];
        $fee_ship->save();
    }
    


    public function select_feeship(){
        $feeship = feeship::orderby('fee_id','DESC')->get();
        $output = '';
        $output .= '<table class="table table-striped b-t b-light">
                    <thead>
                      <tr>
                        <th>Tên tỉnh/thành phố</th>
                        <th>Tên quận/huyện</th>
                        <th>Tên xã/phường</th>
                        <th>Phí vận chuyển</th>
                      </tr>
                    </thead>
                    <tbody>';
        foreach($feeship as $key => $fee){
            $output .= '<tr>
                        <td>'.$fee->Tinh->name_tinh.'</td>
                        <td>'.$fee->Huyen->name_huyen.'</td>
                        <td>'.$fee->Xa->name_xa.'</td>
                        <td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_ship,0,','.', ').'</td>
                      </tr>';
        }
        $output .= '</tbody>
                  </table>';
        echo $output;
    }
    public function update_feeship(Request $request){
        $data = $request->all();
        $feeship = Feeship::find($data['feeship_id']);
        $feeship->fee_ship = $data['fee_value'];
        $feeship->save();
    }

    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.'); // xóa khoảng trắng ở cuối
    

         $fee_ship ->fee_ship = $data['fee_value'];
         $fee_ship ->save();
    }

}
