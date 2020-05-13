<!-- Карточка с навигацией (в заголовке) -->
<div class="card" id="frm_smeta_sostav">
     <!-- Текстовый контент -->
    <div class="card-body tab-content">
	   
        <div class="tab-pane fade show active" id="smeta_sostav">
		<form name="frmsmeta_sostav" id="frmsmeta_sostav">
			<div class="form-group row">
				<label for="idpeople" class="col-sm-2 control-label text-left">Сотрудник</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="idpeople" aria-describedby="idpeopleHelp">
				  <!--{users => idpeople}-->
				</select>
				</div>
				<small id="idpeopleHelp" class="form-text text-muted">Выберите сотрудника для работы в бригаде</small>
			</div>
			<div class="form-group row">
				<label for="paypercent" class="col-sm-3 control-label text-left">% оплаты</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="paypercent" aria-describedby="paypercentHelp" placeholder="%"  Value="#paypercent#">
				</div>
				<small id="paypercentHelp" class="form-text text-muted">Укажите % сотрудника в заработке бригады. Сумма процентов всех работников должна равняться 100%</small>
			</div>
			<input type="hidden" class="form-control" id="id" name="id"  value="#id#">
		</form>
        </div>
      </div>
	 
</div><!-- Конец карточки -->