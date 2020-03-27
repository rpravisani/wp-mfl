<?php

/********************************************** 
   IMPLEMENTAZIONI SITO MFL CON TEMA AVADA
 **********************************************/

/*** CUSTOM POST TYPE scheda_film ***/
include 'funzioni_cpt_produzioni.php';


/*** aggiungo icone IMDb e Cinando in barra top di fianco a icone social - Tema Avada ***/
if ( ! function_exists( 'avada_header_social_links' ) ) {
	/**
	 * Return the social links markup. MODIFIED BY CC
	 *
	 * @return string
	 */
	function avada_header_social_links() {
		$social_icons = fusion_get_social_icons_class();

		$html = '';

		if ( $social_icons ) {
			$options = [
				'position'          => 'header',
				'icon_boxed'        => Avada()->settings->get( 'header_social_links_boxed' ),
				'tooltip_placement' => fusion_get_option( 'header_social_links_tooltip_placement' ),
				'linktarget'        => Avada()->settings->get( 'social_icons_new' ),
			];

			$render_social_icons = $social_icons->render_social_icons( $options );
			$html                = ( $render_social_icons ) ? '<div class="fusion-social-links-header">' . $render_social_icons . '</div>' : '';
			$html .= "<!-- CC IMPLEMENT IN ".__FILE__." -->";
			$html .= '<div class="extra-social">';
			$html .= '<a href="https://cinando.com/en/Company/media_free_lance_94097/Detail/" target="_blank" rel="nofollow" data-placement="bottom" title="Visita la nostra pagina su Cinando" data-toggle="tooltip"><img src="https://www.mediafreelance.it/wp-content/uploads/2019/09/cinando_22x87.png"></a>';
			$html .= '<a href="https://www.imdb.com/title/tt7412320/?ref_=nm_knf_t1" target="_blank" rel="nofollow" data-placement="bottom" title="Visita la nostra pagina su IMDb" data-toggle="tooltip"><img src="https://www.mediafreelance.it/wp-content/uploads/2019/09/imdb_22x45-transp.png"></a>';
			$html .= "</div>";
		}

		return $html;
	}
}




/* -------------------------------------- SHORTCODE -----------------------------------------------------*/

// Shortcode per mostrare sezione cast all'intero del contenuto
function produzioni_attori_shortcode( $atts ) {

	$post_id = get_the_ID();
	
	// imposto costante GOT_ATTORI per indicare al layout principale che ho già utilizzato lo shortcode e che quinid non lo deve inserire nel normale flusso pagina
	define('GOT_ATTORI', true);
	
	// recupero l'elencodegli attori da db
	$attori_selezionati = get_post_meta($post_id, "attori-film", true);
	$attori_filtered = array();
	if($attori_selezionati){
		foreach($attori_selezionati as $attore_selezionato){
			if(!empty($attore_selezionato) ) $attori_filtered[] = $attore_selezionato;
		}
	}
	
	
	// se non ho trovato attore restituisco stringa vuota
	if(empty($attori_filtered)) return "";
	
	// recupero dettagli degli attori (informazioni in post personalizzati)
	$elenco_attori = get_posts( array("post_type" => 'attori', "numberposts" => -1, 'post__in' => $attori_filtered ) );
	
	// apro output buffer
	ob_start();
	?>	
	<!-- CAST / ATTORI --------------------------------------------------------->											
	<div class="attori">
		<h3 class="title-heading-left" style="margin-bottom: 0;">CAST</h3>
	<?php
		foreach($elenco_attori as $attore){
			$nome_attore = ucwords(strtolower($attore->post_title));
			$link_attore = get_permalink($attore->ID);
			$foto_attore = get_the_post_thumbnail($attore->ID, array(150,150));
			if(empty($foto_attore)) $foto_attore = wp_get_attachment_image(116, array(150,150))

			?>
			<div class="attore">
				<a href="<?php echo $link_attore; ?>">
					<?php echo $foto_attore; ?>
					<?php echo $nome_attore; ?>
				</a>
			</div>
			<?php
		}
	?>
		<div class="fusion-clearfix"></div>
	</div>
	<?php 
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}

add_shortcode( 'produzioni_attori', 'produzioni_attori_shortcode' );



/* --------------- SHORTCODE PER MOSTRARE TABELLA DETTAGLI ALL'INTERNO DEL CONTENUTO --------------------------------------------*/

function produzioni_dettagli_shortcode( $atts ) {
	
	// imposto costante GOT_DETTAGLI per indicare al layout principale che ho già utilizzato lo shortcode e che quindi non lo deve inserire nel normale flusso pagina
	define('GOT_DETTAGLI', true);
	
	$post_id = get_the_ID();
	
	// Per non fare troppe chiamate al db estrapolo tutti i meta del post (scheda film) in una volta sola
	$all_meta_film = get_post_custom($post_id);
	
	// setto variabili
	$generi = get_the_term_list( $post_id, 'generi', '', ',', ' ' ); // tipo tag
	$durata  	 = $all_meta_film['durata-film'][0];
	$regia   	 = $all_meta_film['regia-film'][0];
	$anno    	 = $all_meta_film['anno-film'][0];
	$lingua  	 = $all_meta_film['lingua-film'][0];
	$sottotitoli = $all_meta_film['sottotitoli-film'][0];
	$limite_eta  = $all_meta_film['limite-eta-film'][0];
	
	// DISTRIBUTORE
	$distributore = "";	
	if(!empty($all_meta_film['logo-distributore-film'][0]) or !empty($all_meta_film['nome-distributore-film'][0])){
		
		//nome_distributore è logo se presente se no nome 
		$nome_distributore = (empty( $all_meta_film['logo-distributore-film'][0])) ? "<strong>".$all_meta_film['nome-distributore-film'][0]."</strong>" : wp_get_attachment_image($all_meta_film['logo-distributore-film'][0], 'full');
		// se ho anche definito un link racchiudo nome_distributore in tag <a>
		$distributore = (empty($all_meta_film['link-distributore-film'][0])) ? $nome_distributore : $distributore = "<a href='".$all_meta_film['link-distributore-film'][0]."' target='_blank'>".$nome_distributore."</a>";
		
	}
	
	
	ob_start();
	?>
	<!-- TABELLA DETTAGLI --------------------------------------------------------->
	<h3 class="title-heading-left" style="margin-bottom: 0;">DETAILS / DETTAGLI</h3>

	<div id="table-dettagli" class="table-2 ">
		<table width="100%">
			<tbody>
				<?php if(!empty($generi)){ ?>
				<tr>
					<td align="left">Genre / Genere</td>
					<td align="left"><strong><?php echo $generi; ?></strong></td>
				</tr>
				<?php } ?>
				<?php if(!empty($durata)){ ?>
				<tr>
					<td align="left">Length / Durata</td>
					<td align="left"><strong><?php echo $durata; ?> Min.</strong></td>
				</tr>
				<?php } ?>
				<?php if(!empty($regia)){ ?>
				<tr>
					<td align="left">Directed by / Regia di</td>
					<td align="left"><strong><?php echo $regia; ?></strong></td>
				</tr>
				<?php } ?>
				<?php if(!empty($anno)){ ?>
				<tr>
					<td align="left">Year / Anno</td>
					<td align="left"><strong><?php echo $anno; ?></strong></td>
				</tr>
				<?php } ?>
				<?php if(!empty($lingua)){ ?>
				<tr>
					<td align="left">Language / Lingua</td>
					<td align="left"><strong><?php echo $lingua; ?></strong></td>
				</tr>
				<?php } ?>
				<?php if(!empty($sottotitoli)){ ?>
				<tr>
					<td align="left">Subtitles / Sottotitoli</td>
					<td align="left"><strong><?php echo $sottotitoli; ?></strong></td>
				</tr>
				<?php } ?>
				<?php if(!empty($limite_eta)){ ?>
				<tr>
					<td align="left">Age Rating / Limite età</td>
					<td align="left"><strong><?php echo $limite_eta; ?></strong></td>
				</tr>
				<?php } ?>
				<?php if(!empty($distributore)){ ?>
				<tr>
					<td align="left">Distribution / Distributore</td>
					<td align="left"><?php echo $distributore; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<!-- FINE TABELLA DETTAGLI --------------------------------------------------------->
	<?php
	
	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
	
}

add_shortcode( 'produzioni_dettagli', 'produzioni_dettagli_shortcode' );



/* --------- SHORTCODE PER MOSTRARE SEZIONE SOCIAL / LINKS DEL FILM ALL'INTERNO DEL CONTENUTO -----------------------------------*/

function produzioni_link_shortcode( $atts ) {
	
	// imposto costante GOT_LINK per indicare al layout principale che ho già utilizzato lo shortcode e che quindi non lo deve inserire nel normale flusso pagina
	define('GOT_LINKS', true);
		
	$post_id = get_the_ID();
	
	// Setto valore default dell'output funzione
	$output = "";
	
	// Per non fare troppe chiamate al db estrapolo tutti i meta del post (scheda film) in una volta sola
	$all_meta_film = get_post_custom($post_id);
	
	// setto variabili vuote. Ci sono due sezioni: il link a social con solo icona e link personalizzate con icona generica e testo
	$social_links_film = $links_film = array();
	
	// Social
	if(!empty( $all_meta_film['link-fb-film'][0] )){
		$social_links_film[] = "<a href='".$all_meta_film['link-fb-film'][0]."' target='_blank'><i class='fontawesome-icon fa-facebook-square fab'></i></a>";
	}
	if(!empty( $all_meta_film['link-youtube-film'][0] )){
		$social_links_film[] = "<a href='".$all_meta_film['link-youtube-film'][0]."' target='_blank'><i class='fontawesome-icon fa-youtube fab'></i></a>";
	}
	if(!empty( $all_meta_film['link-vimeo-film'][0] )){
		$social_links_film[] = "<a href='".$all_meta_film['link-vimeo-film'][0]."' target='_blank'><i class='fontawesome-icon fa-vimeo fab'></i></a>";
	}
	if(!empty( $all_meta_film['link-imdb-film'][0] )){
		$social_links_film[] = "<a href='".$all_meta_film['link-imdb-film'][0]."' target='_blank'><i class='fontawesome-icon fa-imdb fab'></i></a>";
	}
	
	// link personalizzati (max 3 per ora)
	if(!empty( $all_meta_film['link-1-film'][0] )){
		$links_film[] = "<a class='text-link' href='".$all_meta_film['link-1-film'][0]."' target='_blank'><i class='fontawesome-icon fa-link fas'></i>".$all_meta_film['name-link-1-film'][0]."</a>";
	}
	if(!empty( $all_meta_film['link-2-film'][0] )){
		$links_film[] = "<a class='text-link' href='".$all_meta_film['link-2-film'][0]."' target='_blank'><i class='fontawesome-icon fa-link fas'></i>".$all_meta_film['name-link-2-film'][0]."</a>";
	}
	if(!empty( $all_meta_film['link-3-film'][0] )){
		$links_film[] = "<a class='text-link' href='".$all_meta_film['link-3-film'][0]."' target='_blank'><i class='fontawesome-icon fa-link fas'></i>".$all_meta_film['name-link-3-film'][0]."</a>";
	}

	// output solo se almeno uno dei due array ha del contenuto (quindi o social o link personalizzati)
	if(!empty($social_links_film) or !empty($links_film)){
		
		// apro output buffer
		ob_start();
	?>
	<!-- LINK / SOCIAL --------------------------------------------------------->
	<div class="link-film">
	<?php
		if(!empty($social_links_film)){
			echo "<div class='social-links'>";
			foreach($social_links_film as $social_link_film) echo $social_link_film;
			echo "<div class=\"fusion-clearfix\"></div>\n";
			echo "</div>";
		}
		if(!empty($links_film)){
			echo "<div>";
			foreach($links_film as $link_film) echo $link_film;
			echo "</div>";
		}
	?>
	</div>
	<!-- FINE LINK / SOCIAL --------------------------------------------------------->
	<?php
		
		$output = ob_get_contents();
		ob_end_clean();
			
	} // end if social_links_film or links_film
	
	return $output;
	
}

add_shortcode( 'produzioni_link', 'produzioni_link_shortcode' );


/* ----------- SHORTCODE PER MOSTRARE SEZIONE VIDEO DEL FILM ALL'INTERNO DEL CONTENUTO-------------------------------------------*/

// Shortcode per mostrare sezione video del film all'intero del contenuto
function produzioni_video_shortcode( $atts ) {
	
	// imposto costante GOT_VIDEO per indicare al layout principale che ho già utilizzato lo shortcode e che quindi non lo deve inserire nel normale flusso pagina
	define('GOT_VIDEO', true);
	
	$post_id = get_the_ID();
	
	// recupero link video (TODO: controllare che sia effettivamente un iframe)
	$videolink = get_post_meta($post_id, "videolink-film", true);
	
	if(empty($videolink)) return ""; // se non c'è link video restituisco stringa vuota
	ob_start();
	?>
	<!-- VIDEO --------------------------------------------------------->
	<h3 class="title-heading-left"><?php echo strtoupper( get_post_meta($post->ID, "titolo-videolink-film", true) ); ?></h3>
	<div class="videolink">
		<?php echo $videolink; ?>
	</div>						
	<!-- FINE VIDEO --------------------------------------------------------->
	<?php 
	$output = ob_get_contents();
	ob_end_clean();		
	
	return $output;
	
}

add_shortcode( 'produzioni_video', 'produzioni_video_shortcode' );


