<?php
/**
 * sfResizedFile represents a resized uploaded file.
 *
 * @package    symfony
 * @subpackage validator
 * @author     Malas
 * @version    0.1
 */
class sfResizedFile extends sfValidatedFile
{

	/**
	 * Saves the uploaded file.
	 *
	 * This method can throw exceptions if there is a problem when saving the file.
	 *
	 * If you don't pass a file name, it will be generated by the generateFilename method.
	 * This will only work if you have passed a path when initializing this instance.
	 *
	 * @param  string $file      The file path to save the file
	 * @param  int    $fileMode  The octal mode to use for the new file
	 * @param  bool   $create    Indicates that we should make the directory before moving the file
	 * @param  int    $dirMode   The octal mode to use when creating the directory
	 *
	 * @return string The filename without the $this->path prefix
	 *
	 * @throws Exception
	 */
	
	public function save($file = null, $fileMode = 0666, $create = true, $dirMode = 0777)
	{
		if (is_null($file))
		{
			$file = $this->generateFilename();
		}

		if ($file[0] != '/' && $file[0] != '\\' && !(strlen($file) > 3 && ctype_alpha($file[0]) && $file[1] == ':' && ($file[2] == '\\' || $file[2] == '/')))
		{
			if (is_null($this->path))
			{
				throw new RuntimeException('You must give a "path" when you give a relative file name.');
			}

			$smallFile = $this->path.DIRECTORY_SEPARATOR.'s_'.$file;
			$mediumFile = $this->path.DIRECTORY_SEPARATOR.'m_'.$file;
			$file = $this->path.DIRECTORY_SEPARATOR.$file;
		}

		// get our directory path from the destination filename
		$directory = dirname($file);
		if (!is_readable($directory))
		{
			if ($create && !mkdir($directory, $dirMode, true))
			{
				// failed to create the directory
				throw new Exception(sprintf('Failed to create file upload directory "%s".', $directory));
			}

			// chmod the directory since it doesn't seem to work on recursive paths
			chmod($directory, $dirMode);
		}
		if (!is_dir($directory))
		{
			// the directory path exists but it's not a directory
			throw new Exception(sprintf('File upload path "%s" exists, but is not a directory.', $directory));
		}
		if (!is_writable($directory))
		{
			// the directory isn't writable
			throw new Exception(sprintf('File upload path "%s" is not writable.', $directory));
		}

		
		
		// obtengo el nombre del modulo segun el path
		$nombre_path = explode("/",$this->path);
		$modulo = sfContext::getInstance()->getRequest()->getParameter('module');
		
		
		// si encuentra el alto y ancho normal en app.yml los define, sino define el default 
		if (sfConfig::get('app_thumbnail_normal_width_'.$modulo) && sfConfig::get('app_thumbnail_normal_height_'.$modulo))
		{
			$thumbnail_width  = sfConfig::get('app_thumbnail_normal_width_'.$modulo);
			$thumbnail_height = sfConfig::get('app_thumbnail_normal_height_'.$modulo);			
		}
		else 
		{
			$thumbnail_width  = sfConfig::get('app_thumbnail_normal_width_default');
			$thumbnail_height = sfConfig::get('app_thumbnail_normal_height_default');
		}
				
		$thumbnail = new sfThumbnail($thumbnail_width, $thumbnail_height, true, true, 85);
		$thumbnail->loadFile($this->getTempName());
		$thumbnail->save($file, 'image/jpeg');
		
		
		// si encuentra el alto y ancho small en app.yml los define, sino no lo crea
		if (sfConfig::get('app_thumbnail_small_width_'.$modulo) && sfConfig::get('app_thumbnail_small_height_'.$modulo))
		{
			$thumbnail_width  = sfConfig::get('app_thumbnail_small_width_'.$modulo);
			$thumbnail_height = sfConfig::get('app_thumbnail_small_height_'.$modulo);
			
			$thumbnail = new sfThumbnail($thumbnail_width, $thumbnail_height, true, true, 85);
			$thumbnail->loadFile($this->getTempName());
			$thumbnail->save($smallFile, 'image/jpeg');
			
		}

		
		// si encuentra el alto y ancho medium en app.yml los define, sino no lo crea
		if (sfConfig::get('app_thumbnail_medium_width_'.$modulo) && sfConfig::get('app_thumbnail_medium_height_'.$modulo))
		{
			$thumbnail_width  = sfConfig::get('app_thumbnail_medium_width_'.$modulo);
			$thumbnail_height = sfConfig::get('app_thumbnail_medium_height_'.$modulo);
			
			$thumbnail = new sfThumbnail($thumbnail_width, $thumbnail_height, true, true, 85);
			$thumbnail->loadFile($this->getTempName());
			$thumbnail->save($mediumFile, 'image/jpeg');
		}
		
		

		// chmod our file
		if (!empty($smallFile)) { if (file_exists($smallFile)) { chmod($smallFile, $fileMode); }}
		if (!empty($file)) {if (file_exists($file)) { chmod($file, $fileMode); } }

		$this->savedName = $file;
		return is_null($this->path) ? $file : str_replace($this->path.DIRECTORY_SEPARATOR, '', $file);
	}

}
?>