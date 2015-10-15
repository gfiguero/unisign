<?php

namespace Uni\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * ProductPhoto
 */
class ProductPhoto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $file;

    /**
     * @var \Uni\AdminBundle\Entity\product
     */
    private $product;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return ProductPhoto
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set file
     *
     * @param string $file
     * @return ProductPhoto
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set product
     *
     * @param \Uni\AdminBundle\Entity\product $product
     * @return ProductPhoto
     */
    public function setProduct(\Uni\AdminBundle\Entity\product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Uni\AdminBundle\Entity\product 
     */
    public function getProduct()
    {
        return $this->product;
    }
    public function upload() { if (null === $this->getFile()) { return; } $generator = new SecureRandom(); $random = $generator->nextBytes(10); $prefix = md5($random); $this->getFile()->move($this->getUploadRootDir(), $prefix.'_'.$this->getFile()->getClientOriginalName());$this->path = $prefix.'_'.$this->getFile()->getClientOriginalName();$this->file = null; }
    public function getAbsolutePath() { return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path; }
    public function getWebPath() { return null === $this->path ? 'default' : $this->getUploadDir().'/'.$this->path; }
    protected function getUploadRootDir() { return __DIR__.'/../../../../web/'.$this->getUploadDir(); }
    protected function getUploadDir() { return '/uploads/product'; }
}
