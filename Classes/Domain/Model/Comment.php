<?php
namespace KoninklijkeCollective\KoningComments\Domain\Model;

/**
 * Model: Comment
 *
 * @package KoninklijkeCollective\KoningComments\Domain\Model
 */
class Comment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $user;

    /**
     * @var string
     */
    protected $nonuserUsername = '';

    /**
     * @var string
     */
    protected $nonuserEmail = '';

    /**
     * @var string
     */
    protected $nonuserWww = '';

    /**
     * @var \KoninklijkeCollective\KoningComments\Domain\Model\Comment
     */
    protected $replyTo;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\KoninklijkeCollective\KoningComments\Domain\Model\Comment>
     * @lazy
     */
    protected $replies;

    /**
     * @var bool
     */
    protected $hidden;

    /**
     * @return void
     */
    public function initializeObject()
    {
        $this->replies = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return void
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @return void
     */
    public function setUser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return Comment
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param Comment $replyTo
     * @return void
     */
    public function setReplyTo(Comment $replyTo = null)
    {
        $this->replyTo = $replyTo;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $replies
     * @return void
     */
    public function setReplies(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $replies)
    {
        $this->replies = $replies;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @return string
     */
    public function getNonuserUsername()
    {
        return $this->nonuserUsername;
    }

    /**
     * @param string $nonuserUsername
     */
    public function setNonuserUsername($nonuserUsername)
    {
        $this->nonuserUsername = $nonuserUsername;
    }

    /**
     * @return string
     */
    public function getNonuserEmail()
    {
        return $this->nonuserEmail;
    }

    /**
     * @param string $nonuserEmail
     */
    public function setNonuserEmail($nonuserEmail)
    {
        $this->nonuserEmail = $nonuserEmail;
    }

    /**
     * @return string
     */
    public function getNonuserWww()
    {
        return $this->nonuserWww;
    }

    /**
     * @param string $nonuserWww
     */
    public function setNonuserWww($nonuserWww)
    {
        $this->nonuserWww = $nonuserWww;
    }
}
