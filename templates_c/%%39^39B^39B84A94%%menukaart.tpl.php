<?php /* Smarty version 2.6.26, created on 2010-08-10 15:35:42
         compiled from menukaart.tpl */ ?>
<h1>Menukaart</h1>
<table>
	<tbody>
		<!-- start menu section -->
		<?php 

			$menu = new menu();
			$menu->read();
			$menu_lijst = $menu->lijst;

			$gerecht = new gerecht();
			$gerecht->read();
			$gerecht_lijst = $gerecht->lijst;

			foreach($menu_lijst as $menu){
		 ?>
		<tr>
			<td>
				<h2 class="menu_header"><?php echo $menu->naam; ?></h2><h4>(Klik op een rij om de opties te tonen)</h4>
			</td>
		</tr>
		<?php 
				foreach($gerecht_lijst as $gerecht){
					if($gerecht->menu_id == $menu->id){

		 ?>
		<tr class="gerecht_rij">
			<td class="gerecht_lijn" id="rij_<?php echo $gerecht->id; ?>">
				<img src="images/content/<?php echo $gerecht->image; ?>" alt="<?php echo $gerecht->naam; ?>"/>
				<div class="gerecht_data">
					<p class="gerecht_code">
						<?php echo $gerecht->code; ?>
					</p>
					<p class="gerecht_naam">
						<?php echo $gerecht->naam; ?>
					</p>
					<p class="gerecht_omschrijving">
						<?php echo $gerecht->omschrijving; ?>
					</p>
					<p class="gerecht_bestanddelen">(<?php 

						/*
						* SELECT b.naam, b.prijs FROM gerecht_bestanddeel g, bestanddeel b
						* WHERE g.bestanddeel_id = b.id AND g.gerecht_id = 2;
						*/

						$bpg 				= new tmap(); //bestanddelen per gerecht
						$bpg->table_arr		= array('gerecht_bestanddeel g', 'bestanddeel b');
						$bpg->column_arr	= array('b.naam', 'b.prijs');
						$bpg->where_arr		= array('g.bestanddeel_id' => 'b.id', 'g.gerecht_id' => $gerecht->id);
						$bpg->lijst			= $bpg->lezen();
						$bpg_lijst			= $bpg->lijst;
						$bpg_aantal_rijen	= $bpg->aantalRijen;

						$prijs_toevoeging	= 0.00;
						for($i=0 ; $i<$bpg_aantal_rijen ; $i++){
							$prijs_toevoeging += $bpg_lijst[$i]->prijs;
							if($i == 0){
								echo $bpg_lijst[$i]->naam;
							} else if ($i == $bpg_aantal_rijen-1){
								echo ' en ' . $bpg_lijst[$i]->naam;
							} else {
								echo ', ' . $bpg_lijst[$i]->naam;
							}
						}
						$dirty_basisprijs_totaal = $gerecht->basisprijs + $prijs_toevoeging;
						$basisprijs_totaal = number_format($dirty_basisprijs_totaal, 2, '.', '');

					 ?>)
					</p>
					<p class="gerecht_basisprijs">
						&#8364; <span class="gerecht_prijs_<?php echo $gerecht->id; ?>"><?php echo $basisprijs_totaal; ?></span>
					</p>
				</div>
			</td>
			<td class="hidden">
				<input type="radio" class="gerecht_keuze" name="gerecht_id[]" value="<?php echo $gerecht->id; ?>" />
			</td>
		</tr>
		<?php 
					}
				}
			}
		 ?>
		<!-- end menu section -->
	</tbody>
</table>