<?php
namespace KoninklijkeCollective\KoningComments\ViewHelpers\Widget\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Comment widget controller
 *
 * @package KoninklijkeCollective\KoningComments\ViewHelpers\Widget\Controller
 */
class CommentsController extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var bool
     */
    protected $enableCommenting;

    /**
     * @var string
     */
    protected $sort;

    protected $argumentPrefix = '';

    /**
     * @return void
     */
    public function initializeAction()
    {
        $this->enableCommenting = $this->widgetConfiguration['enableCommenting'];
        $this->sort = $this->widgetConfiguration['sort'];

        if ($this->widgetConfiguration['url'] === '') {
            $this->url = $this->uriBuilder
                ->reset()
                ->setTargetPageUid($this->getTypoScriptFrontendController()->id)
                ->setCreateAbsoluteUri(true)
                ->build();
        } else {
            $this->url = $this->widgetConfiguration['url'];
        }
    }

    /**
     * @param \KoninklijkeCollective\KoningComments\Domain\Model\Comment $comment
     * @return void
     */
    public function indexAction(\KoninklijkeCollective\KoningComments\Domain\Model\Comment $comment = null)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->controllerContext->getRequest()->getArgumentPrefix());
        $settings = $this->getSettings();
        $this->view->assignMultiple([
            'comments' => $this->getCommentRepository()->findTopLevelCommentsByUrl($this->url, $this->sort),
            'enableCommenting' => $this->enableCommenting,
            'userIsLoggedIn' => $this->getTypoScriptFrontendController()->loginUser,
            'argumentPrefix' => $this->controllerContext->getRequest()->getArgumentPrefix(),
            'allowCommentsForNonFeUsers' => $settings['allowCommentsForNonFeUsers']
        ]);
    }

    public function initializeCreateAction() {
        /**
         * TODO: For any reasons I've to allow comment creation here but I don't know why
         */
        if($this->arguments->hasArgument('comment')) {
            $propertyMappingConfiguration = $this->arguments->getArgument('comment')->getPropertyMappingConfiguration();
            $propertyMappingConfiguration->allowProperties(
                'replyTo',
                'nonuserUsername',
                'nonuserEmail',
                'nonuserWww',
                'body'
            );
            $propertyMappingConfiguration->setTypeConverterOption(\TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::class, \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, true);
        }
    }


    /**
     * @param \KoninklijkeCollective\KoningComments\Domain\Model\Comment $comment
     * @validate $comment KoninklijkeCollective.KoningComments:CommentCheck
     * @return void
     */
    public function createAction(\KoninklijkeCollective\KoningComments\Domain\Model\Comment $comment)
    {

        $settings = $this->getSettings();
        $userLoggedIn = false;
        $moderationRequired = true;

        // Access check
        if(false === ($userLoggedIn = $this->getTypoScriptFrontendController()->loginUser)
            && false === (bool) $settings['allowCommentsForNonFeUsers']) {
            $this->addFlashMessage(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('needs_login', 'koning_comments'));
            \TYPO3\CMS\Core\Utility\HttpUtility::redirect($this->url);
        }

        /****
         * Comment Validation
         * @TODO Should take place in an Validator
         * but validators seems to work else than in default ActionControllers here in an WidgetController
         * When adding a Validator to annotations it will be validated but there is no way to access the errors in default action again
         */

        if(trim($comment->getBody()) === ''
            || (false === $userLoggedIn && trim($comment->getNonuserUsername())==='')
            || (false === $userLoggedIn && false === GeneralUtility::validEmail($comment->getNonuserEmail()))) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('generic_validation_error', 'koning_comments'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('index');
        }

        if($this->getTypoScriptFrontendController()->loginUser) {
            $userUid = $this->getTypoScriptFrontendController()->fe_user->user['uid'];
            /** @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user */
            $user = $this->getFrontendUserRepository()->findByUid($userUid);
            $comment->setUser($user);
        }

        if(true === $userLoggedIn) {
            if (!isset($settings['enableModeration'])) {
                $settings['enableModeration'] = 0;
            }
            $moderationRequired = (bool) $settings['enableModeration'];
        } else {
            if (!isset($settings['enableModerationForFeUsers'])) {
                $settings['enableModerationForFeUsers'] = 0;
            }
            $moderationRequired = (bool) $settings['enableModerationForFeUsers'];
        }

        $comment->setUrl($this->url);
        $comment->setPid($this->getTypoScriptFrontendController()->contentPid);
        $comment->setHidden($moderationRequired);
        $comment->setDate(new \DateTime());
        $this->getCommentRepository()->add($comment);
        $this->getPersistenceManager()->persistAll();

        $this->signalSlotDispatcher->dispatch(__CLASS__, 'afterCommentCreated', [$this->settings, $comment]);

        \TYPO3\CMS\Core\Utility\HttpUtility::redirect($this->url . '#koning-comment-' . $comment->getUid());

    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTypoScriptFrontendController()
    {
        return $GLOBALS['TSFE'];
    }

    /**
     * @return \KoninklijkeCollective\KoningComments\Domain\Repository\CommentRepository
     */
    protected function getCommentRepository()
    {
        /** @var \KoninklijkeCollective\KoningComments\Domain\Repository\CommentRepository $commentRepository */
        $commentRepository = $this->objectManager->get(\KoninklijkeCollective\KoningComments\Domain\Repository\CommentRepository::class);
        return $commentRepository;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     */
    protected function getFrontendUserRepository()
    {
        /** @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $frontendUserRepository */
        $frontendUserRepository = $this->objectManager->get(\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository::class);
        return $frontendUserRepository;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
     */
    protected function getPersistenceManager()
    {
        /** @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface $persistenceManager */
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface::class);
        return $persistenceManager;
    }

    /**
     * @return array
     */
    protected function getSettings()
    {
        return $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'KoningComments'
        );
    }
}
