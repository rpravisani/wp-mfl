<?php

/*-------------------------------------------------------- 
                CUSTOM POST TYPE "PRODUZIONI" 
---------------------------------------------------------*/
 
function custom_post_type_produzioni() {
 
// Setta le labels dell UI per il Custom Post Type "Produzioni"
    $labels = array(
        'name'                => _x( 'Produzioni', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Produzione', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Produzioni', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Produzione genitore', 'twentythirteen' ),
        'all_items'           => __( 'Tutte le Produzioni', 'twentythirteen' ),
        'view_item'           => __( 'Vedi Produzione', 'twentythirteen' ),
        'add_new_item'        => __( 'Nuova Scheda Produzione', 'twentythirteen' ),
        'add_new'             => __( 'Nuova Produzione', 'twentythirteen' ),
        'edit_item'           => __( 'Modifica Produzione', 'twentythirteen' ),
        'update_item'         => __( 'Aggiorna Produzione', 'twentythirteen' ),
        'search_items'        => __( 'Cerca Produzione', 'twentythirteen' ),
        'not_found'           => __( 'Non trovato', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Non trovato in cestino', 'twentythirteen' ),
    );
     
// Altre opzioni
     
    $args = array(
        'label'               => __( 'produzioni', 'twentythirteen' ),
        'description'         => __( 'Schede film delle produzioni', 'twentythirteen' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 
									   'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // associo tassonomia 
        'taxonomies'          => array( 'generi', 'stati_produzione' ),
        /* Custom Post Type gerarchici (hierarchical) sono come Pagine e possono avere pagine genitori e figli
		*  Custom Post Type non-gerarchici sono invece come post/articoli
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon'     	  => 'dashicons-video-alt',
    );
     
    // Registro il Custom Post Type "Produzioni"
    register_post_type( 'produzioni', $args );

	
	
	
	
/*-------------------------------------------------------- 
                      TASSONOMIE 
---------------------------------------------------------*/
	
/**************************** TAXONOMY GENERI ***/
// Setto le label per la UI labels per tassonomia personalzzata
    $generi_labels = array(
        'name'                => _x( 'Genere', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Genere', 'Post Type Singular Name', 'twentythirteen' ),
        'search_items'        => __( 'Cerca Genere', 'twentythirteen' ),
        'popular_items'       => __( 'Generi Popolari', 'twentythirteen' ),
        'all_items'           => __( 'Tutti i Generi', 'twentythirteen' ),
        'parent_item'   	  => null,
        'parent_item_colon'   => null,
        'edit_item'           => __( 'Modifica Genere', 'twentythirteen' ),
        'update_item'         => __( 'Aggiorna Genere', 'twentythirteen' ),
        'add_new_item'        => __( 'Aggiungi Nuovo Genere', 'twentythirteen' ),
        'new_item_name'       => __( 'Nuovo Genere', 'twentythirteen' ),
        'separate_items_with_commas' => __( 'Puoi selezionare più generi separandoli con virgole', 'twentythirteen' ),
        'add_or_remove_items' => __( 'Aggiungi o rimuovi Generi', 'twentythirteen' ),
        'choose_from_most_used' => __( 'Scegli dai Generi più usati', 'twentythirteen' ),
        'menu_name'           => __( 'Generi', 'twentythirteen' ),
    );
	
    $generi_args = array(		
        'hierarchical'        => false, // si comporta come tags, se true come categorie
        'labels'              => $generi_labels,
        'show_ui'             => true,
        'query_var'           => true,
        'rewrite'         	  => array( 'slug' => 'genere' ),
    );
	
	register_taxonomy( 'generi', 'produzioni', $generi_args );
 
	
/**************************** TAXONOMY stato_produzione ***/
// Setto le label per la UI labels per tassonomia personalzzata
    $stati_labels = array(
        'name'                => _x( 'Stato Produzione', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Stato Produzione', 'Post Type Singular Name', 'twentythirteen' ),
        'search_items'        => __( 'Cerca Stato Produzione', 'twentythirteen' ),
        'all_items'           => __( 'Tutti gli Stati prod.', 'twentythirteen' ),
        'parent_item'   	  => __( 'Stato genitore', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Stato genitore:', 'twentythirteen' ),
        'edit_item'           => __( 'Modifica Stato', 'twentythirteen' ),
        'update_item'         => __( 'Aggiorna Stato', 'twentythirteen' ),
        'add_new_item'        => __( 'Aggiungi Nuovo Stato', 'twentythirteen' ),
        'new_item_name'       => __( 'Nuovo Stato Produzione', 'twentythirteen' ),
        'menu_name'           => __( 'Stati Produzione', 'twentythirteen' ),
        'not_found'           => __( 'Nessuno stato produzione trovato', 'twentythirteen' ),
    );
	
    $stati_args = array(		
        'hierarchical'        => true, // false si comporta come tags, true come categorie
        'labels'              => $stati_labels,
        'show_ui'             => true,
        'query_var'           => true,
        'rewrite'         	  => array( 'slug' => 'stato-produzione' ),
		'supports' 			  => array( 'thumbnail' ),
    );
		
	register_taxonomy( 'stati_produzione', 'produzioni', $stati_args );
 
}
 
/* Uso l'azione 'init' cosiccche la funzione che contiene la registrazione del CPT 
* non viene eseguito quando non necessario 
*/
 
add_action( 'init', 'custom_post_type_produzioni', 0 );



/*-------------------------------------------------------- 
                CUSTOM POST TYPE "ATTORI" 
---------------------------------------------------------*/
 
function custom_post_type_attori() {
 
    $labels = array(
        'name'                => _x( 'Attori', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Attore', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Attori', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Attore genitore', 'twentythirteen' ),
        'all_items'           => __( 'Tutti gli attori', 'twentythirteen' ),
        'view_item'           => __( 'Vedi Attore', 'twentythirteen' ),
        'add_new_item'        => __( 'Nuova Scheda Attore', 'twentythirteen' ),
        'add_new'             => __( 'Nuovo Attore', 'twentythirteen' ),
        'edit_item'           => __( 'Modifica Attore', 'twentythirteen' ),
        'update_item'         => __( 'Aggiorna Attore', 'twentythirteen' ),
        'search_items'        => __( 'Cerca Attore', 'twentythirteen' ),
        'not_found'           => __( 'Non trovato', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Non trovato in cestino', 'twentythirteen' ),
    );
          
    $args = array(
        'label'               => __( 'attori', 'twentythirteen' ),
        'description'         => __( 'CV degli attori', 'twentythirteen' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt',  
									   'thumbnail', 'revisions', 'custom-fields', ),

        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon'     	  => 'dashicons-id',
    );
     
    register_post_type( 'attori', $args );


 
}
 
/* Uso l'azione 'init' cosiccche la funzione che contiene la registrazione del CPT 
* non viene eseguito quando non necessario 
*/
 
add_action( 'init', 'custom_post_type_attori', 0 );


/*------------------------------------------------------------------------------------------------------------------------------ 
 META BOXES 
 ===============================================================================================================================
 Funzionamento:
 add_action("add_meta_boxes", nomeFunc) -> nomeFunc add_meta_box(id, titolo, markupFunction, posizione) -> markupFunction()
--------------------------------------------------------------------------------------------------------------------------------*/

/*** DETTAGLI FILM (durata, regia, anno produzione etc...) ***/
function add_dettagli_film_meta_box(){
	// Aggiungi un nuovo meta box
    add_meta_box("dettagli-meta-box", "Dettagli film", "dettagli_film_meta_box_markup", "produzioni", "side", "default", null);
}

// definisco contenuto del media box dettagli film
function dettagli_film_meta_box_markup($object){ 
	// Restituisco il  markup del meta box
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	?>
	<div>
		<label for="regia-film">Regia</label>
		<input class='widefat' name="regia-film" type="text" value="<?php echo get_post_meta($object->ID, "regia-film", true); ?>">
	</div>
	<div>
		<label for="durata-film">Durata (senza min)</label>
		<input name="durata-film" type="text" value="<?php echo get_post_meta($object->ID, "durata-film", true); ?>">&nbsp;Min.
	</div>
	<div>
		<label for="anno-film">Anno produzione (4 cifre)</label>
		<input name="anno-film" type="number" value="<?php echo get_post_meta($object->ID, "anno-film", true); ?>">
	</div>
	<div>
		<label for="lingua-film">Lingua</label>
		<input class='widefat' name="lingua-film" type="text" value="<?php echo get_post_meta($object->ID, "lingua-film", true); ?>">
	</div>
	<div>
		<label for="sottotitoli-film">Sottotitoli</label>
		<input class='widefat' name="sottotitoli-film" type="text" value="<?php echo get_post_meta($object->ID, "sottotitoli-film", true); ?>">
	</div>
	<div>
		<label for="limite-eta-film">Limite età</label>
		<input class='widefat' name="limite-eta-film" type="text" value="<?php echo get_post_meta($object->ID, "limite-eta-film", true); ?>">
	</div>
    <?php  
}

// eseguo action: aggiungi meta box a UI
add_action("add_meta_boxes", "add_dettagli_film_meta_box");



/* -------------------------------------- LINK VIDEO -----------------------------------------------------*/
function add_videolink_film_meta_box(){
	// Aggiungi un nuovo meta box
    add_meta_box("videolink-meta-box", "Link a video", "videolink_meta_box_markup", "produzioni", "side", "default", null);
}

function videolink_meta_box_markup($object){ 
	// Restituisci markup del meta box
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	$tipo_videolink = get_post_meta($object->ID, "tipo-videolink-film", true);
	if(empty($tipo_videolink)) $tipo_videolink = "Trailer";
	?>
	<div>
		<label for="tipo-videolink-film">Tipo video (Trailer, making of, etc)</label>
		<input class='widefat' name="tipo-videolink-film" type="text" value="<?php echo $tipo_videolink; ?>">
	</div>
	<div>
		<label for="durata-film">Incolla link (iframe) video</label>
		<textarea rows='5' class='widefat' name="videolink-film"><?php echo get_post_meta($object->ID, "videolink-film", true); ?></textarea>
	</div>
    <?php  
}

// Esegui action: aggiungi meta box al UI
add_action("add_meta_boxes", "add_videolink_film_meta_box");


/* -------------------------------------- ATTORI -----------------------------------------------------*/
function add_attori_film_meta_box(){
	// Aggiungi un nuovo meta box Attori
    add_meta_box("attori-meta-box", "Attori", "attori_meta_box_markup", "produzioni", "side", "default", null);
}

function attori_meta_box_markup($object){ 
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	$attori_selezionati = get_post_meta($object->ID, "attori-film", true);
	$elenco_attori = get_posts( array("post_type" => 'attori', "numberposts" => -1 ) );
	
	if($elenco_attori){
	?>
	<div>
		<label for="attori-film">Seleziona 1 o più attori</label>
		<select class='widefat' name="attori-film[]" multiple>	
			<option value="">&nbsp;</option>
	<?php		
		foreach($elenco_attori as $attore){			
			$selected = (in_array($attore->ID, $attori_selezionati)) ? "selected" : "";
			echo "<option value='".$attore->ID."' ".$selected.">".$attore->post_title."</option>\n";
		}
	?>
		</select>
	</div>
	<?php
	}else{
		echo "<p>Nessun attore trovato!<br>Vai nella sezione attori e crea una nuova scheda</p>";
	}
 
}

// Esegui action: aggingi meta box a UI
add_action("add_meta_boxes", "add_attori_film_meta_box");


/* -------------------------------------- LINK (SOCIAL) -----------------------------------------------------*/
function add_links_film_meta_box(){
    add_meta_box("links-meta-box", "Link / Social", "links_meta_box_markup", "produzioni", "side", "default", null);
}

function links_meta_box_markup($object){ 
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	?>
	<div>
		<label for="link-fb-film">Pagina Facebook</label>
		<input class='widefat' name="link-fb-film" type="text" value="<?php echo get_post_meta($object->ID, "link-fb-film", true); ?>">
	</div>
	<div>
		<label for="link-youtube-film">Canale Youtube</label>
		<input class='widefat' name="link-youtube-film" type="text" value="<?php echo get_post_meta($object->ID, "link-youtube-film", true); ?>">
	</div>
	<div>
		<label for="link-vimeo-film">Canale Vimeo</label>
		<input class='widefat' name="link-vimeo-film" type="text" value="<?php echo get_post_meta($object->ID, "link-vimeo-film", true); ?>">
	</div>
	<div>
		<label for="link-imdb-film">Pagina IMDb</label>
		<input class='widefat' name="link-imdb-film" type="text" value="<?php echo get_post_meta($object->ID, "link-imdb-film", true); ?>">
	</div>

	<div>
		<label for="name-link-1-film">Nome Link #1</label>
		<input class='widefat' name="name-link-1-film" type="text" value="<?php echo get_post_meta($object->ID, "name-link-1-film", true); ?>">
	</div>
	<div>
		<label for="link-1-film">Url Link #1</label>
		<input class='widefat' name="link-1-film" type="text" value="<?php echo get_post_meta($object->ID, "link-1-film", true); ?>">
	</div>

	<div>
		<label for="name-link-2-film">Nome Link #2</label>
		<input class='widefat' name="name-link-2-film" type="text" value="<?php echo get_post_meta($object->ID, "name-link-2-film", true); ?>">
	</div>
	<div>
		<label for="link-2-film">Url Link #2</label>
		<input class='widefat' name="link-2-film" type="text" value="<?php echo get_post_meta($object->ID, "link-2-film", true); ?>">
	</div>

	<div>
		<label for="name-link-3-film">Nome Link #3</label>
		<input class='widefat' name="name-link-3-film" type="text" value="<?php echo get_post_meta($object->ID, "name-link-3-film", true); ?>">
	</div>
	<div>
		<label for="link-3-film">Url Link #3</label>
		<input class='widefat' name="link-3-film" type="text" value="<?php echo get_post_meta($object->ID, "link-3-film", true); ?>">
	</div>
	<?php 
}

// esegui action: aggiungi meta box a UI
add_action("add_meta_boxes", "add_links_film_meta_box");



/* -------------------------------------- DISTRIBUTORE -----------------------------------------------------*/

function add_distributore_meta_box(){
	// Add a new meta box
    add_meta_box("distributore-meta-box", "Distributore", "distributore_meta_box_markup", "produzioni", "side", "default", null);
}

function distributore_meta_box_markup($object){
	
	$thumbnail = get_post_meta($object->ID, "logo-distributore-film", true);
	
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
	?>
	<div>
		<label for="nome-distributore-film">Nome Distributore</label>
		<input class='widefat' name="nome-distributore-film" type="text" value="<?php echo get_post_meta($object->ID, "nome-distributore-film", true); ?>">
	</div>
	<div>
		<label for="link-distributore-film">Link Distributore</label>
		<input class='widefat' name="link-distributore-film" type="text" value="<?php echo get_post_meta($object->ID, "link-distributore-film", true); ?>">
	</div>
	<div id="distributore-film-thumbnail">
	<?php
		if($thumbnail){
			echo wp_get_attachment_image($thumbnail);
		}
	?>
	</div>
	<input type="button" id="upload-logo-distributore" class="button" value="Carica Logo" />

	<input type="button" id="rimuovi-logo-distributore" class="button" value="&#215;" />

	<input type="hidden" id="logo-distributore-film" name="logo-distributore-film" value="<?php if ( isset ( $thumbnail ) ) echo $thumbnail; ?>" />

	<?php
}
add_action("add_meta_boxes", "add_distributore_meta_box");


// richiama script js che richiama gestore media e che imposta campo nascosto con id media e che inserisce miniatura in div anteprima
function enqueue_js_distributore(){
	
	global $typenow;

	if ( $typenow == 'produzioni') {

		wp_enqueue_media();

		// Registers and enqueues the required javascript.
		wp_register_script( 'produzioni-meta-box-image', get_stylesheet_directory_uri() . '/produzioni-images.js', array( 'jquery' ) );
		wp_enqueue_script( 'produzioni-meta-box-image' );
		wp_localize_script( 'produzioni-meta-box-image', 'meta_image',
			array(
				'title' => 'Seleziona a carica il logo del distributoree',
				'button' => 'Usa questa immagine',
			)
		);

	}
	
}

add_action( 'admin_enqueue_scripts', 'enqueue_js_distributore' ); // Accoda JavaScript


/*--- END META BOXES ------------------------------------------------------------------------ */


/*** SALVA DATI META BOX SU DB - LA FUNZIONE PUO' SLAVARE I VALORI DI DIVERI META BOX ***/
function save_dettagli_film_meta_box($post_id, $post, $update){
	
	// sE NESSUN nonce è stato inoltrato o il nonce è sbagliato interrompi ed esci
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

	// Se l'utente attuale non ha i permessi per editare interrompi ed esci
    if(!current_user_can("edit_post", $post_id))
        return $post_id;

	// Se è in atto un auto-salvataggio interrompi ed esci
    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;
	
	// Esegui solo se il post type è produzioni se no interrompi ed esci	
    $slug = "produzioni";
    if($slug != $post->post_type)
        return $post_id;
	
	/*************************************** 
	      CHECK, SANIFICA E SALVA VALORI 
	 ***************************************/
	
	/* DURATA ---------------------------------------------------------*/
    $durata = "";

    if(isset($_POST["durata-film"])){
        $durata = (string) trim($_POST["durata-film"]);
    }   	
    update_post_meta($post_id, "durata-film", $durata);
	
	/* REGIA ---------------------------------------------------------*/
    $regia = "";

    if(isset($_POST["regia-film"])){
        $regia = (string) trim($_POST["regia-film"]);
    }   	
    update_post_meta($post_id, "regia-film", $regia);
	
	/* ANNO ---------------------------------------------------------*/
    $anno = "";

    if(isset($_POST["anno-film"])){
        $anno = (int) $_POST["anno-film"];
    }   	
    update_post_meta($post_id, "anno-film", $anno);
	
	/* LINGUA ---------------------------------------------------------*/
    $lingua = "";

    if(isset($_POST["lingua-film"])){
        $lingua = (string) trim($_POST["lingua-film"]);
    }   	
    update_post_meta($post_id, "lingua-film", $lingua);
	
	/* SOTTOTITOLI ---------------------------------------------------------*/
    $sottotitoli = "";

    if(isset($_POST["sottotitoli-film"])){
        $sottotitoli = (string) trim($_POST["sottotitoli-film"]);
    }   	
    update_post_meta($post_id, "sottotitoli-film", $sottotitoli);
	
	/* LIMITE ETA' ---------------------------------------------------------*/
    $eta = "";

    if(isset($_POST["limite-eta-film"])){
        $eta = (string) trim($_POST["limite-eta-film"]);
    }   	
    update_post_meta($post_id, "limite-eta-film", $eta);
	
	/* TIPO LINK VIDEO ---------------------------------------------------------*/
    $tipo_videolink = "";

    if(isset($_POST["tipo-videolink-film"])){
        $tipo_videolink = (string) trim($_POST["tipo-videolink-film"]);
    }   	
    update_post_meta($post_id, "tipo-videolink-film", $tipo_videolink);
	
	/* LINK VIDEO ---------------------------------------------------------*/
    $videolink = "";

    if(isset($_POST["videolink-film"])){
        $videolink = (string) trim($_POST["videolink-film"]);
    }   	
    update_post_meta($post_id, "videolink-film", $videolink);
	
	/* ATTORI ---------------------------------------------------------*/
    $attori = "";

    if(isset($_POST["attori-film"])){
        $attori = $_POST["attori-film"];
    }   	
    update_post_meta($post_id, "attori-film", $attori);
	
	/* LINK FACEBOOK ---------------------------------------------------------*/
    $link_fb = "";

    if(isset($_POST["link-fb-film"])){
        $link_fb = (string) trim($_POST["link-fb-film"]);
    }   	
    update_post_meta($post_id, "link-fb-film", $link_fb);
	
	/* LINK YOUTUBE ---------------------------------------------------------*/
    $link_youtube = "";

    if(isset($_POST["link-youtube-film"])){
        $link_youtube = (string) trim($_POST["link-youtube-film"]);
    }   	
    update_post_meta($post_id, "link-youtube-film", $link_fb);
	
	/* LINK VIMEO ---------------------------------------------------------*/
    $link_vimeo = "";

    if(isset($_POST["link-vimeo-film"])){
        $link_vimeo = (string) trim($_POST["link-vimeo-film"]);
    }   	
    update_post_meta($post_id, "link-vimeo-film", $link_vimeo);
	
	/* LINK IMDB ---------------------------------------------------------*/
    $link_imdb = "";

    if(isset($_POST["link-imdb-film"])){
        $link_imdb = (string) trim($_POST["link-imdb-film"]);
    }   	
    update_post_meta($post_id, "link-imdb-film", $link_imdb);
	
	/* LINK #1 ---------------------------------------------------------*/
    $link_1 = $namelink_1 = "";

    if(isset($_POST["link-1-film"])){
        $link_1 = (string) trim($_POST["link-1-film"]);
    }   	
    update_post_meta($post_id, "link-1-film", $link_1);
	
    if(isset($_POST["name-link-1-film"])){
        $namelink_1 = (string) trim($_POST["name-link-1-film"]);
    }   	
    update_post_meta($post_id, "name-link-1-film", $namelink_1);
	
	/* LINK #2 ---------------------------------------------------------*/
    $link_2 = $namelink_2 = "";

    if(isset($_POST["link-2-film"])){
        $link_2 = (string) trim($_POST["link-2-film"]);
    }   	
    update_post_meta($post_id, "link-2-film", $link_2);
	
    if(isset($_POST["name-link-2-film"])){
        $namelink_2 = (string) trim($_POST["name-link-2-film"]);
    }   	
    update_post_meta($post_id, "name-link-2-film", $namelink_2);
	
	
	/* LINK #3 ---------------------------------------------------------*/
    $link_3 = $nomelink_3 = "";

    if(isset($_POST["link-3-film"])){
        $link_3 = (string) trim($_POST["link-3-film"]);
    }   	
    update_post_meta($post_id, "link-3-film", $link_3);
	
    if(isset($_POST["name-link-3-film"])){
        $namelink_3 = (string) trim($_POST["name-link-3-film"]);
    }   	
    update_post_meta($post_id, "name-link-3-film", $namelink_3);
	
	/* DISTRIBUTORE ---------------------------------------------------------*/
	// logo-distributore-film 
	// nome-distributore-film 
	// link-distributore-film
    $nome_distributore = $link_distributore = $logo_distributore = "";

    if(isset($_POST["nome-distributore-film"])){
        $nome_distributore = (string) trim($_POST["nome-distributore-film"]);
    }   	
    update_post_meta($post_id, "nome-distributore-film", $nome_distributore);
	
    if(isset($_POST["link-distributore-film"])){
        $link_distributore = (string) trim($_POST["link-distributore-film"]);
    }   	
    update_post_meta($post_id, "link-distributore-film", $link_distributore);
	
    if(isset($_POST["logo-distributore-film"])){
        $logo_distributore = (int) $_POST["logo-distributore-film"];
    }   	
    update_post_meta($post_id, "logo-distributore-film", $logo_distributore);
	
}

// SALVA DATI META BOX (Gli ultimi 2 parametri: priorità di esecuzione e il numero di argomenti che la funzione accetta)
add_action("save_post", "save_dettagli_film_meta_box", 10, 3);

?>