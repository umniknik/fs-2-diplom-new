<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //Метод возвращения значения открыта/закрыта продажа билетов
    public function hallsIsActive()
    {
        $setting = Setting::find(1);
        $hallsIsActive = $setting->halls_is_active;
        return $hallsIsActive;
    }

    //Метод изменения значение чтобы открыть или закрыть продажу билетов
    public function changeHallsIsActive()
    {
        //проверяем какой значение halls_is_active сейчас в таблице
        $setting = Setting::find(1);
        $hallsIsActive = $setting->halls_is_active;

        if ($hallsIsActive) {
            $setting->halls_is_active = false;
        } else {
            $setting->halls_is_active = true;
        }

        $setting->save();

        return redirect()->back()->with('success', 'Значение halls_is_active изменено на противоположное');

    }

}
