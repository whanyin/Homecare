<?php

class HomeController extends BaseController
{
    protected function GetCates(){
        //Then, get the public data：
        //Get a list of categories：
        $model = new CateModel();
        return $model->GetAllCate(0,8);
    }
}