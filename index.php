<html>
	<head>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="css/hot-sneaks/jquery-ui-1.9.1.custom.css" rel="stylesheet">
	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery-ui-1.9.1.custom.js"></script>
	</head>
	
	
<body>

<script>
		
        $(document).ready(function () {
		
		
			$('.togglebutton').click( function() {
			
				$(this).parent().children("div").toggle();
				
				$(this).children(".icon").toggleClass("icon-folder-open").toggleClass("icon-folder-close");
				
				if ($(this).children("img").attr("src") == 'img/expand.png') {
				
					$(this).children("img").attr("src", "img/collapse.png");
				}
				else {
					$(this).children("img").attr("src", "img/expand.png");
					
				}
				
			});
				
		});
					
</script>


<style>
	.dir {
		margin-left:10px;
	}
	
	.node {
		font-size:12px;
	}
	

	.node a:hover {
		font-weight:bold;
		text-decoration:none;
	}
	
	.active {
		font-weight:bold;
	}
</style>

<?php
	error_reporting(0);
	
	$key_files = array(
	
	"c:/Images/MyImageFoler/",
	 "c:/Images/TESTING/MyImageFoler"=>,
	 "c:/Images/TESTING/MyImageFoler/January/Trip1",
	 "c:/Images/TESTING/MyImageFoler/February/Trip2/TestFolder",
	 "c:/Images/TESTING/MyImageFoler/March/Trip1",
	 "c:/Images/TESTING/MyImageFoler/March/SampleFiles/",
	 "c:/Images/TESTING/MyImageFoler/March/SampleFiles/Trip1",
	 "c:/Images/TESTING/MyImageFoler/April/SampleFiles/Trip1",
	 "c:/Images/TESTING/MyImageFoler/May/SampleFiles/Trip/Trip1/",
	 "c:/Images/TESTING/MyImageFoler/June",
	 "c:/Images/TESTING/MyImageFoler/July",
	 "c:/Images/TESTING/MyImageFoler/August",


  );

function plotTree($arr, $indent=0, $active){
	

    foreach($arr as $k => $v){
        // skip the baseval thingy. Not a real node.
        if($k == "__base_val") {
		}
		else {
			// determine the real value of this node.
			
			$show_val = ( is_array($v) ? $v["__base_val"] : $v );
			

			// show the indents
			
			if($indent == 0){
				// this is a root node. no parents
			} elseif(is_array($v)){
				// this is a normal node. parents and children
				echo "<div style=' padding-left: " . $indent . "px; margin-left: 0px' class='node'>
					  <a href='#' onclick='return false;' class='togglebutton'> <img src='img/collapse.png'><i class='icon icon-folder-open'></i></a> ";
			} else{
				// this is a leaf node. no children
					$sub_indent = $indent + 8;
					echo "<div style='border-left:none; padding-left: " . $indent . "px; margin-left: 0px'><img src='img/spacer.png'><i class='icon icon-folder-close'></i> ";
			}
			// show the actual node
			//echo $k . " - " . $active;

			if (($show_val != $active) || ($show_val == "")){
				echo "<a href='http://localhost/directory/index.php?n=" . $show_val ."'>" . $k . "</a>";
			}
			else {
				echo "<a href='http://localhost/directory/index.php?n=" . $show_val ."' class='active'>" . $k . "</a>";
			}
			
			if(is_array($v)){
			
				echo sizeof($v);
				// this is what makes it recursive, rerun for children
				plotTree($v, ($indent), $active);
				echo "</div>";
				
				
			}
			else {
				echo "</div>";
			}
		}
    }

}
function explodeTree($array, $delimiter = '_', $baseval = false)
{
    if(!is_array($array)) return false;
    $splitRE   = '/' . preg_quote($delimiter, '/') . '/';
    $returnArr = array();
    foreach ($array as $key => $val) {
        // Get parent parts and the current leaf
        $parts    = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
        $leafPart = array_pop($parts);

        // Build parent structure 
        // Might be slow for really deep and large structures
        $parentArr = &$returnArr;
        foreach ($parts as $part) {
            if (!isset($parentArr[$part])) {
                $parentArr[$part] = array();
            } elseif (!is_array($parentArr[$part])) {
                if ($baseval) {
                    $parentArr[$part] = array('__base_val' => $parentArr[$part]);
                } else {
                    $parentArr[$part] = array();
                }
            }
            $parentArr = &$parentArr[$part];
        }

        // Add the final part to the structure
        if (empty($parentArr[$leafPart])) {
            $parentArr[$leafPart] = $val;
        } elseif ($baseval && is_array($parentArr[$leafPart])) {
            $parentArr[$leafPart]['__base_val'] = $val;
        }
    }
    return $returnArr;
}


$tree = explodeTree($key_files, "/", true);


echo "<pre>";
print_r($tree);
echo "</pre>";

?>
<div style="border:1px solid #D6D6D6; width:400px; margin:20px; overflow:auto; padding:10px;">
	<div style="width:100%;">
	<?php
		$active = (@$_GET['n'] == "") ? "" : $_GET['n'];

		plotTree($tree, 18, $active);
	?>
	</div>
</div>



</body>

</head>

