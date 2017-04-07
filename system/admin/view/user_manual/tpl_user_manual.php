<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
        <h3 class="page-title">
            CMS <small>dokumentáció</small>
        </h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="admin/home">Kezdőoldal</a> 
                    <i class="fa fa-angle-right"></i>
                </li>
                <li><a href="#">Dokumentáció</a></li>
            </ul>
        </div>
        <!-- END PAGE TITLE & BREADCRUMB-->
        <!-- END PAGE HEADER-->

        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">


                <h3><legend>Megajátszóház CMS dokumentáció</legend></h3>



                <div class="tab-pane" id="tab_1_3">
                    <div class="row profile-account documentation">
                        <div class="col-md-3">
                            <ul class="ver-inline-menu tabbable margin-bottom-10">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab_1-1"><i class="fa fa-cog"></i>A CMS-ről</a> 
                                    <span class="after"></span>                                    
                                </li>
                                <li ><a data-toggle="tab" href="#tab_2-2"><i class="fa fa-gavel"></i> Rendezvények</a></li>
                                <li ><a data-toggle="tab" href="#tab_3-3"><i class="fa fa-star"></i> Szolgáltatások</a></li>  
                                <li ><a data-toggle="tab" href="#tab_4-4"><i class="fa fa-shopping-cart"></i> Webshop funkciók</a></li> 
                                <li ><a data-toggle="tab" href="#tab_5-5"><i class="fa fa-shopping-cart"></i> Termékek</a></li>   
                                <li ><a data-toggle="tab" href="#tab_6-6"><i class="fa fa-files-o"></i> Oldalak szerkesztése</a></li>
                                <li ><a data-toggle="tab" href="#tab_7-7"><i class="fa fa-font"></i> Meta adatok</a></li>
                                <li ><a data-toggle="tab" href="#tab_8-8"><i class="fa fa-pencil"></i> WYSIWYG szerkesztő</a></li>

                                <li ><a data-toggle="tab" href="#tab_9-9"><i class="fa fa-users"></i> Felhasználók</a></li>
                                <li ><a data-toggle="tab" href="#tab_10-10"><i class="fa fa-picture-o"></i> Képek kezelése</a></li>
                                
                                <li ><a data-toggle="tab" href="#tab_11-11"><i class="fa fa-suitcase"></i> Modulok</a></li>
                                <li ><a data-toggle="tab" href="#tab_12-12"><i class="fa fa-cogs"></i> Beállítások</a></li>
                            </ul>
                        </div>

                        <div class="col-md-9">
                            <div class="tab-content">
                                
 <!-- ****************************** A CMS RENDSZERRŐL ***************************** -->                                
                                <div id="tab_1-1" class="tab-pane active">
                                    <h3>Megajátszóház tartalomkezelő rendszer (CMS)</h3>

                                    <p>A weblap funkcióinak megfelelően kialakított adminisztrációs felületet lehetőséget biztosít a weblap tartalmának karbantartásához, frissítéséhez. Használatához nem szükséges szakirányú ismeretekkel rendelkezni, bárki könnyen megtanulhatja a rendszer kezelését.</p>
                                    <h4><i class="fa fa-chevron-circle-right"></i> A tartalomkezelőrendszer funkció</h4>
                                    <ul>
                                        <li>Rendezvények kezelése</li>
                                        <li>Szolgáltatások (játékok) kezelése</li>
                                        <li>Webshop funkciók</li>
                                        <li>Regisztráltak / hírlevélre feliratkozottak kezelése</li>
                                        <li>Oldalak tartalmának szerkesztése</li>
                                        <li>Felhasználók kezelése (az adminisztrációs rendszer felhasználói)</li>
                                        <li>Facebook</li>
                                        <li>Modulok
                                            <ul>
                                                <li>Kezdőoldali slider (képváltó) szerkesztése</li>
                                                <li>Rólunk mondták</li>
                                            </ul>
                                        </li>    
                                        <li>Fájlkezelő</li>
                                        <li>Beállítások</li>
                                        <li>Dokumentáció</li>
                                    </ul>
                                 </div>
 
<!-- ****************************** NGATLANOK LISTÁJA ***************************** -->                                
                                <div id="tab_2-2" class="tab-pane">
                                    <h3>Rendezvények</h3>
                                    
<p>Az adminisztrációs rendszerben felvitt rendezvények listázása lehetővé teszi a rendezvények áttekintését (a főbb jellemzők alapján), valamint különféle műveletek végrehajtását. A listázáshoz beállítható (listából kiválasztva), hogy egy oldalon mennyi rendezvény jelenjen meg, és a "kereső sor" pedig lehetővé teszi a listában megjelenített elemekben történő keresést.</p>
<p>A lista fejlécében található háromszögekre kattintva a lista az oszlopok szerint (nem mindegyik alapján) sorba rendezhető. </p>
                                    
<img src="<?php echo ADMIN_IMAGE; ?>rendezvenyek_lista.jpg" class="img-thumbnail">                        

<h4><i class="fa fa-chevron-circle-right"></i> Műveletek a rendezvényekkel</h4>
<p>Az lista utolsó oszlopában található fogaskerék ikonra kattintva megjelenik az adott rendezvénynel végezhető műveletek listája.</p>

                                    <ul>
                                        <li><strong>Részletek:</strong> a rendezvény valamennyi adata megtekinthető</li>
                                        <li><strong>Szerkesztés:</strong> a rögzített adatok módosítása</li>
                                        <li><strong>Törlés:</strong> a művelet véglegesen törli a munkát az adatbázisból</li>
                                        <li><strong>Klónozás:</strong> a rendezvény adataival új rendezvény jön létre</li>
                                        <li><strong>Blokkolás / aktiválás:</strong> a blokkolt rendezvény inaktív státuszba kerül, ami azt jelenti, hogy nem jelnenik meg a front oldalon, de nem törlődik az adatbázisból. A blokkolt rendezvény újra aktív állapotba állítható.</li>    
                                        
                                    </ul>

<h4><i class="fa fa-chevron-circle-right"></i> Szűrés</h4>

                                    <p>A szűrés sáv használatával szűkíthető a megjelenített rendezvények listája. A szűrési feltételek a "x" gombra kattintva törölhetők: az űrlap tartalma törlődik, és a szűrés nélküli találati lista töltődik be (az "újratöltés" gombra kattintás ugyanezt eredményezi).</p>
                                    <p>Id-re történő kereséskor csak a számot kell beírni (# nélkül).</p>
                                    <p>A szűrési feltételek ÉS kapcsolatban vannak egymással, vagyis azok a rendezvények fognak a találati listában mszerepelni, amelyek valamennyi szűrési feltételenek megfelelnek.</p>    
                                    
                                    <p>Csoportos műveletek: az első oszlop jelölő négyzeteivel jelölhetők be azok a rendezvények, amelyekre csoportos műveletet szeretnénk végrehajtani. A rendezvények kiválasztása után a "csoportművelet" gomb melletti listából ki kell választani az alkalmazandó műveletet.</p>    
                                    
                                

                                 </div> 

<!-- ****************************** NGATLANOK FELVITELE ***************************** -->                                
                                <div id="tab_3-3" class="tab-pane">
                                    <h3>Szolgáltatások</h3>
 
                                    <p>Lorem ipsus...</p>
                                    
                                                                      
<img src="<?php echo ADMIN_IMAGE; ?>szolgaltatasok.jpg" class="img-thumbnail">                             
                              
                                  
                                 
                                 </div> 

<!-- ****************************** KÉPEK FELTÖLTÉSE ***************************** -->                                
                                <div id="tab_4-4" class="tab-pane">
                                    <h3>Webshop Funkciók</h3>
                                    



                                 </div>

<!-- ****************************** KÉPEK FELTÖLTÉSE ***************************** -->                                
                                <div id="tab_5-5" class="tab-pane">
                                    <h3>Termékek kezelése</h3>
                                    
<p>Lorem ipsus...</p>

                                 </div>

   <!-- ****************************** Oldalak szerkesztése ***************************** -->									
                                <div id="tab_6-6" class="tab-pane">

                                    <h3>Oldalak szerkesztése</h3>
                                    <p>A weblap oldalai tartalmának szerkesztése az Oldalak menüben, az Oldalak listája menüpont alatt érhető el. A listában a szerkesztés gombra kattintva jelenik meg a szerkesztő felület, amelyen az úgynevezett meta adatok (title, description, keywords - részletes információ a <strong>meta adatok</strong> részben) és a tartalom szerkeszthető. Ez utóbbi szerkesztése egy WYSIWYG szerkesztő felületen történik (részletes információ a <strong>WYSIWYG szerkesztő</strong> részben).     

                                </div>
                                <!-- ****************************** Meta adatok ***************************** -->									
                                <div id="tab_7-7" class="tab-pane">

                                    <h3>Oldalak szerkesztése - meta adatok megadása</h3>

                                    <h4><i class="fa fa-chevron-circle-right"></i> Title, description és keywords megadása</h4>
                                    <p>A szerkeszthető oldalak esetében megadhatók a title, description és keywords meta adatok, amelyek a weboldalon közvetlenül nem láthatók, de van funkciójuk. A title a keresőoptimalizálás terén fontos elem, a jól megfogalmazott description növelheti a kattintási arányt a Google találati listájában, a keywords azonban a Google esetében már nem bír jelentőséggel, így ez az elem akár üresen is hagyható. </p>
                                    <h4><i class="fa fa-chevron-circle-right"></i> Title (az oldal címe)</h4>
                                    <p>A title (amennyiben az oldal tartalmához reveleváns módon van megfogalmazva) képezi a Google találati listájában megjelenő címet, és ez jelenik meg a böngésző füleken is címként. 
                                    <p>Az oldal címét (title) az alábbi szempontok szerint érdemes összeállítani:</p>
                                    <ul>
                                        <li>Szerkezet:  A title elején legyen a kulcsszó (kulcsszó kifejezés), amire az adott oldalt szeretnénk optimalizálni. </li>
                                        <li>Hossz: a title ne legyen hosszabb 70 karakternél, de ne is legyen nagyon rövid.</li>
                                        <li>Minden title különböző legyen</li>
                                        <li>Ne legyen a kulcsszó többször ismételve</li>

                                    </ul>
                                    <h4><i class="fa fa-chevron-circle-right"></i> Description (leírás)</h4>
                                    <p>A description a weboldal tartalmát írja le a title-nél kicsit hossszabban. Amennyiben a description releváns a weboldal tartalmához, a Google a találati listában a cím alatt az oldal description elemét jeleníti meg leírásként, ellenkező esetben a weboldal szövegéből választ a Google algoritmusa szövegrészleteket. A jó leírás növelheti a kattintási arányt, de keresőoptimalizálási szempontból nincs közvetlen jelentősége.</p>  
                                    <h4><i class="fa fa-chevron-circle-right"></i> Keywords (kulcsszavak)</h4>
                                    <p>A weboldalra jellemző kulcsszavakat lehet a keywords meta elemben elhelyezni. Mivel korábban manipulatív céllal használták, ezért a Google algoritmusa már nem veszi figyelembe.</p> 
                                </div>                                

                                <!-- ****************************** WYSIWYG szerkesztő ***************************** -->									
                                <div id="tab_8-8" class="tab-pane">

                                    <h3>WYSIWYG szerkesztő</h3>
                                    <p>Az úgynevezett WYSIWYG  (What You See Is What You Get = Amit lát, azt kapja) szövegszerkesztő segítségével, a Word-höz hasonlóan formázhatja meg a szöveget, vagy szúrhat be képeket, YouTube videókat, vagy HTML elemeket. A mentés után a weboldalon máris a módosított tartalom érhető el. A WYSIWYG szerkesztők célkitűzése egy olyan felületet biztosítása a felhasználók számára, amelyen keresztül vizuálisan lehet elkészíteni a formázott szöveget, akár a HTML nyelv ismerete és a forráskód szerkesztése nélkül is. </p>
                                    <p>Nem szükséges tehát a HTML nyelv ismerete a weblap tartalmának módosításához, a szöveges tartalmakat, képeket, beágyazott videókat egyszerűen szerkesztheti. A forráskód nézetben a komolyabb szerkesztési műveletek is elvégezhetők, de ehhez nem árt némi HTML ismerettel rendelkezni. </p>
                                    <img src="<?php echo ADMIN_IMAGE; ?>wysiwyg_editor_1.jpg" class="img-thumbnail">

                                    <h4><i class="fa fa-chevron-circle-right"></i> A WYSIWYG szerkesztő előnyei</h4>
                                    <ul>
                                        <li>Áttekinthető tartalom: a szerkesztő nagyjából helyesen mutatja a tartalmat, ahhoz hasonlóan, ahogy az a weboldalon meg fog jelenni.</li>
                                        <li>A tartalom szerkesztésekor azonnal látható az eredmény, a WYSIWYG szerkesztő az eredményhez közeli állapotot mutatja a HTML forrás helyett</li>
                                        <li>A tartalom egyszerű szerkesztése: a megfelelő elemre kattinthatva azt átszerkeszthetjük, míg a forráskód esetén nem kis ügyességet igényel a forráskód vonatkozó részét tévedés nélkül megtalálni és módosítani.</li>                                    
                                    </ul> 
                                    <p>
                                        <span class="badge badge-danger">FIGYELEM</span>
                                        <span>A módosítások elmentése után nincs lehetőség visszaállításra, ezért a mentést célszerű körültekintéssel végezni!</span>
                                    </p>
                                    <p>
                                        <span class="badge badge-info">INFO</span>
                                        <span>A WYSIWYG szerkesztő nem profi HTML szerkesztő alkalmazás, ezért csak kellő tapasztalattal és HTML ismeretekkel érdemes a forráskódot szerkeszteni!</span>
                                    </p>

                                    <h4><i class="fa fa-chevron-circle-right"></i> Mire kell figyelni?</h4>
                                    <ul>
                                        <li>Formázás alkalmazása: a szerkesztőben elvégzett formázások módosítják a weblap megjelenését, felülírják a weblaphoz készített úgynevezett stíluslap utasításait. Formázás alkalmazásával eltűnhetnek az eredetileg alkalmazott stílusok.</li>
                                        <li>Lehetőleg ne módosítsa a betűtípust! A módosított betűtípus helyesen (ékezetekkel) csak akkor fog a weblapot meglátogató felhasználó számára megjelenni, ha annak magyar ékezetes készlete telepítve van a felhasználó gépére. A különöző, nem összeillő betűtípusok az egységes dizánt rontják, amatőr hatást keltenek.</li>
                                        <li>Képek beszúrásakor, módosításakor a kép feltöltése eredeti méretben történik, ezért ügyelni kell arra, hogy ne nagyméretű képeket töltsön le a böngésző, mivel a nagy fájlméret lassítja a weboldal betöltését. </li>                                    
                                    </ul> 
                                    <h4> <i class="fa fa-chevron-circle-right"></i> Képek beszúrása, módosítása</h4>
                                    <p>A weboldal szöveges tartalmába képek szúrhatók be, illezve a meglévő képek helyett más képek helyezhetők el a dokumentumban..</p>
                                    <p>Kép beszúrás folyamata:</p>
                                    <ul>
                                        <li>A szekesztő ikon sorában kattintson a kép ikonra, vagy kép módosításakor kattintson kétszer a képre.</li>
                                        <li>A kép tulajdonságai ablakban kattintson a "böngészés a szerveren" gombra.</li>
                                        <li>A külön ablakban megnyíló fájlkezelőben dupla kattintással válassza aki a kívánt képet, vagy a feltöltés gombra kattintva töltsön fel új képet, majd azt válassza ki (a szerkesztőben feltöltött képek az uploads/images mappába kerülnek).</li> 
                                        <li>A kép tulajdonságai ablakban megjelenik a kiválasztott kép elérési útvoanala (hivatkozás) valamint az előnézete. Amennyiben megjelennek a szélesség és magasság rubrikákban a kép méretei, törölje ki azokat, mivel a méret megadása tönkre teszi a reszponzív megjelenítést.</li> 
                                    </ul> 
                                    <img src="<?php echo ADMIN_IMAGE; ?>kep_beszuras.jpg" class="img-thumbnail">                                    





                                </div>

<!-- ****************************** FELHASZNÁLÓK ***************************** -->

                                <div id="tab_9-9" class="tab-pane">
                                    <h3>Felhasználók</h3>

                                    <h4><i class="fa fa-chevron-circle-right"></i> Az adminisztrációs rendszerhez hozzáféréssel rendelkező felhasználók kezelése</h4>
                                    <p>A felhasználók menüben - jogosultságtól függően - a következő funkciók érhetők el:
                                    <ul>
                                        <li>Felhasználók listázása</li>
                                        <li>Új felhasználó létrehozása (csak szuperadmin hozhat létre felhasználót, szuperadmin vagy admin jogosultsággal</li>
                                        <li>Felhasználó törlése (egyedi vagy csoportos törlés, szuperadmin nem törölhető, admin nem törölhet admin jogosultságú felhasználót)</li> 
                                        <li>Felhasználó státusz (aktív / inaktív) módosítása (szuperadmin nem tehető inaktívvá). Az inaktív felhasználó nem léphet be az adminisztrációs rendszerbe. </li> 
                                        <li>Felhasználói profil módosítása. A bejelentkezett felhasználó módosíthatja adatait.</li> 
                                    </ul>    
                                    <p>Az adminisztrációs rendszerben a felhasználók felhasználói csoportokba tartoznak. A egyes felhasználói csoportok különböző jogosultságokkal rendelkeznek, és ennek megfelelően eltérő adminisztrációs felületet (funkciókat) érhetnek el. </p>
                                    <h4><i class="fa fa-chevron-circle-right"></i> Felhasználói jogosultságok</h4>        
                                    <p>Kétféle jogosultság létezik az adminisztrációs rendszerben: szuperadminisztrátor (szuperadmin) és adminisztrátor (admin). A szuperadmin létrehozhat új felhasználót, és törölhet admin jogosultságú felhasználót. Az admin nem hozhat létre és nem törölhet felhasználót. A szuperadmin bármelyik felhasznál nevében rögzíthet munkát, míg az admin csak a saját nevében teheti ezt meg. Egyéb tekintetben megegyeznek a felhasználói jogosultságok. </p>

                                </div>

<!-- ****************************** Képek kezelése, feltöltése ***************************** -->							
                                <div id="tab_10-10" class="tab-pane">
                                    <h3>Képek kezelése, feltöltése </h3>


                                    <h4><i class="fa fa-chevron-circle-right"></i> Képek feltöltése a különböző modulokban (pl.:felhasználók, slider, képgaléria)</h4>

                                    <p>A képfeltöltésnél a "kiválasztás" gombra kattintva lehet feltöltésre képet kiválasztani. Kiválasztás után megjelenik egy "módosít" és egy "töröl" elnevezésű gomb. A módosít gombra kattintva választható ki másik kép, a töröl gombbal pedig „resetelhető”  a kiválasztás. A kép feltöltése (és méretezése) ténylegesen a hozzá kapcsolódó űrlap elmentésekor történik meg.</p>
                                    <p>A felhasználókhoz, valamint az egyes modulokban feltöltött képeket a rendszer a megfelelő méretben tölti fel a szerverre (általában egy kisebb és egy nagyobb méretben), és az UPLOADS mappa megfelelő almappáiba kerülnek.   
                                    <p>
                                    
                                    <span class="badge badge-danger">FIGYELEM</span>
                                    <span>A feltöltött képek fájlnevét ne módosítsa, mivel  a képek elérését a rendszer adatbázosban tárolja, így azok a képek, amelyeknek a nevét módosítja, elérhetetlenné válnak! Ne módosítsa a képek méretét sem!</span>
                                    

                                    <h4><i class="fa fa-chevron-circle-right"></i> Képek kezelése a WYSIWYG szerkesztőben</h4>

                                    <p>A WYSIWYG szerkesztő a képfeltöltéskor és beillesztéskor nem „csinál semmit” a képpel, vagyis az eredeti képméretben töltődik fel a szerverre ( a html dokumentumba a képre való hivatkozás kerül be). Ezért érdemes a feltöltés előtt a kép méretét optimalizálni (pl. egy 3000 pixel széles képet elég maximum 600-700 pixeles méretben feltölteni). Az optimalizálás feltöltés után is végrehajtható. Erre használható az admin rendszer  fájlkezelője is, de ez viszonylag nagy képméretet produkál.</p>    
                                    <p>A WYSIWG szerkesztőben feltöltött képek az uploads/images mappába kerülnek. </p>
                                    <p>A szerkesztőben történő kép beszúrásról részletesebb információ a <strong>WYSIWYG szerkesztő</strong> részben található.</p> 

                                    <h4><i class="fa fa-chevron-circle-right"></i> Az admin rendszer fájlkezelője</h4>

                                    <p>Az adminisztrációs rendszer fájlkezelője lehetővé teszi az UPLOADS mappában található képek (vagy más típusú fájlok) kezelését. A képek másolhatók, törölhetők, átnevezhetők, valamint módosítható a méretük, kivághatók, illetve elforgathatók. </p>
                                    <p>Az IMAGES (a WYSIWYG szerkesztőben feltöltött képek kerülnek ide) mappa kivételével a képek a rendszer által megszabott méretben és néven kerülnek a szerverre, ezeket a képeket ezért nem ajánlatos bármilyen módon módosítani.</p>
                                    <p>Az IMAGES mappába feltöltött képek esetében csak arra kell figyelni, hogy ne változzon meg a kép neve.</p>
                                </div>

          <!-- ****************************** Modulok ***************************** -->

                                <div id="tab_11-11" class="tab-pane">
                                    <h3>Modulok kezelése</h3>


                                    <h4><i class="fa fa-chevron-circle-right"></i> Kezdőoldali slider</h4>


                                                                                                                                       

                                </div>
          
             <!-- *********************** BEÁLLÍTÁSOK ************************* -->
                                <div id="tab_12-12" class="tab-pane">
                                    <h3>Beállítások</h3>

                                    <p>A beállítások menüben a következő adatok módosíthatók:</p>
                                    <ul>
                                        <li>Cégnév - a weblap különböző helyein (kapcsolat, footer) megjelenő cégnév</li>
                                        <li>Cím - a weblap különböző helyein (kezdőoldal, kapcsolat, footer) megjelenő cím.</li>
                                        <li>Általános e-mail cím - a weblap különböző helyein (kezdőoldal, kapcsolat, footer) megjelenő e-mail. Erre az e-mail címre érkezik a weboldalról küldött üzenetek egy része.</li>
                                        <li>Telefon - a weblap különböző helyein (kezdőoldal, kapcsolat, footer) megjelenő központi telefonszám</li>
                                       
                                        <li>Facebook link: a Facebook oldal linkje (pl.: https://www.facebook.com/afacebookoldalneve)</li>                                        
                                    </ul>

                                    <p>A beállításban tárolt adat módosítása után a weblapon az illető adat minden helyen automatikusan módosulni fog. </p>    

                                </div>                                


                            </div> <!--END TAB-CONTENT-->
                        </div> <!--END COL-MD-9--> 
                    </div> <!--END ROW PROFILE-ACCOUNT-->
                </div> <!--END TAB-PANE-->


            </div> <!-- END COL-MD-12 -->
        </div> <!-- END ROW -->	

    </div> <!-- END PAGE CONTAINER-->    
</div> <!-- END PAGE CONTENT WRAPPER -->
</div> <!-- END CONTAINER -->