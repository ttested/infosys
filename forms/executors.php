<?php

$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
require_once ($rootH .'/core/tools.php');


function ShowExecutors($docsarr)
{
    if (isset($docsarr))
    {
        $idbuilding = $docsarr['idbuilding'];
    //print_r($docsarr);
    //exit;
        if (isset($docsarr['brigads']) && isset($docsarr['brigadsspis']))
        {
            $brigada='';
            $brigadalist='';
            $hdr = '';
            foreach (['№ п.п.','Сотрудник','На должность'] as $theader)
            {
                $hdr .= '<th scope="col" >'.$theader.'</th>';
            }
            foreach($docsarr['brigads'] as $brigad)
            {
                $tab = '<div class="table-responsive"><table id="table'.$brigad['id'].'" class="table table-hover table-striped table-bordered table-condensed table-sm">';
                $tab .='<thead><tr class="table-primary">'.$hdr.'</tr></thead><tbody>';
                $i=1;
                foreach($docsarr['brigadsspis'] as $brigadspis)
                {
                    if ($brigad['id']===$brigadspis['idbrigada'])
                    {
                        $fio = $brigadspis['fio'];
                        $appointment = $brigadspis['profes']; 
                        $tab .='<tr><td>'.$i++.'</td><td>'.$fio.'</td><td>'.$appointment.'</td></tr>';
                    }
                }
                $tab .="</tbody></table></div>";
                
                $brigada .='<span class="brigada">`'.$brigad['descr'].'`</span>&nbsp;';
                $brigadalist .='<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseBrigada'.$brigad['id'].'" aria-expanded="false" aria-controls="collapseBrigada'.$brigad['id'].'">
                '.$brigad['descr'].'
                </button>
                <div class="collapse" id="collapseBrigada'.$brigad['id'].'">
                    <div class="card card-block">
                    '.$tab.'
                    </div>
                </div>
                ';
            }
            
            $html ='<div class="form-group">
                    <button class="btn btn-outline-primary btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseBrigada" aria-expanded="false" aria-controls="collapseBrigada">
                    '.$brigada.'
                    </button>
                    <div class="collapse" id="collapseBrigada">
                        <div class="card card-block">
                            '.$brigadalist.'
                        </div>
                    </div>
                </div>
        ';
        }
        else {
            $html='<div class="alert alert-warning" role="alert">
                На объект не назначена ни одна бригада.<br>
                Назначить бригаду можно <a href ="/test/index.php?route=brigada" target = "_blanc">здесь</a>
                    </div>';
        }
        if (isset($docsarr['executors']))
        {    $html .='<div class="table-responsive"><table id="executtable" class="table table-hover table-striped table-bordered table-condensed table-sm">';
            $html .='<thead><tr class="table-primary">';
            foreach (['№ п.п.','Сотрудник','На должность','% на зарплату'] as $theader)
            {
                $html .= '<th scope="col" >'.$theader.'</th>';
            }
            $html .='</tr></thead><tbody>';
            
            $i=1;
            foreach($docsarr['executors'] as $data)
            {
                $fio         = $data['fio'];
                $id          = $data['id'];
                $appointment = $data['appointment'];
                $persentpay  = $data['persentpay'];
                if ($fio)
                {$html .= "<tr rowcod='$id' ><td>$i</td><td>$fio</td><td>$appointment</td><td>$persentpay</td></tr>";}
                $i++;
            }
            $html .="</tbody></table></div>";}

        //новый документ
        $newpicture = '<form id="frmexecut" action="#" onsubmit="return false;">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="id_user" class="control-label text-left">Сотрудник</label>
                    <select class="form-control browser-default custom-select" id="id_user" aria-describedby="idpeopleHelp">
                    '.fillData('nr32_users').'
                    </select>
                    <small id="idpeopleHelp" class="form-text text-muted">Выберите сотрудника для работы на объекте</small>
                </div>
                <div class="form-group col-sm-3">
                    <label for="appointments" class="control-label text-left col-sm-12">Должность</label>
                    <select class="form-control browser-default custom-select" id="appointments"  aria-describedby="appointmentHelp">
                    '.fillData('nr32_dict_appointments').'
                    </select>
                    <small id="appointmentHelp" class="form-text text-muted">Должность на которую сотрудник принят на объекте</small>
                </div>
                <div class="form-group col-sm-2">
                    <label for="paypercent" class="control-label text-left">% оплаты</label>
                    <input type="text" class="form-control" id="paypercent" aria-describedby="paypercentHelp" placeholder="%">
                    <small id="paypercentHelp" class="form-text text-muted">Укажите % сотрудника в заработке.</small>
                </div>
                <div class="form-group col-sm-2">
                <input type="hidden" class="form-control" id="id_buildin"   value="'. $idbuilding.'">
                    <button type="button" class="btn btn-success" onclick="AddExecutor('. $idbuilding.'); result=false;">Добавить исполнителя</button>
                    <!--button type="button" class="btn btn-info" onclick="ShowExecuters('. $idbuilding.'); result=false;">Обновить</button-->
                </div>
            </div>
        </form>';
        //-------------------------------------------------
        $rezult = $html.'<br/>'.$newpicture;
       
        return $rezult;
    }
    else {
        return '<pre>Error</pre>';
    }
}