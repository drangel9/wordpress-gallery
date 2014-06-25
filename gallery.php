<?php
  //Gallery starts with no filter
  $destination_filter = "no filter";
						if($_SERVER['REQUEST_METHOD']=="POST"){
							$destination_filter = $_POST["Destinations"];
						}
						?>
						<header class='entry-header'>
						<h1 class='entry-title'>Gallery</h1>
					</header>
						<div class="entry-content">
						<p>Here are all the photos we have taken thus far.  You can filter our photos below by destination.</p></div>
						<form method="post">
						<select class = 'content-filter' name="Destinations">
						<option selected="selected" disabled="disabled">Add Filter...</option>
						<option value="no filter">No Filter</option>
						<option value="cambodia">Cambodia</option>
						<option value="china">China</option>
						<option value="japan-2">Japan</option>
						<option value="malaysia">Malaysia</option>
						<option value="mexico-city">Mexico City</option>
						<option value="south-korea">South Korea</option>
						<option value="vietnam-2">Vietnam</option>
						
						</select>
						<input type = "submit" value = "Filter">
						</form>
						<?php
						$args = array(
						   'post_type' => 'post'
						);
            //If filter is applied, only display those photos
						if($destination_filter!="no filter"){
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$args = array(
								'category_name'=>$destination_filter,
								'posts_per_page'    => 10,
								'paged'			=> $paged,	);
						$content = get_posts($args);
						$gallery_shortcode = '[gallery ids="';
						foreach($content as $item){
							$media = get_attached_media('image',$item->ID);
							foreach($media as $image){
								$img_id = $image->ID;
								$gallery_shortcode = $gallery_shortcode . $img_id . ',';
								
							}

						}
						$gallery_shortcode = rtrim($gallery_shortcode,',');
						$gallery_shortcode = $gallery_shortcode . '"]';

						echo do_shortcode($gallery_shortcode);
						
						}
						else{
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							$args = array(
									'paged'				=> $paged,
									'posts_per_page'    => 50,
									);
							$content = get_posts($args);
							$gallery_shortcode = '[gallery ids="';
						foreach($content as $item){
							$media = get_attached_media('image',$item->ID);
							foreach($media as $image){
								
								$img_id = $image->ID;
								$gallery_shortcode = $gallery_shortcode . $img_id . ',';
							}
							setup_postdata($item);
						}
						$gallery_shortcode = rtrim($gallery_shortcode,',');
						$gallery_shortcode = $gallery_shortcode . '"]';

						echo do_shortcode($gallery_shortcode);
						}
?>
