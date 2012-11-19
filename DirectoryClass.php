<?php

class DirectoryClass
{

	protected $filetracker_directories = '';

	public function process( )
	{
		parent::process( );
	}
	
	public function output(Smarty $smarty)
	{
	
		// Simulation array
		$this->filetracker_directories 	= $this->getTrackedDirectories();
		$filetrack_tree 		 		= $this->explodeTree($this->filetracker_directories, "/", true);
		
		$smarty->assign('filetrack_tree', $filetrack_tree);

		parent::output( $smarty );
	}

	public function getTrackedDirectories () {
		
			$this->filetracker_directories = array("c:/Images/MyImageFoler/",
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
												 "c:/Images/TESTING/MyImageFoler/August");

		return $this->filetracker_directories;
		
	}
	
	public function explodeTree($array, $delimiter = '/', $baseval = false)
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

		}
		
		
		return $returnArr;

	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>
