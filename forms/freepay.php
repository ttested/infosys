<!-- Карточка  -->
<div class="card" id="frm_freepay">
     <!-- Текстовый контент -->
    <div class="card-body tab-content">
	   
        <div class="tab-pane fade show active" id="freepay">
		<form name="frmfreepay" id="frmfreepay">
			<div class="form-group row">
				<label for="idbuild" class="col-sm-2 control-label text-left">Объект</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="idbuild" aria-describedby="idbuildingHelp">
				  <!--{building => idbuild}-->
				</select>
				<small id="idbuildingHelp" class="form-text text-muted">Выберите объект строительства, на который относятся деньги</small>
				</div>
				
			</div>
			<div class="form-group row">
				<label for="idfio" class="col-sm-2 control-label text-left">Сотрудник</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="idfio" aria-describedby="idpeopleHelp">
				  <!--{users => idfio}-->
				</select>
				<small id="idpeopleHelp" class="form-text text-muted">Выберите подотчетное лицо</small>
				</div>
				
			</div>
			<div class="form-group row">
				<label for="subj" class="col-sm-3 control-label text-left">Назначение платежа</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="subj" aria-describedby="paypercentHelp" placeholder="Назначение платежа"  Value="#subj#">
				<small id="paypercentHelp" class="form-text text-muted">Укажите на что используется платеж</small>
				</div>
			</div>
			<div class="form-group row">
				<label for="paycost" class="col-sm-3 control-label text-left">Сумма</label>
				<div class="col-sm-9">
				<input type="number" class="form-control" id="paycost" step="0.01" aria-describedby="paycostHelp"  Value="#paycost#">
				<small id="paycostHelp" class="form-text text-muted">Укажите сумму платеж</small>
				</div>
				
			</div>
			<div class="form-group row">
				<label for="daterec" class="col-sm-3 control-label text-left">Дата</label>
				<div class="col-sm-9">
				<input type="date" class="form-control" id="daterec" aria-describedby="daterecHelp"  Value="#daterec#">
				<small id="daterecHelp" class="form-text text-muted">Укажите дату платеж</small>
				</div>
				
			</div>
			<div class="form-group row">
				<label for="validbuch" class="col-sm-3 control-label text-left">Подпись бухгалтера</label>
				<div class="col-sm-9">
				<input type="password" class="form-control" id="validbuch" aria-describedby="paypercentHelp" placeholder="Назначение платежа"  Value="#validbuch#">
				<small id="paypercentHelp" class="form-text text-muted">ВНИМАНИЕ! Это подпись для документов, а не для входа в систему</small>
				</div>
			</div>
			<input type="hidden" class="form-control" id="id" name="id"  value="#id#">
			<input type="hidden" class="form-control" id="iduser" name="iduser"  value="#iduser#">
		</form>
        </div>
      </div>
	 
</div><!-- Конец карточки -->