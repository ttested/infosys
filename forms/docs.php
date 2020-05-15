<?php

$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
require_once ($rootH .'/core/tools.php');

function ShowDocs($docsarr)
{
    if (isset($docsarr))
    {
        $html='<div class="table-responsive"><table id="docstable" class="table table-hover table-striped table-bordered table-condensed table-sm">';
        $html .='<thead><tr class="table-primary">';
        foreach (['№ п.п.','Наименование','Файл'] as $theader)
        {
            $html .= '<th scope="col" >'.$theader.'</th>';
        }
        $html .='</tr></thead><tbody>';
        
        $i=1;
        $idbuilding =0;
        foreach($docsarr as $data)
        {
           // $govw ='http://docs.google.com/viewer?url=';
            $url = '/test/docs/obj/'. $data['idbuilding'].'/'.$data['filedoc'];
            $idbuilding =  $data['idbuilding'];
            list($filedoc,$filetype)=explode('.',$data['filedoc']);
            $filelbl = $data['filelbl'];
            // добавляем соответствующую картинку
            $filelbl = "<img src='/test/img/$filetype.png' height='24px' width='24px'></img> &nbsp;".$filelbl;
            $descr = $data['descr'];
            if ($descr)
            {$html .= "<tr><td>$i</td><td>$descr</td><td><a href='$url' class='$filetype' target='_blank'>$filelbl</a></td></tr>";}
            $i++;
        }
        $html .="</tbody></table></div>";

        //новый документ
        $newpicture = '<form id="frmdocs" action="#" onsubmit="return false;">
        <div class="form-group row">
            <label for="docdescr" class="col-sm-2 control-label text-left">Документ</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="docdescr" aria-describedby="docdescrHelp" placeholder="Описание документа">
            </div>
            <small id="docdescrHelp" class="form-text text-muted">Описание документа нужно, чтобы быстро его найти. Старайтесь делать его коротким и понятным</small>
        </div>
        <div class="row">
            <div class="form-group">
                <input type="file" id="docfile" multiple>
            </div>
            <div class="form-group">
                <button class="btn btn-success" onclick="AddDocs('. $idbuilding.'); result=false;">Добавить документ</button>
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