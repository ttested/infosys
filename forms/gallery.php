<?php

$rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
require_once ($rootH .'/core/tools.php');

function getThumb($imgfile)
{
    if (file_exists($imgfile))
    {
        $nw=200; $nh=200;
        list($w, $h)  = getimagesize($imgfile);

        $simg = imagecreatefromjpeg($imgfile);

        if ($w < $h)
        {
            //Вертикальная, ограничиваем по высоте
            $d = $h / $w;
            $nw = $nh / $d;
        }
        else {
            //Горизонтальная, ограничиваем по ширине
            $d = $w / $h;
            $nh = $nw / $d;
        }

        $dimg = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($dimg,$simg,0,0,0,0,$nw,$nh,$w,$h);

        ob_start();
        imagejpeg($dimg);
        $return = base64_encode(ob_get_contents());
        ob_end_clean();

    }
    else {
        $return=0;
    }
    return $return;
}

function F($o)
{
    if(isset($o))
    {
        return $o;
    }
    else {
        return '';
    }
}

function ShowGalery($photoarray)
{
    if (isset($photoarray))
    {
        $rootH = $_SERVER['DOCUMENT_ROOT'].'/test';
        $tmpl = $rootH .'/templates/gallery.php';
        $rezult = file_get_contents( $tmpl );
        if(!isset($photoarray[0]['fake']))
        {
            $html='<div class="lineset"><ul id="thumbs">';
            $i=0;
            foreach($photoarray as $data)
            {
                if (isset($data['datetm']))
                {
                    $datfmtd = date('d.m.Y',strtotime ($data['datetm']));
                    $dttmfmd = date('d.m.Y H:i:s',strtotime ($data['datetm'])); 
                }
                else {
                    $datfmtd ='';
                    $dttmfmd =''; 
                }
                
                $url = '/img/obj/'. $data['id_buildin'].'/'.$data['photofile'];
                $info = '<div class="item"><div class="wrap-text"><div><strong>'.$data['descr'].'</strong><br>';
                $info .= '<span class="info"><strong>'. $datfmtd.'</strong><br>';
                //$info .= $data['etap'].'</span></div></div>';
                $info .= '</span></div></div>';
                $fullinfo = $data['descr'].'|'. $dttmfmd.'|'.$data['etap'];
                if ($i==0)
                {
                    $html .="<li imgurl='/test".$url."' info='$fullinfo' class='linebox' selected>$info";
                    $actimg= '/test'.$url;
                    $bignam =  $data['descr'];
                    $bigdat =  $dttmfmd;
                    $bigtyp = $data['etap'];
                    $idbuilding =  $data['id_buildin'];
                }
                else 
                {
                    $html .="<li imgurl='/test".$url."' info='$fullinfo'  class='linebox'>$info";
                }
                $f = getThumb($rootH . $url);
                $html .="<img src='data:image/jpg;base64,$f'/></div></li>";
                $i++;
            }
            $html .="</ul></div>";
        }
        else {
            $idbuilding=0;
            $actimg='';
            $bignam='';
            $bigdat='';
            $bigtyp='';
            $html='';
            $newpicture='';
        }
        //новая картинка
        $newpicture = '<form id="frmphotos" action="#" onsubmit="return false;">
        <div class="form-group row">
            <label for="imgdescr" class="col-sm-2 control-label text-left">Описание</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="imgdescr" aria-describedby="imgdescrHelp" placeholder="Описание фотографии">
            </div>
            <small id="imgdescrHelp" class="form-text text-muted">Описание нужно, чтобы быстро найти фотографию. Старайтесь делать его коротким и понятным</small>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="id_smeta" class="control-label text-left">Название объекта сметы</label>
                    <select class="form-control browser-default custom-select" id="id_smeta" aria-describedby="objsmetaHelp">
                '.fillData().'
                    </select>
                    <small id="objsmetaHelp" class="form-text text-muted">Название глобального объекта сметы.</small>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <input type="file" id="imgfile" multiple>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" onclick="AddPhotos('. $idbuilding.'); result=false;">Добавить фотографии</button>
                </div>
            </div>
        </div>    
        <input type="hidden" class="form-control" id="id" name="id"  value="#id#">
    </form>';
        //-------------------------------------------------

        $rezult = str_replace('#bigimg#',$actimg,$rezult);
        $rezult = str_replace('#bignam#',$bignam,$rezult);
        $rezult = str_replace('#bigdat#',$bigdat,$rezult);
        $rezult = str_replace('#bigtyp#',$bigtyp,$rezult);
        $rezult = str_replace('#idbuilding#',$idbuilding,$rezult);
        
        $rezult = str_replace('<!--{thumbs}-->',$html,$rezult);
        $rezult = str_replace('<!--{new picture}-->',$newpicture,$rezult);
        return $rezult;
    }
    else {
        return '<pre>Error</pre>';
    }
}