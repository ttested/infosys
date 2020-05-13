<!-- Карточка с навигацией (в заголовке) -->
<div class="card" id="frm_smeta_obj">
     <!-- Текстовый контент -->
    <div class="card-body tab-content">
	   
        <div class="tab-pane fade show active" id="usrbase">
		<form name="frmsmeta_obj" id="frmsmeta_obj">
			<div class="form-group row">
				<label for="descr" class="col-sm-2 control-label text-left">Название</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="descr" aria-describedby="descrHelp" placeholder="Название"  Value="#descr#">
				</div>
				<small id="descrHelp" class="form-text text-muted">Название объекта сметы.</small>
			</div>
			<div class="form-group row">
				<label for="edizm" class="col-sm-3 control-label text-left">Единица измерения</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="edizm" aria-describedby="edizmHelp">
				  <!--{dict_metric => edizm}-->
				</select>
				</div>
				<small id="edizmHelp" class="form-text text-muted">Единица измерения</small>
			</div>
			<div class="form-group row">
				<label for="objtype" class="col-sm-3 control-label text-left">Тип объекта</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="objtype" aria-describedby="objtypeHelp">
				  <option value="0">Папка</option>
				  <option value="1">Материал</option>
				  <option value="2">Работа</option>
				  <option value="3">Услуга</option>
				  <option value="4">Аренда</option>
				  <option value="5">Оборудование</option>
				</select>
				</div>
				<small id="objtypeHelp" class="form-text text-muted">Типы объектов</small>
			</div>
			<div class="form-group row">
				<label for="pid" class="col-sm-3 control-label text-left">Папка</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="pid" aria-describedby="pidHelp">
				  <!--{v_smetaobj_0 => pid}-->
				</select>
				</div>
				<small id="pidHelp" class="form-text text-muted">Папка для объектов</small>
			</div>
			<div class="form-group row">
				<label for="codtus" class="col-sm-2 control-label text-left">Код в 1С</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="codtus" aria-describedby="codtusHelp" placeholder="Код в товароучетной системе"  Value="#codtus#">
				</div>
				<small id="codtusHelp" class="form-text text-muted">Код объекта в товароучетной систеие.</small>
			</div>
			<div class="form-group row">
				<label for="orderidx" class="col-sm-2 control-label text-left">Порядок</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="orderidx" aria-describedby="orderidxHelp" placeholder="Порядок"  Value="#orderidx#">
				</div>
				<small id="orderidxHelp" class="form-text text-muted">Положение в списке, чем меньше, тем выше</small>
			</div>
			<input type="hidden" class="form-control" id="id" name="id"  value="#id#">
		</form>
        </div>
      </div>
	 
</div><!-- Конец карточки -->