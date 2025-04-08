<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    //Медо создания/обнолвения цен на места в зале
    public function createPrices(Request $request)
    {//dd($request->input());
        //Берем переданные значения из запроса
        $idHall = $request->input('prices-hall');
        $priceRegular = $request->input('priceForRegularChair');
        $priceVip = $request->input('priceForVipChair');

        //Проверяем есть ли уже запись в этом зале с типом regular
        $checkRegularFromTable = Price::where('hall_id', $idHall)->where('type', 'regular')->first();

        //Проверяем есть ли уже запись в этом зале с типом vip
        $checkVipFromTable = Price::where('hall_id', $idHall)->where('type', 'vip')->first();

        //Если запись с ценой regular места для этого зала есть, то обнолвяем цену, если нет, то создаем новую запись
        if ($checkRegularFromTable) {         
            // $checkRegularFromTable->update(['price' => $priceRegular]);
            $checkRegularFromTable->price = $priceRegular;
            $checkRegularFromTable->save();
        } else {
            $priceRegularNew = new Price();
            $priceRegularNew->hall_id = $idHall;
            $priceRegularNew->type = 'regular';
            $priceRegularNew->price = $priceRegular;
            $priceRegularNew->save();
        }

        //Если запись с ценой vip места для этого зала есть, то обнолвяем цену, если нет, то создаем новую запись
        if ($checkVipFromTable) {
            // $checkVipFromTable->update(['price' => $priceVip]);
           $checkVipFromTable->price = $priceVip;
           $checkVipFromTable->save();
        } else {
            $priceVipNew = new Price();
            $priceVipNew->hall_id = $idHall;
            $priceVipNew->type = 'vip';
            $priceVipNew->price = $priceVip;
            $priceVipNew->save();
        }

        return redirect()->back()->with('success', 'Цены созданы:');
    }

    //Метод получения цен по id зала
    public function getPricesByHallId($idHall)
    {
        //Получаем все цены для указанного зала и типа места
        $prices = Price::where('hall_id', $idHall)->get();

        return response()->json(data: $prices);
    }
}


