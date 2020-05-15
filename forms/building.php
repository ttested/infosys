<!-- Карточка с навигацией (в заголовке) -->
<div class="card" id="frm_builder">
    <!-- Шапка с навигацией -->
    <div class="card-header" id="tabnav">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#description" dest="" cod="#id#">Описание</a>
            </li>
            <li class="nav-item fade">
                <a class="nav-link" data-toggle="tab" href="#smeta"  dest="#smeta_obj" cod="#id#">Смета</a>
            </li>
			<li class="nav-item fade">
                <a class="nav-link" data-toggle="tab" href="#executors" dest="#executorlist" cod="#id#">Исполнители</a>
            </li>
            <li class="nav-item fade">
                <a class="nav-link" data-toggle="tab" href="#photos" dest="#photoslist" cod="#id#">Фотографии</a>
            </li>
			<li class="nav-item fade">
                <a class="nav-link" data-toggle="tab" href="#docs" dest="#docslist" cod="#id#">Документация</a>
            </li>
        </ul>
    </div>
    <!-- Текстовый контент -->
    <div class="card-body tab-content">
	    <!-- Основные -->
        <div class="tab-pane fade show active" id="description">
		<form name="frmbuilding" id="frmbuilding">
			<div class="form-group row">
				<label for="descr" class="col-sm-2 control-label text-left">Название</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="descr" aria-describedby="descrHelp" placeholder="Название объекта" Value="#descr#">
				</div>
				<small id="loginHelp" class="form-text text-muted">Постарайтесь давать названия, из которых сразу понятно о чем идет речь</small>
			</div>
			<div class="form-group row">
				<label for="typebuild" class="col-sm-2 control-label text-left">Тип объекта</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="typebuild" aria-describedby="typebuildHelp">
				  <!--{dict_typebuild}-->
				</select>
				</div>
				<small id="typebuildHelp" class="form-text text-muted">Выберите тип объекта строительства</small>
			</div>
			<div class="form-group row">
				<label for="id_office" class="col-sm-2 control-label text-left">От организации</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="id_office" aria-describedby="idofficeHelp">
				  <!--{office => id_office}-->
				</select>
				</div>
				<small id="idofficeHelp" class="form-text text-muted">Выберите организацию, от которой работает бригада</small>
			</div>
			<div class="form-group row">
				<label for="address" class="col-sm-2 control-label text-left">Адрес</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="address"  aria-describedby="addressHelp" placeholder="Адрес объекта" value ="#address#">
				</div>
				<small id="addressHelp" class="form-text text-muted">Если у строения есть адрес, укажите его.</small>
			</div>
			<div class="form-group row">
				<label for="gps" class="col-sm-2 control-label text-left">GPS</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="gps"  aria-describedby="addressHelp" placeholder="Координаты GPS" value ="#gps#">
				</div>
				<small id="addressHelp" class="form-text text-muted">Если у строения есть gps координаты, укажите их.</small>
			</div>
			<input type="hidden" class="form-control" id="id" name="id"  value="#id#">
			</form>
        </div>
		<!-- Смета -->
        <div class="tab-pane fade" id="smeta">
			<form id="frmsmeta">
				<div class="form-group">
					<div id='smeta_obj'><div class='cssload-clock'></div></div>
				</div>
				<div class="form-group">
					<div id='smetasost'><div class='cssload-clock'></div></div>
				</div>
			</form>
        </div>
		<!-- Исполнители -->
		<div class="tab-pane fade" id="executors">
			<form id="frmexecutors" method="post">
				<div class="form-group">
					<div id='executorlist'><div class='cssload-clock'></div></div>
				</div>	
			</form>
        </div>
		<!-- Фотографии -->
        <div class="tab-pane fade" id="photos">
			<div id='photoslist'><div class='cssload-clock'></div></div>
		</div>
		<!-- Документация -->
        <div class="tab-pane fade" id="docs">
			<div id='docslist'><div class='cssload-clock'></div></div>
		</div>
	 </div>
	 
</div><!-- Конец карточки -->