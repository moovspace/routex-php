<?php
namespace App\Core\Img;

class FileInfo
{
	/**
	 * GetExtension
	 * Get file extension
	 *
	 * @param string $path Set path to file
	 * @return string Return file extension
	 */
	function GetExtension($path){
		return strtolower(pathinfo(basename($path), PATHINFO_EXTENSION));
	}

	/**
	 * GetName
	 * Get file name
	 *
	 * @param string $path Set path to file
	 * @return string Return file name without extensions
	 */
	function GetFileName($path, $tolower = 1)
	{
		if($tolower == 1){
			return strtolower(pathinfo(basename($path), PATHINFO_FILENAME));
		}else{
			return pathinfo(basename($path), PATHINFO_FILENAME);
		}
	}

	/**
	 * GetDirectory function
	 *
	 * @param string $path File path
	 * @return string Directory path (/path/to/file/directory)
	 */
	function GetDirectory($path)
	{
		return pathinfo($path, PATHINFO_DIRNAME);
	}

	/**
	 * GetInfo function
	 *
	 * Get file info array
	 * @param string $path File path
	 * @return array File info array
	 */
	function GetInfo($path)
	{
		return getimagesize($path);
	}

	/**
	 * GetMime function
	 *
	 * Get file mime type
	 * @param string $path File path
	 * @return string Mime type (e.g. image/jpeg)
	 */
	function GetMime($path)
	{
		$file = $this->GetInfo($path);
		return $file['mime'];
	}
}
?>
