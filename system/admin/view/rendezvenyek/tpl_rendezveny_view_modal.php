<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Részletek</h4>
</div>
<div class="modal-body">		
    <dl class="dl-horizontal">
        <dt style="font-size:100%; color:grey;">Azonosító szám:</dt>
        <dd>#<?php echo $content['rendezveny_id']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Megtekintések száma:</dt>
        <dd><?php echo $content['megtekintes']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Megnevezés:</dt>
        <dd><?php echo $content['rendezveny_title']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Kép:</dt>
        <dd><img style="width: 200px;" src="<?php echo Util::thumb_path(Config::get('rendezvenyphoto.upload_path') . $content['rendezveny_photo']); ?>"></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>                

        <dt style="font-size:100%; color:grey;">Város:</dt>
        <dd><?php echo $content['city_name']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Helyszín:</dt>
        <dd><?php echo $content['rendezveny_location']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Cím:</dt>
        <dd><?php echo $content['rendezveny_address']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Leírás:</dt>
        <dd><div class="jatszohaz-view-modal"><?php echo $content['rendezveny_description']; ?></div></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Facebook oldal:</dt>
        <dd><?php echo $content['facebook_site_name']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Játékok:</dt>
        <dd><?php echo $szolgaltatasok; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Kezdő időpont:</dt>
        <dd><?php echo $content['rendezveny_start_timestamp']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Befejezés időpont:</dt>
        <dd><?php echo $content['rendezveny_expiry_timestamp']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Létrehozás dátuma:</dt>
        <dd><?php echo $content['rendezveny_create_timestamp']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Utolsó módosítás dátuma:</dt>
        <dd><?php echo $content['rendezveny_update_timestamp']; ?></dd>
        <div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

        <dt style="font-size:100%; color:grey;">Státusz:</dt>
        <dd><?php echo ($content['rendezveny_status'] == 0) ? 'Inaktív' : 'Aktív'; ?></dd>
    </dl>	
</div>	 
<div class="modal-footer">
    <button onclick="window.location.href = 'admin/rendezvenyek/update_rendezveny/<?php echo $content['rendezveny_id']; ?>';" type="button" class="btn blue">Adatok módosítása</button>
    <button type="button" class="btn default" data-dismiss="modal">Bezár</button>
</div>