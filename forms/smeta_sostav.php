<!-- Карточка с навигацией (в заголовке) -->
<div class="card" id="frm_smeta_sostav">
     <!-- Текстовый контент -->
    <div class="card-body tab-content">
	   
        <div class="tab-pane fade show active" id="smeta_sostav">
		<form name="frmsmeta_sostav" id="frmsmeta_sostav">
			<div class="form-group row">
				<label for="idobj" class="col-sm-2 control-label text-left">Название объекта</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="idobj" aria-describedby="objsmetaHelp">
				  <!--{v_smetaobjnz => idobj}-->
				</select>
				</div>
				<small id="objsmetaHelp" class="form-text text-muted">Название основного объекта сметы.</small>
			</div>
			<div class="form-group row">
				<label for="sostsmeta" class="col-sm-2 control-label text-left">Название</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="idsost" aria-describedby="sostsmetaHelp">
				  <!--{v_smetaobjnz => idsost}-->
				</select>
				</div>
				<small id="sostsmetaHelp" class="form-text text-muted">Название связываемого объекта сметы.</small>
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
				<label for="kolvo" class="col-sm-3 control-label text-left">Количество</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="kolvo" aria-describedby="kolvoHelp" placeholder="Количество"  Value="#kolvo#">
				</div>
				<small id="pidHelp" class="form-text text-muted">Количество на единицу! Мы будем вычислять его исходя из заданного количества</small>
			</div>
			<div class="form-group row">
				<label for="orderidx" class="col-sm-2 control-label text-left">Порядок</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="orderidx" aria-describedby="orderidxHelp" placeholder="Порядок"  Value="#orderidx#">
				</div>
				<small id="orderidxHelp" class="form-text text-muted">Положение в списке, чем меньше, тем выше. Оставьте пустым, если не важно</small>
			</div>
		</form>
        </div>
      </div>
	 <input type="hidden" class="form-control" id="id" name="id"  value="#id#">
</div><!-- Конец карточки -->