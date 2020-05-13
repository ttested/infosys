<!-- Карточка с навигацией (в заголовке) -->
<div class="card" id="frm_brigada">
     <!-- Текстовый контент -->
    <div class="card-body tab-content">
	   
        <div class="tab-pane fade show active" id="smeta_sostav">
		<form name="frmbrigada" id="frmbrigada">
			<div class="form-group row">
				<label for="descr" class="col-sm-3 control-label text-left">Название</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="descr" aria-describedby="descrHelp" placeholder="Название бригады"  Value="#descr#">
				<small id="descrHelp" class="form-text text-muted">Название бригады для списка. Давайте понятные названия для бригад</small>
				</div>
				
			</div>
			<div class="form-group row">
				<label for="idoffice" class="col-sm-2 control-label text-left">От организации</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="idoffice" aria-describedby="idofficeHelp">
				  <!--{office => idoffice}-->
				</select>
				<small id="idofficeHelp" class="form-text text-muted">Выберите организацию, от которой работает бригада</small>
				</div>
				
			</div>
			<div class="form-group row">
				<label for="idbuilding" class="col-sm-2 control-label text-left">Объект строительства</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="idbuilding" aria-describedby="idbuildingHelp">
				  <!--{building => idbuilding}-->
				</select>
				<small id="idbuildingHelp" class="form-text text-muted">Выберите объект строительства, на котором работает бригада</small>
				</div>
				
			</div>
			<div class="form-group row">
				<label for="paypersent" class="col-sm-3 control-label text-left">% оплаты</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="paypersent" aria-describedby="paypercentHelp" placeholder="%"  Value="#paypersent#">
				<small id="paypercentHelp" class="form-text text-muted">Укажите % бригады. Сумма процентов не должна привышать 100%</small>
				</div>
				
			</div>
			<div class="form-group row">
				<label for="orderidx" class="col-sm-3 control-label text-left">Порядок в списке</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="orderidx" aria-describedby="orderidxHelp" placeholder="Порядок"  Value="#orderidx#">
				<small id="orderidxHelp" class="form-text text-muted">Если важно, то укажите порядок в списке</small>
				</div>
				
			</div>
			<input type="hidden" class="form-control" id="id" name="id"  value="#id#">
		</form>
        </div>
      </div>
	 
</div><!-- Конец карточки -->