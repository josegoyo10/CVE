<?php
/***********************************************************************
** Title.........:  Image Transformation Interface
** Version.......:  1.0
** Author........:  Xiang Wei ZHUO <wei@zhuo.org>
** Filename......:  Transform.php
** Last changed..:  30 Aug 2003 
** Notes.........:  Orginal is from PEAR
                    
                    Added a few extra,
                        - create unique filename in a particular directory,
                          used for temp image files.
                        - added cropping to GD, NetPBM, ImageMagick
**/

// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Peter Bowyer <peter@mapledesign.co.uk>                      |
// |          Alan Knowles <alan@akbkhome.com>                            |
// |          Vincent Oostindie <vincent@sunlight.tmfweb.nl>              |
// +----------------------------------------------------------------------+
//
// $Id: Transform.php 26 2004-03-31 02:35:21Z Wei Zhuo $
//
// Image Transformation interface
//


/**
 * The main "Image_Resize" class is a container and base class which
 * provides the static methods for creating Image objects as well as
 * some utility functions (maths) common to all parts of Image Resize.
 *
 * The object model of DB is as follows (indentation means inheritance):
 *
 * Image_Resize The base for each Image implementation.  Provides default
 * |            implementations (in OO lingo virtual methods) for
 * |            the actual Image implementations as well as a bunch of
 * |            maths methods.
 * |
 * +-Image_GD   The Image implementation for the PHP GD extension .  Inherits
 *              Image_Resize
 *              When calling DB::setup for GD images the object returned is an
 *              instance of this class.
 *
 * @package  Image Resize
 * @version  1.00
 * @author   Peter Bowyer <peter@mapledesign.co.uk>
 * @since    PHP 4.0
 */
Class Image_Transform
{
    /**
     * Name of the image file
     * @var string
     */
    var $image = '';
    /**
     * Type of the image file (eg. jpg, gif png ...)
     * @var string
     */
    var $type = '';
    /**
     * Original image width in x direction
     * @var int
     */
    var $img_x = '';
    /**
     * Original image width in y direction
     * @var int
     */
    var $img_y = '';
    /**
     * New image width in x direction
     * @var int
     */
    var $new_x = '';
    /**
     * New image width in y direction
     * @var int
     */
    var $new_y = '';
    /**
     * Path the the library used
     * e.g. /usr/local/ImageMagick/bin/ or
     * /usr/local/netpbm/
     */
    var $lib_path = '';
    /**
     * Flag to warn if image has been resized more than once before displaying
     * or saving.
     */
     var $resized = false;


     var $uid = '';

     var $lapse_time =900; //15 mins

    /**
     * Create a new Image_resize object
     *
     * @param string $driver name of driver class to initialize
     *
     * @return mixed a newly created Image_Transform object, or a PEAR
     * error object on error
     *
     * @see PEAR::isError()
     * @see Image_Transform::setOption()
     */
    function &factory($driver)
    {
        global $mosConfig_absolute_path;
        if ('' == $driver) {
            die("No image library specified... aborting.  You must call ::factory() with one parameter, the library to load.");

        }
        $this->uid = md5($_SERVER['REMOTE_ADDR']);

        include_once "$mosConfig_absolute_path/mambots/editors/tinymce_exp/jscripts/tiny_mce/plugins/imgmanager/ImageManager/Classes/$driver.php";

        $classname = "Image_Transform_Driver_{$driver}";
        $obj =& new $classname;
        return $obj;
    }


    /**
     * Resize the Image in the X and/or Y direction
     * If either is 0 it will be scaled proportionally
     *
     * @access public
     *
     * @param mixed $new_x (0, number, percentage 10% or 0.1)
     * @param mixed $new_y (0, number, percentage 10% or 0.1)
     *
     * @return mixed none or PEAR_error
     */
    function resize($new_x = 0, $new_y = 0)
    {
        // 0 means keep original size
        $new_x = (0 == $new_x) ? $this->img_x : $this->_parse_size($new_x, $this->img_x);
        $new_y = (0 == $new_y) ? $this->img_y : $this->_parse_size($new_y, $this->img_y);
        // Now do the library specific resizing.
        return $this->_resize($new_x, $new_y);
    } // End resize


    /**
     * Scale the image to have the max x dimension specified.
     *
     * @param int $new_x Size to scale X-dimension to
     * @return none
     */
    function scaleMaxX($new_x)
    {
        $new_y = round(($new_x / $this->img_x) * $this->img_y, 0);
        return $this->_resize($new_x, $new_y);
    } // End resizeX

    /**
     * Scale the image to have the max y dimension specified.
     *
     * @access public
     * @param int $new_y Size to scale Y-dimension to
     * @return none
     */
    function scaleMaxY($new_y)
    {
        $new_x = round(($new_y / $this->img_y) * $this->img_x, 0);
        return $this->_resize($new_x, $new_y);
    } // End resizeY

    /**
     * Scale Image to a maximum or percentage
     *
     * @access public
     * @param mixed (number, percentage 10% or 0.1)
     * @return mixed none or PEAR_error
     */
    function scale($size)
    {
        if ((strlen($size) > 1) && (substr($size,-1) == '%')) {
            return $this->scaleByPercentage(substr($size, 0, -1));
        } elseif ($size < 1) {
            return $this->scaleByFactor($size);
        } else {
            return $this->scaleByLength($size);
        }
    } // End scale

    /**
     * Scales an image to a percentage of its original size.  For example, if
     * my image was 640x480 and I called scaleByPercentage(10) then the image
     * would be resized to 64x48
     *
     * @access public
     * @param int $size Percentage of original size to scale to
     * @return none
     */
    function scaleByPercentage($size)
    {
        return $this->scaleByFactor($size / 100);
    } // End scaleByPercentage

    /**
     * Scales an image to a factor of its original size.  For example, if
     * my image was 640x480 and I called scaleByFactor(0.5) then the image
     * would be resized to 320x240.
     *
     * @access public
     * @param float $size Factor of original size to scale to
     * @return none
     */
    function scaleByFactor($size)
    {
        $new_x = round($size * $this->img_x, 0);
        $new_y = round($size * $this->img_y, 0);
        return $this->_resize($new_x, $new_y);
    } // End scaleByFactor

    /**
     * Scales an image so that the longest side has this dimension.
     *
     * @access public
     * @param int $size Max dimension in pixels
     * @return none
     */
    function scaleByLength($size)
    {
         if ($this->img_x >= $this->img_y) {
            $new_x = $size;
            $new_y = round(($new_x / $this->img_x) * $this->img_y, 0);
        } else {
            $new_y = $size;
            $new_x = round(($new_y / $this->img_y) * $this->img_x, 0);
        }
        return $this->_resize($new_x, $new_y);
    } // End scaleByLength


    /**
     *
     * @access public
     * @return void
     */
    function _get_image_details($image)
    {
        //echo $image;
        $data = @GetImageSize($image);
        #1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order,
        # 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC
        if (is_array($data)){
            switch($data[2]){
                case 1:
                    $type = 'gif';
                    break;
                case 2:
                    $type = 'jpeg';
                    break;
                case 3:
                    $type = 'png';
                    break;
                case 4:
                    $type = 'swf';
                    break;
                case 5:
                    $type = 'psd';
                case 6:
                    $type = 'bmp';
                case 7:
                case 8:
                    $type = 'tiff';
                default:
                    echo("We do not recognize this image format");
            }
            $this->img_x = $data[0];
            $this->img_y = $data[1];
            $this->type = $type;

            return true;
        } else {
            echo("Cannot fetch image or images details.");
            return null;
        }
        /*
        $output = array(
                        'width' => $data[0],
                        'height' => $data[1],
                        'type' => $type
                        );
        return $output;
        */
    }


    /**
     * Parse input and convert
     * If either is 0 it will be scaled proportionally
     *
     * @access private
     *
     * @param mixed $new_size (0, number, percentage 10% or 0.1)
     * @param int $old_size
     *
     * @return mixed none or PEAR_error
     */
    function _parse_size($new_size, $old_size)
    {
        if ('%' == $new_size) {
            $new_size = str_replace('%','',$new_size);
            $new_size = $new_size / 100;
        }
        if ($new_size > 1) {
            return (int) $new_size;
        } elseif ($new_size == 0) {
            return (int) $old_size;
        } else {
            return (int) round($new_size * $old_size, 0);
        }
    }


    function uniqueStr()
    {
      return substr(md5(microtime()),0,6);
    }

    //delete old tmp files, and allow only 1 file per remote host.
    function cleanUp($id, $dir)
    {
        $d = dir($dir);
        $id_length = strlen($id);

        while (false !== ($entry = $d->read())) {
            if (is_file($dir.'/'.$entry) && substr($entry,0,1) == '.' && !ereg($entry, $this->image))
            {
                //echo filemtime($this->directory.'/'.$entry)."<br>"; 
                //echo time();

                if (filemtime($dir.'/'.$entry) + $this->lapse_time < time())
                    unlink($dir.'/'.$entry);

                if (substr($entry, 1, $id_length) == $id)
                {
                    if (is_file($dir.'/'.$entry))
                        unlink($dir.'/'.$entry);
                }
            }
        }
        $d->close();
    }


    function createUnique($dir)
    {
       $unique_str = '.'.$this->uid.'_'.$this->uniqueStr().".".$this->type;
        
       //make sure the the unique temp file does not exists
        while (file_exists($dir.$unique_str))
        {
            $unique_str = '.'.$this->uid.'_'.$this->uniqueStr().".".$this->type;
        }
        
      $this->cleanUp($this->uid, $dir);

       return $unique_str;
    }


    /**
     * Set the image width
     * @param int $size dimension to set
     * @since 29/05/02 13:36:31
     * @return
     */
    function _set_img_x($size)
    {
        $this->img_x = $size;
    }

    /**
     * Set the image height
     * @param int $size dimension to set
     * @since 29/05/02 13:36:31
     * @return
     */
    function _set_img_y($size)
    {
        $this->img_y = $size;
    }

    /**
     * Set the image width
     * @param int $size dimension to set
     * @since 29/05/02 13:36:31
     * @return
     */
    function _set_new_x($size)
    {
        $this->new_x = $size;
    }

    /**
     * Set the image height
     * @param int $size dimension to set
     * @since 29/05/02 13:36:31
     * @return
     */
    function _set_new_y($size)
    {
        $this->new_y = $size;
    }

    /**
     * Get the type of the image being manipulated
     *
     * @return string $this->type the image type
     */
    function getImageType()
    {
        return $this->type;
    }

    /**
     *
     * @access public
     * @return string web-safe image type
     */
    function getWebSafeFormat()
    {
        switch($this->type){
            case 'gif':
            case 'png':
                return 'png';
                break;
            default:
                return 'jpeg';
        } // switch
    }

    /**
     * Place holder for the real resize method
     * used by extended methods to do the resizing
     *
     * @access private
     * @return PEAR_error
     */
    function _resize() {
        return null; //PEAR::raiseError("No Resize method exists", true);
    }

    /**
     * Place holder for the real load method
     * used by extended methods to do the resizing
     *
     * @access public
     * @return PEAR_error
     */
    function load($filename) {
        return null; //PEAR::raiseError("No Load method exists", true);
    }

    /**
     * Place holder for the real display method
     * used by extended methods to do the resizing
     *
     * @access public
     * @param string filename
     * @return PEAR_error
     */
    function display($type, $quality) {
        return null; //PEAR::raiseError("No Display method exists", true);
    }

    /**
     * Place holder for the real save method
     * used by extended methods to do the resizing
     *
     * @access public
     * @param string filename
     * @return PEAR_error
     */
    function save($filename, $type, $quality) {
        return null; //PEAR::raiseError("No Save method exists", true);
    }

    /**
     * Place holder for the real free method
     * used by extended methods to do the resizing
     *
     * @access public
     * @return PEAR_error
     */
    function free() {
        return null; //PEAR::raiseError("No Free method exists", true);
    }

    /**
     * Reverse of rgb2colorname.
     *
     * @access public
     * @return PEAR_error
     *
     * @see rgb2colorname
     */
    function colorhex2colorarray($colorhex) {
        $r = hexdec(substr($colorhex, 1, 2));
        $g = hexdec(substr($colorhex, 3, 2));
        $b = hexdec(substr($colorhex, 4, 2));
        return array($r,$g,$b);
    }

    /**
     * Reverse of rgb2colorname.
     *
     * @access public
     * @return PEAR_error
     *
     * @see rgb2colorname
     */
    function colorarray2colorhex($color) {
        $color = '#'.dechex($color[0]).dechex($color[1]).dechex($color[2]);
        return strlen($color)>6?false:$color;
    }


    /* Methods to add to the driver classes in the future */
    function addText()
    {
        return null; //PEAR::raiseError("No addText method exists", true);
    }

    function addDropShadow()
    {
        return null; //PEAR::raiseError("No AddDropShadow method exists", true);
    }

    function addBorder()
    {
        return null; //PEAR::raiseError("No addBorder method exists", true);
    }

    function crop()
    {
        return null; //PEAR::raiseError("No crop method exists", true);
    }

    function flip() 
    {
        return null;
    }

    function gamma()
    {
        return null; //PEAR::raiseError("No gamma method exists", true);
    }
}

/**
 * File Utilities.
 * @author $Author: Wei Zhuo $
 * @version $Id: Files.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 */

define('FILE_ERROR_NO_SOURCE', 100);
define('FILE_ERROR_COPY_FAILED', 101);
define('FILE_ERROR_DST_DIR_FAILED', 102);
define('FILE_COPY_OK', 103);

/**
 * File Utilities
 * @author $Author: Wei Zhuo $
 * @version $Id: Files.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 * @subpackage files
 */
class Files
{

	/**
	 * Copy a file from source to destination. If unique == true, then if
	 * the destination exists, it will be renamed by appending an increamenting
	 * counting number.
	 * @param string $source where the file is from, full path to the files required
	 * @param string $destination_file name of the new file, just the filename
	 * @param string $destination_dir where the files, just the destination dir,
	 * e.g., /www/html/gallery/
	 * @param boolean $unique create unique destination file if true.
	 * @return string the new copied filename, else error if anything goes bad.
	 */
	function copyFile($source, $destination_dir, $destination_file, $unique=true)
	{
		if(!(file_exists($source) && is_file($source)))
			return FILE_ERROR_NO_SOURCE;

		$destination_dir = Files::fixPath($destination_dir);

		if(!is_dir($destination_dir))
			Return FILE_ERROR_DST_DIR_FAILED;

		$filename = Files::escape($destination_file);

		if($unique)
		{
			$dotIndex = strrpos($destination_file, '.');
			$ext = '';
			if(is_int($dotIndex))
			{
				$ext = substr($destination_file, $dotIndex);
				$base = substr($destination_file, 0, $dotIndex);
			}
			$counter = 0;
			while(is_file($destination_dir.$filename))
			{
				$counter++;
				$filename = $base.'_'.$counter.$ext;
			}
		}

		if (!copy($source, $destination_dir.$filename))
			return FILE_ERROR_COPY_FAILED;

		//verify that it copied, new file must exists
		if (is_file($destination_dir.$filename))
			Return $filename;
		else
			return FILE_ERROR_COPY_FAILED;
	}

	/**
	 * Create a new folder.
	 * @param string $newFolder specifiy the full path of the new folder.
	 * @return boolean true if the new folder is created, false otherwise.
	 */
	function createFolder($newFolder)
	{
		mkdir ($newFolder, 0777);
		return chmod($newFolder, 0777);
	}


	/**
	 * Escape the filenames, any non-word characters will be
	 * replaced by an underscore.
	 * @param string $filename the orginal filename
	 * @return string the escaped safe filename
	 */
	function escape($filename)
	{
		Return preg_replace('/[^\w\._]/', '_', $filename);
	}

	/**
	 * Delete a file.
	 * @param string $file file to be deleted
	 * @return boolean true if deleted, false otherwise.
	 */
	function delFile($file)
	{
		if(is_file($file))
			Return unlink($file);
		else
			Return false;
	}

	/**
	 * Delete folder(s), can delete recursively.
	 * @param string $folder the folder to be deleted.
	 * @param boolean $recursive if true, all files and sub-directories
	 * are delete. If false, tries to delete the folder, can throw
	 * error if the directory is not empty.
	 * @return boolean true if deleted.
	 */
	function delFolder($folder, $recursive=false)
	{
		$deleted = true;
		if($recursive)
		{
			$d = dir($folder);
			while (false !== ($entry = $d->read()))
			{
				if ($entry != '.' && $entry != '..')
				{
					$obj = Files::fixPath($folder).$entry;
					//var_dump($obj);
					if (is_file($obj))
					{
						$deleted &= Files::delFile($obj);
					}
					else if(is_dir($obj))
					{
						$deleted &= Files::delFolder($obj, $recursive);
					}

				}
			}
			$d->close();

		}

		//$folder= $folder.'/thumbs';
		//var_dump($folder);
		if(is_dir($folder))
			$deleted &= rmdir($folder);
		else
			$deleted &= false;

		Return $deleted;
	}

	/**
	 * Append a / to the path if required.
	 * @param string $path the path
	 * @return string path with trailing /
	 */
	function fixPath($path)
	{
		//append a slash to the path if it doesn't exists.
		if(!(substr($path,-1) == '/'))
			$path .= '/';
		Return $path;
	}

	/**
	 * Concat two paths together. Basically $pathA+$pathB
	 * @param string $pathA path one
	 * @param string $pathB path two
	 * @return string a trailing slash combinded path.
	 */
	function makePath($pathA, $pathB)
	{
		$pathA = Files::fixPath($pathA);
		if(substr($pathB,0,1)=='/')
			$pathB = substr($pathB,1);
		Return Files::fixPath($pathA.$pathB);
	}

	/**
	 * Similar to makePath, but the second parameter
	 * is not only a path, it may contain say a file ending.
	 * @param string $pathA the leading path
	 * @param string $pathB the ending path with file
	 * @return string combined file path.
	 */
	function makeFile($pathA, $pathB)
	{
		$pathA = Files::fixPath($pathA);
		if(substr($pathB,0,1)=='/')
			$pathB = substr($pathB,1);

		Return $pathA.$pathB;
	}


	/**
	 * Format the file size, limits to Mb.
	 * @param int $size the raw filesize
	 * @return string formated file size.
	 */
	function formatSize($size)
	{
		if($size < 1024)
			return $size.' bytes';
		else if($size >= 1024 && $size < 1024*1024)
			return sprintf('%01.2f',$size/1024.0).' Kb';
		else
			return sprintf('%01.2f',$size/(1024.0*1024)).' Mb';
	}
}

/**
 * Create thumbnails.
 * @author $Author: Wei Zhuo $
 * @version $Id: Thumbnail.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 */

/**
 * Thumbnail creation
 * @author $Author: Wei Zhuo $
 * @version $Id: Thumbnail.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 * @subpackage Images
 */
class Thumbnail
{
        /**
         * Graphics driver, GD, NetPBM or ImageMagick.
         */
        var $driver;

        /**
         * Thumbnail default width.
         */
        var $width = 96;

        /**
         * Thumbnail default height.
         */
        var $height = 96;

        /**
         * Thumbnail default JPEG quality.
         */
        var $quality = 85;

        /**
         * Thumbnail is proportional
         */
        var $proportional = true;

        /**
         * Default image type is JPEG.
         */
        var $type = 'jpeg';

        /**
         * Create a new Thumbnail instance.
         * @param int $width thumbnail width
         * @param int $height thumbnail height
         */
        function Thumbnail($width=96, $height=96)
        {
                $this->driver = Image_Transform::factory(IMAGE_CLASS);
                $this->width = $width;
                $this->height = $height;
        }

        /**
         * Create a thumbnail.
         * @param string $file the image for the thumbnail
         * @param string $thumbnail if not null, the thumbnail will be saved
         * as this parameter value.
         * @return boolean true if thumbnail is created, false otherwise
         */
        function createThumbnail($file, $thumbnail=null)
        {
                if(!is_file($file))
                        Return false;

                //error_log('Creating Thumbs: '.$file);

                $this->driver->load($file);

                if($this->proportional)
                {
                        $width = $this->driver->img_x;
                        $height = $this->driver->img_y;

                        if ($width > $height)
                                $this->height = intval($this->width/$width*$height);
                        else if ($height > $width)
                                $this->width = intval($this->height/$height*$width);
                }

                $this->driver->resize($this->width, $this->height);

                if(is_null($thumbnail))
                        $this->save($file);
                else
                        $this->save($thumbnail);


                $this->free();

                if(is_file($thumbnail))
                        Return true;
                else
                        Return false;
        }

        /**
         * Save the thumbnail file.
         * @param string $file file name to be saved as.
         */
        function save($file)
        {
                $this->driver->save($file);
        }

        /**
         * Free up the graphic driver resources.
         */
        function free()
        {
                $this->driver->free();
        }
}

/**
 * Resize Images on Upload.
 * @author $Author: Wei Zhuo $
 * @Modified by Ryan Demmer (ryandemmer@webmail.co.za)
 * Almost identical to Thumbnail.php
 * @version $Id: Thumbnail.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 */


//require_once('Transform.php');

/**
 * Resize on Upload
 * @author $Author: Wei Zhuo $
 * @Modified by Ryan Demmer (ryandemmer@webmail.co.za)
 * Almost identical to Thumbnail.php
 * @version $Id: Resize.php 26 2004-03-31 02:35:21Z Wei Zhuo $
 * @package ImageManager
 * @subpackage Images
 */
class Resize
{
        /**
         * Graphics driver, GD, NetPBM or ImageMagick.
         */
        var $driver;

        /**
         * Thumbnail default width.
         */
        var $width = 300;

        /**
         * Thumbnail default height.
         */
        var $height = 300;

        /**
         * Thumbnail default JPEG quality.
         */
        var $quality = 85;

        /**
         * Thumbnail is proportional
         */
        var $proportional = true;

        /**
         * Default image type is JPEG.
         */
        var $type = 'jpeg';

        /**
         * Create a new Thumbnail instance.
         * @param int $width thumbnail width
         * @param int $height thumbnail height
         */
        function Resize($width=300, $height=300, $quality=85, $type='jpeg')
        {
                $this->driver = Image_Transform::factory(IMAGE_CLASS);
                $this->width = $width;
                $this->height = $height;
                $this->quality = $quality;
                $this->type = $type;
        }

        /**
         * Create a thumbnail.
         * @param string $file the image for the thumbnail
         * @param string $thumbnail if not null, the thumbnail will be saved
         * as this parameter value.
         * @return boolean true if thumbnail is created, false otherwise
         */
        function resizeImage($file, $type, $quality)
        {
                if(!is_file($file))
                        Return false;

                //error_log('Creating Thumbs: '.$file);

                $this->driver->load($file);

                if($this->proportional)
                {
                        $width = $this->driver->img_x;
                        $height = $this->driver->img_y;

                        if ($width > $height)
                                $this->height = intval($this->width/$width*$height);
                        else if ($height > $width)
                                $this->width = intval($this->height/$height*$width);
                }

                $this->driver->resize($this->width, $this->height);

                $this->save($file, $type, $quality);

                $this->free();

                if(is_file($file))
                        Return true;
                else
                        Return false;
        }

        /**
         * Save the thumbnail file.
         * @param string $file file name to be saved as.
         */
        function save($file)
        {
                $this->driver->save($file);
        }

        /**
         * Free up the graphic driver resources.
         */
        function free()
        {
                $this->driver->free();
        }
}

?>
