<?php

namespace Uni\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * NoticePhoto
 */
class NoticePhoto
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
     * @var \Uni\AdminBundle\Entity\Notice
     */
    private $notice;


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
     * @return NoticePhoto
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
     * @return NoticePhoto
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
     * Set notice
     *
     * @param \Uni\AdminBundle\Entity\Notice $notice
     * @return NoticePhoto
     */
    public function setNotice(\Uni\AdminBundle\Entity\Notice $notice = null)
    {
        $this->notice = $notice;

        return $this;
    }

    /**
     * Get notice
     *
     * @return \Uni\AdminBundle\Entity\Notice 
     */
    public function getNotice()
    {
        return $this->notice;
    }
    public function upload() { if (null === $this->getFile()) { return; } $generator = new SecureRandom(); $random = $generator->nextBytes(10); $prefix = md5($random); $this->getFile()->move($this->getUploadRootDir(), $prefix.'_'.$this->getFile()->getClientOriginalName());$this->path = $prefix.'_'.$this->getFile()->getClientOriginalName();$this->file = null; }
    public function getAbsolutePath() { return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path; }
    public function getWebPath() { return null === $this->path ? 'default' : $this->getUploadDir().'/'.$this->path; }
    protected function getUploadRootDir() { return __DIR__.'/../../../../web/'.$this->getUploadDir(); }
    protected function getUploadDir() { return '/uploads/notice'; }
}
