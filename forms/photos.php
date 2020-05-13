<!-- Карточка -->
<div class="card" id="frm_photos">
    <!-- Шапка -->
    <div class="card-header">
        <h3>Добавление фото</h3>
    </div>
    <!-- Контент -->
    <div class="card-body tab-content">
	   
        <div class="tab-pane fade show active" id="photosbase">
            <form id="frmphotos">
                <div class="form-group row">
                    <label for="descr" class="col-sm-2 control-label text-left">Описание</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="descr" aria-describedby="descrHelp" placeholder="Описание фотографии"  Value="#descr#">
                    </div>
                    <small id="descrHelp" class="form-text text-muted">Описание нужно, чтобы быстро найти фотографию. Старайтесь делать его коротким и понятным</small>
                </div>
                <div class="row">
                    
                    <div class="form-group col-sm-4">
                        <form id="photoform" method="post">
                            <div id="photorez" class="imgprev"><img id="photo" class="phpreview" src="#photofile#"/></div>
                            <div class="input__wrapper">
                                <input name="file" type="file"  id="imgfile" class="input input__file" multiple>
                                <label for="imgfile" class="input__file-button">
                                    <span class="input__file-icon-wrapper ficon"></span>
                                    <span class="input__file-button-text">Выберите файл</span>
                                </label>
                            </div>
                        </form>
                    </div>
                    <div>
                        <div class="form-group col-sm-8">
                            <label for="id_smeta" class="control-label text-left">Название объекта</label>
                            <select class="form-control browser-default custom-select" id="id_smeta" aria-describedby="objsmetaHelp">
                            <!--{v_smetaobjnz => id_smeta}-->
                            </select>
                            <small id="objsmetaHelp" class="form-text text-muted">Название пункта сметы.</small>
                        </div>

                        <div class="form-group col-sm-8">
                            <label for="datetm" class="control-label text-left">Дата и время</label>
                            <input type="date" class="form-control" id="datetm"  placeholder="Дата и время, когда была сделана фотография"  value="#datetm#">
                        </div>
                    </div>
                </div>    
                <input type="hidden" class="form-control" id="id" name="id"  value="#id#">
            </form>
        </div>
    </div>


   
</div><!-- Конец карточки -->