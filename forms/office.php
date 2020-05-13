<!-- Карточка с навигацией (в заголовке) -->
<div class="card" id="frm_office">
     <!-- Текстовый контент -->
    <div class="card-body tab-content">
	   
        <div class="tab-pane fade show active" id="usrbase">
		<form id="office">
			<div class="form-group row">
				<label for="descr" class="col-sm-2 control-label text-left">Название организации</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="descr" aria-describedby="descrHelp" placeholder="Название организации"  Value="#descr#">
				</div>
				<small id="descrHelp" class="form-text text-muted">Название организации будет использовано в объекте строительства и рассылке</small>
			</div>
			<div class="form-group row">
				<label for="inn" class="col-sm-2 control-label text-left">ИНН организации</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="inn" aria-describedby="innHelp" placeholder="Название организации"  Value="#inn#">
				</div>
				<small id="innHelp" class="form-text text-muted">ИНН организации будет использовано в объекте строительства и рассылке</small>
			</div>
			<div class="form-group row">
				<label for="director" class="col-sm-3 control-label text-left">Руководитель</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="director" aria-describedby="directorHelp" validator="idrole">
				 <!--{users => director}-->
				  
				</select>
				</div>
				<small id="directorHelp" class="form-text text-muted">Директор, генеральный директор, и т.д.</small>
			</div>
			<div class="form-group row">
				<label for="buhgalter" class="col-sm-3 control-label text-left">Бухгалтер</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="buhgalter" aria-describedby="directorHelp" validator="idrole">
				 <!--{users => buhgalter}-->
				  
				</select>
				</div>
				<small id="directorHelp" class="form-text text-muted">Бухгалтер, главный бухгалтер, и т.д.</small>
			</div>
			<div class="form-group row">
				<label for="orderidx" class="col-sm-2 control-label text-left">Порядок</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="orderidx" aria-describedby="orderidxHelp" placeholder="Название организации"  Value="#orderidx#">
				</div>
				<small id="orderidxHelp" class="form-text text-muted">Положение организации в списке, чем меньше, тем выше</small>
			</div>
		</form>
        </div>
      </div>
	 <input type="hidden" class="form-control" id="id" name="id"  value="#id#">
</div><!-- Конец карточки -->