<div ng-controller='myaction' >
	<form class='form-horizontal' name='myform'>
		<div class='control-group'>
			<label class='control-label'>相片目錄</label>
			<div class='controls'>
				<input type=text placeholder='Multimedia' name='pd' required ng-trim="true" disabled ng-init="data.pd='<?php echo $data['pd']; ?>'" ng-model='data.pd'>
				<span class='label label-warning' ng-show='!myform.pd.$valid' ng-cloak>請輸入相片目錄名稱</span>
			</div>
		</div>

		<div class='control-group'>
			<label class='control-label'>Facebook App ID</label>
			<div class='controls'>
				<input type=text placeholder='Facebook App ID' name='fai' required ng-model='data.fai' ng-init="data.fai='<?php echo $data['fai']; ?>'" ng-trim='true'>
				<span class='label label-warning' ng-show='!myform.fai.$valid' ng-cloak>請輸入Facebook App ID</span>
				<button class='btn' ng-click='show_readme()'>如何設定Facebook App ID?</button>
			</div>
		</div>

		<div class='control-group well' ng-show='myform.pd.$valid && myform.fai.$valid'>
			<button class='btn btn-primary' ng-click='save(data)'>儲存</button>
		</div>
	</form>

	<div ng-show='readmed' ng-cloak class='well'>
	<ol>
	<li>請先至 <a href='https://developers.facebook.com/' target=_blank>Facebook developers</a> 申請 App ID
	<li>點選建立新的應用程式。<br>
		<p><img src='images/step1a.png'></p>
	<li>
		<ol type='a'>
		<li>請輸入應用名稱，在Facebook 發表時候所用的程式名稱。
		<li>應用程式名稱空間，在Facebook 唯一性的名稱。
		</ol>
		<p><img src='images/step3.png'></p>
	<li>		
		<ol type='a'>
		<li>請記住 App ID ，將輸入設定畫面中的 Facebook App ID 欄位。
		<li>以Facebook登入網站欄位，請設定<span class='label label-warning'>目前 QNAP NAS 的網址</span>。
		</ol>
		<p><img src='images/step2a.png'></p>
	</ol>

	</div>
</div>

