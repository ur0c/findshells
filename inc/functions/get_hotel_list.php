<?

function get_hotel_list ($hids, $list_id) {

	global $mysqli;
	
	$q = "SELECT hotel_name, h.id as id, c.name_de as city, r.name_de as region FROM tu_hotels h LEFT JOIN tu_geo_cities c ON h.city_id=c.id LEFT JOIN tu_geo_regions r ON h.region_id=r.id ";
	$q .= "WHERE h.inactive=0 AND h.id IN (" . $hids . ") ORDER BY FIELD(h.id, " . $hids . ")";
	$result = $mysqli->query($q) or die("Fehler");
	while ($row = $result->fetch_assoc()) {
		
			// user rating
			//$q = "SELECT hotel_rating FROM tu_user_hotel_rating WHERE user_id=".$user_id." AND hotel_id=".$row['id']." AND list_id=" . $list_id;
			$q = "SELECT hotel_rating FROM tu_user_hotel_rating WHERE hotel_id=".$row['id']." AND list_id=" . $list_id;
			$result_v = $mysqli->query($q) or die("Fehler");
			$row_v = $result_v->fetch_assoc();
						
        	// get affiliate
        	$aff = array();
        	$q = "SELECT * FROM tu_hotels_agency WHERE hotel_id=".$row['id']."";
			$result_af = $mysqli->query($q) or die("Fehler");
			while ($row_af = $result_af->fetch_assoc()) {
				if ($row_af['agency']=='booking.com') $aid = $row_af['agency_id'];
				$aff[] = array('name' => $row_af['agency'], 'link' => $row_af['affiliate_link']);
			}
			//if (empty($row_md['hotel_name'])) continue;
			
			// get request
        	$q = "SELECT * FROM tu_user_lists WHERE id=".$list_id."";
			$result_rid = $mysqli->query($q) or die("Fehler");
			$row_rid = $result_rid->fetch_assoc();
			
			
			// get price
			
			$prices = array();
			$last_price = 0;
			$last_price_update = 0;
        	$q = "SELECT *, UNIX_TIMESTAMP(change_date) as lc FROM tu_hotels_price WHERE ";
        	$q .= "hotel_id=".$row['id']." AND change_date>'".date("Y-m-d", time()-30*86400)."' AND request_id=" . $row_rid['request_id'] . " "; 
        	$q .= "ORDER BY change_date DESC";
			$result_pr = $mysqli->query($q) or die("Fehler");
			while ($row_pr = $result_pr->fetch_assoc()) {
				if (empty($last_price)) $last_price = $row_pr['price'];
				if (empty($last_price_update)) $last_price_update = $row_pr['lc'];
				$prices[$row_pr['change_date']] = $row_pr['price'];

			}
			
			
			// Get rating
			$rat = array();
			if(array_search('tui', array_column($aff, 'name')) !== false) {
				$q = "SELECT * FROM tu_hotels_rating WHERE hotel_id=".$row['id']." ORDER BY change_date DESC";
				$result_ra = $mysqli->query($q) or die("Fehler");
				if ($row_ra = $result_ra->fetch_assoc()) {
					$rat['tui']['rating'] = $row_ra['rating'];
					$rat['tui']['recommendation_rate'] = $row_ra['recommendation_rate'];
					$rat['tui']['rating_count'] = $row_ra['rating_count'];
				}
			}
			if(array_search('booking.com', array_column($aff, 'name')) !== false) {
				$rat['booking.com']['rating'] = '<ins class="bookingaff" data-aid="1320256" data-target_aid="" data-prod="rw" data-width="0" data-height="0" data-lang="de" data-show_rw_text="1" data-hid="'.$aid.'">
    				<!-- Anything inside will go away once widget is loaded. -->
    				<a href="//www.booking.com?aid=">Booking.com</a>
					</ins>';
			}
			if(array_search('google', array_column($aff, 'name')) !== false) {
				$q = "SELECT * FROM tu_hotels_rating WHERE hotel_id=".$row['id']." ORDER BY change_date DESC";
				$result_ra = $mysqli->query($q) or die("Fehler");
				if ($row_ra = $result_ra->fetch_assoc()) {
					$rat['google']['rating'] = $row_ra['rating'];
					$rat['google']['rating_count'] = $row_ra['rating_count'];
				}
			}			
			
			// Get last Hotel request
			$q = "SELECT MAX(UNIX_TIMESTAMP(request_time)) as hr FROM tu_hotels_requests WHERE hotel_id=".$row['id'];
			$result_hreq = $mysqli->query($q) or die("Fehler");
			$row_hreq = $result_hreq->fetch_assoc();
			
			$q = "SELECT hotel_id, count(*) as nr FROM tu_user_hotel_comments ";
			$q .= "WHERE user_id='" . $user_id . "' AND hotel_id IN (" . $hids . ") GROUP BY user_id, hotel_id";
			$result_com = $mysqli->query($q) or die("Fehler");
			while ($row_com = $result_com->fetch_assoc())  $comm_count['hotel' . $row_com['hotel_id']] = $row_com['nr'];
			
        	if (empty($row_md['thumbnail'])) $row_md['thumbnail'] = "/common-files/images/p_default_hotel.png";
        	else $row_md['thumbnail'] = "http://pics.tui.com/pics/pics400x225/" . $row_md['thumbnail'];
        	
        	
        	if (false && !file_exists("tui_images/" . $row['id'] . "jpg")) {
        		$img = file_get_contents($row_md['thumbnail']);
				$im = imagecreatefromstring($img);
				$width = imagesx($im);
				$height = imagesy($im);
				$aspect = 90/$width;
				$newwidth = '90';
				$newheight = (int)($height * $aspect);
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				imagejpeg($thumb,'tui_images/'.$row['id'].'.jpg'); //save image as jpg
				imagedestroy($thumb); 
				imagedestroy($im);
        	}
        	
        	// get images
        	$q = "SELECT * FROM tu_hotels_google_images WHERE hotel_id=".$row['id']." ORDER BY id LIMIT 1";
        	//echo $q . "<br>";
        	$result_img = $mysqli->query($q) or die("Fehler");
        	if ($row_img = $result_img->fetch_assoc()) 
        		$img = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=90&photoreference=".$row_img['reference']."&sensor=false&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
        	else {
        		// versuchen Fotoreferenz zu holen
        		$res = googe_get_detail($row['id']);
        		
        		for ($i=0; $i<count($res['photos']); $i++) {
        			$q_img = "INSERT INTO tu_hotels_google_images (insert_date, hotel_id, reference, width, height) VALUES (NOW(), ".$row['id'].", '".$res['photos'][$i]['photo_reference']."', '".$res['photos'][$i]['width']."', '".$res['photos'][$i]['height']."')";
        			$mysqli->query($q_img) or die("Fehler");
				}
				if ($i>0) $img = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=90&photoreference=".$res['photos'][0]['photo_reference']."&sensor=false&key=AIzaSyA4iGEoDD1B9ynK2gYERZWV9ExPjzuahaU";
        		else $img = "/tui_images/default.png";
        	}
        	
        	$h[$row['id']]['id'] = $row['id'];
        	$h[$row['id']]['giata_id'] = $row['giata_id'];
        	$h[$row['id']]['hotel_name'] = $row['hotel_name'];
        	$h[$row['id']]['region'] = htmlspecialchars($row['region']);
        	$h[$row['id']]['city'] = htmlspecialchars($row['city']);
        	$h[$row['id']]['affiliate_link'] = $row_af['affiliate_link'];
        	$h[$row['id']]['affiliate'] = $aff;
        	$h[$row['id']]['img'] = $img;
        	
        	$h[$row['id']]['tui_category'] = $row_md['tui_category'];
        	$h[$row['id']]['last_price'] = $last_price;
        	$h[$row['id']]['rating'] = $rat;
        	$h[$row['id']]['prices'] = implode(",", array_reverse($prices));
        	$h[$row['id']]['last_price_update'] = $last_price_update;
        	$h[$row['id']]['hotel_rating'] = $row_v['hotel_rating'];
        	isset($comm_count['hotel' . $row['id']]) ? $h[$row['id']]['comm_count'] = (int)$comm_count['hotel' . $row['id']] : $h[$row['id']]['comm_count'] = 0;;
        	$h[$row['id']]['rating_count'] = $row_ra['rating_count'];
        	$h[$row['id']]['last_request'] = $row_hreq['hr'];
        	
        	$h[$row['id']]['req_start'] = $row_rid['date_start'];
        	$h[$row['id']]['req_end'] = $row_rid['date_end'];
        	$h[$row['id']]['req_children'] = $row_rid['ages_kids'];
        	
        
        }
	
	
		return $h;

}


?>