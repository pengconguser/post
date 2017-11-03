<?php


//这里是全局视图的辅助函数

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}