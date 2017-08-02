<?php
namespace KoninklijkeCollective\KoningComments\Validation\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\GenericObjectValidator;
use TYPO3\CMS\Extbase\Validation\Validator\ValidatorInterface;

/**
 * A CommentCheck
 */
class CommentCheckValidator extends GenericObjectValidator implements ValidatorInterface
{

    /**
     * Object manager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;

    /**
     * Validation method
     *
     * @param mixed $object
     *
     * @return boolean|\TYPO3\CMS\Extbase\Error\Result
     */
    public function validate($object)
    {

        /** @var \TYPO3\CMS\Extbase\Error\Result $messages */
        $messages = $this->objectManager->get(\TYPO3\CMS\Extbase\Error\Result::class);

        if ($object === null) {
            return $messages;
        }

        if (!$this->canValidate($object)) {
            /** @var \TYPO3\CMS\Extbase\Error\Error $error */
            $error = $this->objectManager->get(
                \TYPO3\CMS\Extbase\Error\Error::class,
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'error_notvalidatable',
                    'koning_comments'
                ),
                1501660627
            );
            $messages->addError($error);
            return $messages;
        }

        /** @var \TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator $notEmptyValidator */
        $notEmptyValidator = $this->objectManager->get(\TYPO3\CMS\Extbase\Validation\Validator\NotEmptyValidator::class);

        $messages->merge($notEmptyValidator->validate($object->getBody()));

        if(false === ($object->getUser() instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser)) {
            /** @var \TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator $emailValidator */
            $emailValidator = $this->objectManager->get(\TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator::class);
            $messages->merge($emailValidator->validate($object->getNonuserEmail()));
            $messages->merge($notEmptyValidator->validate($object->getNonuserUsername()));
        }

        return $messages;
    }
    /**
     * Checks if validator can validate the object
     * @param object $object
     * @return boolean
     */
    public function canValidate($object)
    {
        return (
            $object instanceof \KoninklijkeCollective\KoningComments\Domain\Model\Comment
        );
    }
}
