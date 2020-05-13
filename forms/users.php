<!-- Карточка с навигацией (в заголовке) -->
<div class="card" id="frm_users">
    <!-- Шапка с навигацией -->
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#usrbase">Авторизация</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#usrperson">Персональные данные</a>
            </li>
			<li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#usrdop">Дополнительные данные</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#finanse">Платежные данные</a>
            </li>
        </ul>
    </div>
    <!-- Текстовый контент -->
    <div class="card-body tab-content">
	   
        <div class="tab-pane fade show active" id="usrbase">
		<form name="frmusrbase" id="frmusrbase">
			<div class="form-group row">
				<label for="login" class="col-sm-2 control-label text-left">Логин</label>
				<div class="col-sm-10">
				<input type="text" class="form-control" id="login" name="login" aria-describedby="loginHelp" placeholder="Логин" validator="login" Value="#login#">
				</div>
				<small id="loginHelp" class="form-text text-muted">Логин - это имя для входа в систему. Он должен быть уникальным, коротким, состоять только из латинских букв и цыфр</small>
			</div>
			<div class="form-group row">
				<label for="password" class="col-sm-2 control-label text-left">Пароль</label>
				<div class="col-sm-10">
				<input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="Пароль" validator="password">
				</div>
				<small id="passwordHelp" class="form-text text-muted">Пароль - это секретное слово для входа в систему. Он должен быть сложным, состоять из больших и маленьких латинских букв, цыфр и символов</small>
			</div>
			<div class="form-group row">
				<label for="rules_names" class="col-sm-3 control-label text-left">Роль в системе</label>
				<div class="col-sm-9">
				<select class="form-control browser-default custom-select" id="rules_names" name="rules_names" aria-describedby="idroleHelp" validator="idrole">
				  <!--{rules_names}-->
				  
				</select>
				</div>
				<small id="idroleHelp" class="form-text text-muted">Роль - это набор функций, которыми будет пользоваться сотрудник</small>
			</div>
			<div class="form-group row">
				<label for="canrun"class="check  text-left">Разрешено работать
					<input type="checkbox" class="form-check-input" id="canrun" name="canrun" aria-describedby="canrunHelp" $canrun$>
					<span class="checkmark"></span>
				
				<small id="canrunHelp" class="form-text text-muted">Установите этот флаг, чтобы разрешить вход в систему</small>
				</label>
			</div>
			</form>
        </div>
        <div class="tab-pane fade" id="usrperson">
		<form name="frmusrbase" id="frmusrperson">
            <div class="form-group row">
				<label for="fio" class="col-sm-3 control-label text-left">Фамилия имя отчество</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="fio" name="fio" aria-describedby="fioHelp" placeholder="Фамилия имя, отчество" validator="fio" value ="#fio#">
				<small id="fioHelp" class="form-text text-muted">Фамилия Имя и Отчество. В именительном падеже (например: Петров Петр Петрович)</small>
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-sm-4">
					<label for="rezident"class="check  text-left">Гражданин РФ
						<input type="checkbox" class="form-check-input" id="rezident" name="rezident" $rezident$>
						<span class="checkmark"></span>
					</label>
				</div>
				<div class="form-group col-sm-4">
					<label for="inn" class="control-label text-left  col-sm-12">ИНН</label>
					<input type="text" class="form-control" id="inn" name="inn" placeholder="ИНН" validator="inn" value="#inn#">
					
				</div>
				<div class="form-group col-sm-4">
					<label for="snils" class="control-label text-left  col-sm-12">Страховой номер</label>
					<input type="text" class="form-control" id="snils" name="snils" placeholder="СНИЛС" validator="snils" value="#snils#">
				</div>
				
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
					<label for="bday" class="control-label text-left  col-sm-12">День рождения</label>
					<input type="date" class="form-control" id="bday" name="bday" placeholder="ИНН" validator="bday" value="#bday#">
				</div>
				<div class="form-group col-sm-4">
					<label for="phone" class="control-label text-left  col-sm-12">Телефон</label>
					<input type="phone" class="form-control" id="phone" name="phone" placeholder="+79999999999" value="#phone#">
				</div>
				<div class="form-group col-sm-4">
					<label for="email" class="control-label text-left  col-sm-12">Электронная почта</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="email" value="#email#">
				</div>
			</div>
			<label for="pasport" class="col-sm-12 control-label text-left">Паспорт</label>
			<div class="row" id="pasport" >
					
					<div class="form-group col-sm-2">
						<input type="text" class="form-control" id="pasports" name="pasports" value="#pasports#" placeholder="Серия" aria-describedby="pasportHelp" validator="seriyz">
					</div>
					
					<div class="form-group col-sm-3">
						<input type="text" class="form-control" id="pasportn" name="pasportn" value="#pasportn#" placeholder="Номер" validator="nomer">
					</div>
					<div class="form-group col-sm-4">
						<input type="text" class="form-control" id="pasportv" name="pasportv" value="#pasportv#" placeholder="Кем выдан" validator="kemvidan">
					</div>
					<div class="form-group col-sm-3">
						<input type="date" class="form-control" id="pasportd" name="pasportd"  value="#pasportd#" placeholder="Когда выдан" validator="datavid">
					</div>
					
			</div>
				
			<div class="form-group row">
				<label for="adres" class="col-sm-3 control-label text-left">Адрес проживания</label>
				<div class="col-sm-9">
				<input type="text" class="form-control" id="adres" name="adres"  value="#adres#" aria-describedby="adresHelp" placeholder="Адрес, по которому проживает сотрудник" validator="adres">
				<small id="adresHelp" class="form-text text-muted text-left">Адрес, по которому проживает сотрудник</small>
				</div>
			</div>
			
			</form>
        </div>
		<div class="tab-pane fade" id="usrdop">
			<div class="row">
			<div class="form-group col-sm-4">
		    <form id="photoform" method="post">
				<div id="photorez" class="imgprev"><img id="photo" class="phpreview" src="#photofile#"/></div>
				<div class="input__wrapper">
				   <input name="file" type="file" name="file" id="imgfile" class="input input__file" multiple>
				   <label for="imgfile" class="input__file-button">
					  <span class="input__file-icon-wrapper ficon"></span>
					  <span class="input__file-button-text">Выберите файл</span>
				   </label>
				</div>
			</form>
			</div>
			<form id="usrdop">
			<div class="form-group col-sm-8">
				<div class="form-group">
					<label for="appointments" class="control-label text-left col-sm-12">Должность</label>
					<select class="form-control browser-default custom-select" id="appointments" name="appointments" aria-describedby="appointmentHelp" validator="appointment">
					  <!--{dict_appointments}-->
					 
					</select>
					<small id="appointmentHelp" class="form-text text-muted">Должность на которую сотрудник принят по штатному расписанию</small>
				</div>
				<div class="form-group">
					<label for="profession" class="control-label text-left col-sm-12">Профессия</label>
					<select class="form-control browser-default custom-select" id="profession" name="profession" aria-describedby="professionHelp" validator="profession">
					  <!--{dict_profession}-->
					  
					</select>
					<small id="professionHelp" class="form-text text-muted text-left">Профессия, которой владеет</small>
				</div>
			  </div>
			  
			 
			</div>
			<div class="row">
				<div class="form-group col-sm-4">
					<label for="avtomobil"class="check  text-left">Есть личный автомобиль
						<input type="checkbox" class="form-check-input" id="avtomobil" name="avtomobil" $avtomobil$>
						<span class="checkmark"></span>
					</label>
				</div>
				<div class="form-group">
					<label for="prava" class="control-label text-left col-sm-12">Категория прав</label>
					<select class="form-control browser-default custom-select" id="prava" name="prava"  aria-describedby="pravaHelp" validator="profession">
					  <!--{dict_prava}-->
					  
					</select>
					<small id="pravaHelp" class="form-text text-muted text-left">Выберите категорию прав, если есть</small>
				</div>
			  </div>
			   </form>
        </div>
        <div class="tab-pane fade" id="finanse">
            <div class="form-group row">
				<label for="paypass" class="col-sm-2 control-label text-left">Платежный пароль</label>
				<div class="col-sm-10">
				<input type="password" class="form-control" id="paypass" name="paypass" aria-describedby="paypassHelp" placeholder="Платежный пароль" validator="paypassword">
				</div>
				<small id="paypassHelp" class="form-text text-muted">Платежный пароль - это секретное слово для подписи финансовых операций. Должен отличаться от пароля для входа в систему</small>
			</div>
			<div class="row">
				<div class="form-group col-sm-5">
					<label for="banc" class="control-label text-left col-sm-12">Банк</label>
					<select class="form-control browser-default custom-select" id="banc" name="banc" validator="bank">
					  <!--{banc}-->
					  
					</select>
					
				</div>
				<div class="form-group  col-sm-3">
					<label for="bic" class="col-sm-3 control-label text-left  col-sm-12">БИК</label>
					<input type="text" class="form-control" id="bic" name="bic"  value="#bic#" placeholder="БИК" validator="adres">
				</div>
				<div class="form-group  col-sm-4">
					<label for="korstcet" class="col-sm-3 control-label text-left  col-sm-12">Кор. счет</label>
					<input type="text" class="form-control" id="korstcet" name="korstcet"  value="#korstcet#" placeholder="Кор.счет" validator="adres">
				</div>
			</div>
			<div class="row">
				<div class="form-group col-sm-3">
					<label for="platsys" class="control-label text-left col-sm-12">Тип карты</label>
					<select class="form-control browser-default custom-select" id="platsys" name="platsys" validator="platsys">
					  <!--{dict_platsys}-->
					</select>
				</div>
				<div class="form-group  col-sm-5">
					<label for="cardid" class="col-sm-3 control-label text-left  col-sm-12">Счет карты</label>
					<input type="text" class="form-control" id="cardid" name="cardid"  value="#cardid#" placeholder="Счет карты" validator="cardid">
				</div>
				<div class="form-group  col-sm-4">
					<label for="cardnumber" class="col-sm-3 control-label text-left  col-sm-12">Номер карты</label>
					<input type="text" class="form-control" id="cardnumber" name="cardnumber"  value="#cardnumber#" placeholder="Номер карты" validator="adres">
				</div>
			</div>
        </div>
	 </div>
	 <input type="hidden" class="form-control" id="id" name="id"  value="#id#">
</div><!-- Конец карточки -->