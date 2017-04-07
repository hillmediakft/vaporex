<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">Részletek</h4>
</div>
<div class="modal-body">		
	<dl class="dl-horizontal">
		<dt style="font-size:100%; color:grey;">Azonosító szám:</dt>
		<dd>#<?php echo $content['job_id'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Megnevezés:</dt>
		<dd><?php echo $content['job_title'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Munkaadó:</dt>
		<dd><?php echo $content['employer_name'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Típus:</dt>
		<dd><?php echo $content['job_list_name'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Leírás:</dt>
		<dd><?php echo $content['job_description'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Feltételek:</dt>
		<dd><?php echo $content['job_conditions'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Munkavégzés helye:</dt>
		<dd><?php echo $location;?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Munkaidő:</dt>
		<dd><?php echo $content['job_working_hours'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Fizetés:</dt>
		<dd><?php echo $content['job_pay'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Lejárati idő:</dt>
		<dd><?php echo $content['job_expiry_timestamp'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Létrehozás dátuma:</dt>
		<dd><?php echo $content['job_create_timestamp'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Referens:</dt>
		<dd><?php echo $content['user_first_name'] . ' ' . $content['user_last_name'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Státusz:</dt>
		<dd><?php echo ($content['job_status'] == 0) ? 'Inaktív' : 'Aktív';?></dd>
	</dl>	
</div>	 
<div class="modal-footer">
	<button onclick="window.location.href = 'admin/jobs/update_job/<?php echo $content['job_id'];?>';" type="button" class="btn blue">Adatok módosítása</button>
	<button type="button" class="btn default" data-dismiss="modal">Bezár</button>
</div>