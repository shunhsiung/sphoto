<div ng-controller='myalbum' ng-init="<?php echo $ng_init_data; ?>">

<div class='row'>
<div class='alert alert-success'>
	{{image_base_dir}}
</div>

<div class='well' ng-init="fai='<?php echo $fai; ?>';up_dir='<?php echo $pd; ?>';ng_dir_list=<?php echo $ng_dir_list; ?>" >
	<button class='btn btn-primary' ng-cloak ng-click='change(up_dir,"..")' ng-show='up_show'>..</button>
	<button class='btn btn-link' ng-cloak ng-click='change(up_dir,dir)' ng-bind='dir' ng-repeat="dir in ng_dir_list">{{ dir }}</button>
</div>

</div>

<div class='row'>
	<ul class='thumbnails' ng-init="ng_file_list=<?php echo $ng_file_list; ?>">
		<li class='span2' ng-repeat="image in ng_file_list">
			<div class='thumbnail'>
			<img ng-class='{selected:image_list[image_base_dir+"/"+image]}' ng-show='image.length' ng-src="{{image_base_dir}}/{{image}}" alt="{{image}}" ng-click='info(image)'>
			</div>
		</li>	
		<li class='span2 label label-warning' style='height:50px;' ng-cloak ng-show='!ng_file_list.length'>無圖片</li>
	</ul>
</div>

<div class='row row-fluid' ng-show='show_image_file.length'>
	<div class='span9'>
	<img ng-src='{{show_image_file}}' >
	</div>

	<div class='span3'>
		<div ng-show='info_list.length'>
		<ul >
			<li ng-repeat='info in info_list'>{{info}}</li>
		</ul>
		</div>

		<div class='well'>
			敘述：<br>
			<textarea ng-model='message' ng-disabled='progressed' ></textarea>
			<button class='btn btn-primary' ng-cloak ng-click='fblogin()' ng-show='!fblogined'>登入Facebook</button>
			<button class='btn btn-primary' ng-show='fblogined' ng-disabled='progressed' ng-click='upload(show_image_file)'>上傳相簿至Facebook</button>
		</div>

		<div class='progress progress-striped active' ng-show='progressed' ng-hide='!progressed'>
			<div class='bar' style='width:40%;'></div>		
		</div>

	</div>
</div>
</div>

