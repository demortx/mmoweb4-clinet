<?php
/**
 * Created by PhpStorm.
 * User: Demort
 * Date: 28.02.2020
 * Time: 21:21
 */
if (!function_exists('exp_level')) {
    function exp_level($exp)
    {
        if ($exp <= '400') return '0';
        elseif ($exp <= '1433') return '1';
        elseif ($exp <= '3820') return '2';
        elseif ($exp <= '9054') return '3';
        elseif ($exp <= '17655') return '4';
        elseif ($exp <= '30978') return '5';
        elseif ($exp <= '52010') return '6';
        elseif ($exp <= '82982') return '7';
        elseif ($exp <= '126069') return '8';
        elseif ($exp <= '182252') return '9';
        elseif ($exp <= '260622') return '10';
        elseif ($exp <= '360825') return '11';
        elseif ($exp <= '490331') return '12';
        elseif ($exp <= '649169') return '13';
        elseif ($exp <= '844378') return '14';
        elseif ($exp <= '1080479') return '15';
        elseif ($exp <= '1393133') return '16';
        elseif ($exp <= '1793977') return '17';
        elseif ($exp <= '2282186') return '18';
        elseif ($exp <= '2881347') return '19';
        elseif ($exp <= '3659516') return '20';
        elseif ($exp <= '4622407') return '21';
        elseif ($exp <= '5821524') return '22';
        elseif ($exp <= '7227983') return '23';
        elseif ($exp <= '8835056') return '24';
        elseif ($exp <= '10699436') return '25';
        elseif ($exp <= '12853998') return '26';
        elseif ($exp <= '15255815') return '27';
        elseif ($exp <= '18061172') return '28';
        elseif ($exp <= '21551945') return '29';
        elseif ($exp <= '25635643') return '30';
        elseif ($exp <= '30490364') return '31';
        elseif ($exp <= '36299780') return '32';
        elseif ($exp <= '43890745') return '33';
        elseif ($exp <= '53559061') return '34';
        elseif ($exp <= '65392986') return '35';
        elseif ($exp <= '81005799') return '36';
        elseif ($exp <= '98965887') return '37';
        elseif ($exp <= '120006279') return '38';
        elseif ($exp <= '145305546') return '39';
        elseif ($exp <= '174901906') return '40';
        elseif ($exp <= '209678951') return '41';
        elseif ($exp <= '246923912') return '42';
        elseif ($exp <= '286491872') return '43';
        elseif ($exp <= '328812035') return '44';
        elseif ($exp <= '374157438') return '45';
        elseif ($exp <= '422165990') return '46';
        elseif ($exp <= '473102570') return '47';
        elseif ($exp <= '527287631') return '48';
        elseif ($exp <= '584861315') return '49';
        elseif ($exp <= '649149135') return '50';
        elseif ($exp <= '718967268') return '51';
        elseif ($exp <= '793470302') return '52';
        elseif ($exp <= '871508583') return '53';
        elseif ($exp <= '953180528') return '54';
        elseif ($exp <= '1039463797') return '55';
        elseif ($exp <= '1130615342') return '56';
        elseif ($exp <= '1226906283') return '57';
        elseif ($exp <= '1328622680') return '58';
        elseif ($exp <= '1434562107') return '59';
        elseif ($exp <= '1548141590') return '60';
        elseif ($exp <= '1667422949') return '61';
        elseif ($exp <= '1793319043') return '62';
        elseif ($exp <= '1926765410') return '63';
        elseif ($exp <= '2066885620') return '64';
        elseif ($exp <= '2631427378') return '65';
        elseif ($exp <= '4271005600') return '66';
        elseif ($exp <= '8023982311') return '67';
        elseif ($exp <= '15826312699') return '68';
        elseif ($exp <= '31430688278') return '69';
        elseif ($exp <= '62660507393') return '70';
        elseif ($exp <= '117158523579') return '71';
        elseif ($exp <= '212151338979') return '72';
        elseif ($exp <= '374747480973') return '73';
        elseif ($exp <= '608905517112') return '74';
        elseif ($exp <= '933228334012') return '75';
        else return '75';
    }
}
//template
if (!function_exists('get_race_img')) {
    function get_race_img($race)
    {
        if ($race == 'ELYOS')
            return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/elyos-ico.png" data-toggle="tooltip" data-placement="top" title="Elyos" alt="Elyos"/>';

        return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/asmodian-ico.png" data-toggle="tooltip" data-placement="top" title="Asmodian" alt="Asmodian"/>';
    }
}

if (!function_exists('get_class_img')) {
    function get_class_img($class)
    {
        switch ($class) {
            case 'SCOUT':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/scout.png"  width="14px" data-toggle="tooltip" data-placement="top" title="Scout" alt="Scout"/>';
                break;
            case 'CLERIC':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/cleric.png"  width="14px" data-toggle="tooltip" data-placement="top" title="Cleric" alt="Cleric"/>';
                break;
            case 'ENGINEER':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/cleric.png" width="14px" data-toggle="tooltip" data-placement="top" title="Cleric" alt="Cleric"/>';
                break;
            case 'PRIEST':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/priest.png" width="14px" data-toggle="tooltip" data-placement="top" title="Priest" alt="Priest"/>';
                break;
            case 'WARRIOR':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/warrior.png" width="14px" data-toggle="tooltip" data-placement="top" title="Warrior" alt="Warrior"/>';
                break;
            case 'RANGER':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/ranger.png" width="14px" data-toggle="tooltip" data-placement="top" title="Ranger" alt="Ranger"/>';
                break;
            case 'MAGE':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/mage.png" width="14px" data-toggle="tooltip" data-placement="top" title="Mage" alt="Mage"/>';
                break;
            case 'TEMPLAR':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/templar.png" width="14px" data-toggle="tooltip" data-placement="top" title="Templar" alt="Templar"/>';
                break;
            case 'GLADIATOR':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/gladiator.png" width="14px" data-toggle="tooltip" data-placement="top" title="Gladiator" alt="Gladiator"/>';
                break;
            case 'CHANTER':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/chanter.png" width="14px" data-toggle="tooltip" data-placement="top" title="Chanter" alt="Chanter"/>';
                break;
            case 'SPIRIT_MASTER':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/spiritmaster.png" width="14px" data-toggle="tooltip" data-placement="top" title="Spirit Master" alt="Spirit Master"/>';
                break;
            case 'SORCERER':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/sorcerer.png" width="14px" data-toggle="tooltip" data-placement="top" title="Sorcerer" alt="Sorcerer"/>';
                break;
            case 'ASSASSIN':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/assassin.png" width="14px" data-toggle="tooltip" data-placement="top" title="Assassin" alt="Assassin"/>';
                break;
            case 'BARD':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/bard.png" width="14px" data-toggle="tooltip" data-placement="top" title="Bard" alt="Bard"/>';
                break;
            case 'GUNNER':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/gunner.png" width="14px" data-toggle="tooltip" data-placement="top" title="Gunner" alt="Gunner"/>';
                break;
            case 'RIDER':
                return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/rider.png" width="14px" data-toggle="tooltip" data-placement="top" title="Rider" alt="Rider"/>';
                break;
            default:
                return '<span class="badge badge-pill badge-secondary" >'.$class.'</span>';
        }
    }
}

if (!function_exists('get_gender_img')) {
    function get_gender_img($gender)
    {
        if ($gender == 'MALE') return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/male.png" data-toggle="tooltip" data-placement="top" title="Male" alt="Male"/>';
        return '<img src="' . VIEWPATH . '/panel/assets/game/images/aion_icons/female.png" data-toggle="tooltip" data-placement="top" title="Female" alt="Female"/>';
    }
}

if (!function_exists('get_online_img')) {
    function get_online_img($status)
    {
        if ($status == 1) {//<i class="si si-globe  text-gray"></i>
            return '<i class="si si-globe text-success float-right text-right mr-15" data-toggle="tooltip" data-placement="top" title="Online"/></i>';
        }
        return '<i class="si si-globe  text-gray float-right text-right mr-15" data-toggle="tooltip" data-placement="top" title="Offline"/></i>';
    }
}
return array(



);