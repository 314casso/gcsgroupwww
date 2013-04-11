<?php
require_once "_global.php";
_db();

$rows=split(';', 'id;am;zip;hotel_name;categ_type_en;cls;categ_desc_id;categ_desc;rooms;beds;operator;index_name;road;area;nomos;rg_id;isl_id;locationid;tel1;tel2;tel3;tel4;fax;tlx;tel_2;fax_2;email;website;extra_charge;si_no_bath;si_bath;db_no_bath;db_bath;suites;bungalows;breakfast;meal;period_en;dnb;dnp;dnt;dna;dnh;air_condition_full;air_condition_partial;restaurant;bar;pool_bar;roof_garden;night_club;shops;mini_market;cine_theater;internet_corner;hair_dresser;laundry_service;conference_room;conference_center;gym_center;willness_center;thalassotherapy;spa_thermal_bath;swimming_pool_open;swimming_pool_warm;swimming_pool_children;garage;parking;mini_bus_free;spe_need;animal;animation;entertainment_room;games_out;playground;mini_club;water_sports;basket;volley;tennis;mini_golf;haccp;iso_9001;iso_9002;iso_14001;credit_cards;smoke_no_smoke;hair_dryer;kitchen;fridge;mini_bar;room_service;safety_box;tv;interactive_tv;video_pay_tv;fax_room;voice_mail;internet_access;data_port');

$t="insert into `hotels` (";
for ($i=0; $i<sizeof($rows); $i++) {
    $t.="`".$rows[$i]."`";
    if ($i<sizeof($rows)-1) $t.=", ";
    }
$t.=") values (";


$hf=file("hs.csv");
foreach ($hf as $vnf) {
    $hfr=split(';', $vnf);
    $tt=$t;
    for ($i=0;  $i<sizeof($rows);$i++) {
       if (trim($hfr[$i])=="F")  $hfr[$i]=0;
        if (trim($hfr[$i])=="T")  $hfr[$i]=1;
        $tt.="\"".$hfr[$i]."\"";
            if ($i<sizeof($rows)-1) $tt.=", ";
    }
    $tt.=")";
    _db_exe($tt);
}

?>

