<?php
/********************************
 * Dev and Code by Demort
 * ICQ 642168666 / email : demortx@mail.ru
 *
 *
 *
 * Вы должны сами передавать онлайн, выполняя запросы к серверу L2on не реже, чем раз в 5 минут.
Адрес: http://l2on.net/?c=online&a=update&id={id}&key={key}&current[1]={online}

Параметры:*/
$id = "sdf";
$key = "sdf";
/*{online} - текущий онлайн

В том месте кода вашего сайта, где обновляется онлайн, достаточно добавить следующую строку кода:
file_get_contents('http://l2on.net/?...&current[1]=' . $online);
($online - переменная с текущим онлайном)
 ********************************/
/*
 *Вы должны сами передавать онлайн, выполняя запросы к серверу L2on не реже, чем раз в 5 минут.
Адрес: http://l2on.net/?c=online&a=update&id={id}&key={key}&current[1]={online}

Параметры:
{id} - *****
{key} - *****
{online} - текущий онлайн

В том месте кода вашего сайта, где обновляется онлайн, достаточно добавить следующую строку кода:
file_get_contents('http://l2on.net/?...&current[1]=' . $online);
($online - переменная с текущим онлайном) * */

/* MMOWEB*/

$id_server = 9; /// https://mmoweb.ru/panel/project/game_server/9 Навести на кнопку редактировать вы увидете в конце цифру, это будет ид сервера



if (file_exists('../cache/online_'.$id_server.'.txt')) {

    $str = @file_get_contents('../cache/online_'.$id_server.'.txt');
    $json = unserialize($str);
    if(isset($json["data"]["online_multiple"]))
        file_get_contents('http://l2on.net/?c=online&a=update&id='.$id.'&key='.$key.'&current[1]=' . $json["data"]["online_multiple"]);

}