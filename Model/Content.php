<?php

namespace Smirik\ContentBundle\Model;

use Smirik\ContentBundle\Model\om\BaseContent;


/**
 * Skeleton subclass for representing a row from the 'content' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.vendor.bundles.Smirik.ContentBundle.Model
 */
class Content extends BaseContent {

  public function hasImage()
  {
    $ext = $this->getFileExtension();
    if (in_array($ext, array('jpg', 'gif', 'png')))
    {
      return true;
    }
    return false;
  }
  
  public function getFileExtension()
  {
    $file = $this->getFile();
    if (!$file || ($file == ''))
    {
      return false;
    }
    $tmp = explode('.', $file);
    $ext = $tmp[count($tmp)-1];
    return $ext;
  }

} // Content
