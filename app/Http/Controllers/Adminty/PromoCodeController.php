<?php

namespace App\Http\Controllers\Adminty;

use App\Http\Controllers\Controller;
use App\Models\PromoCodeModel;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function __construct()
    {
        // $this->set_column_names([
        //     'Регион', 'Создатель', 'Размер скидки'
        // ]);

        $this->model = new PromoCodeModel();
    }


    public function index(Request $request)
    {
        return $this->get_table_update_response('table', $request, $this->model);
    }



    public function update_table(Request $request)
    {
        return $this->get_table_update_response('tablePaginationRender',$request, $this->model);
    }
}
