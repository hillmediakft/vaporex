<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">Részletek</h4>
</div>
<div class="modal-body">		
	<dl class="dl-horizontal">
		<dt style="font-size:100%; color:grey;">Azonosító szám:</dt>
		<dd>#<?php echo $content['user_id'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Név:</dt>
		<dd><?php echo $content['name'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Anyja neve:</dt>
		<dd><?php echo $content['mother_name'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Születési hely:</dt>
		<dd><?php echo $content['birth_place'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Születési idő:</dt>
		<dd><?php echo $content['birth_time'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Nemzetiség:</dt>
		<dd><?php echo $content['nationality'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Diákigazolvány száma:</dt>
		<dd><?php echo $content['student_card_number'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">TAJ kártya száma:</dt>
		<dd><?php echo $content['taj_number'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Adóazonosító jele:</dt>
		<dd><?php echo $content['tax_id'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Bankszámla száma:</dt>
		<dd><?php echo $content['bank_account_number'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Számlavezető bank neve:</dt>
		<dd><?php echo $content['bank_name'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Állandó lakcím:</dt>
		<dd><?php echo $content['permanent_address'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Elérhetőségi cím:</dt>
		<dd><?php echo $content['contact_address'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">E-mail cím:</dt>
		<dd><?php echo $content['email_address'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Mobiltelefon:</dt>
		<dd><?php echo $content['telefon_number'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Iskola végzettség:</dt>
		<dd>
		<?php
			if($content['school_type'] == 1){
				echo 'Általános iskola';
			}
			elseif($content['school_type'] == 2){
				echo 'Középiskola';
			}
			elseif($content['school_type'] == 3){
				echo 'Főiskola / egyetem';
			}
		?>
		</dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>		
		
		<dt style="font-size:100%; color:grey;">Jelenlegi oktatási <br /> intézmény adatai:</dt>
		<dd><?php echo $content['school_data'];?></dd>
		
	</dl>	
</div>	 
<div class="modal-footer">
	<button onclick="window.location.href = 'admin/pre_register/update/<?php echo $content['user_id'];?>';" type="button" class="btn blue">Adatok módosítása</button>
	<button type="button" class="btn blue" id="szerzodes_print_1" data-id="<?php echo $content['user_id'];?>">Szerződés nyomtatása</button>
	<button type="button" class="btn default" data-dismiss="modal">Bezár</button>
</div>