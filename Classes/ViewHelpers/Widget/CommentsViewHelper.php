<?php
namespace KoninklijkeCollective\KoningComments\ViewHelpers\Widget;

/**
 * Comments widget
 *
 * Usage:
 *
 * <c:widget.comments />
 *
 * Options:
 *  - url: link to current page (if left empty, it builds the url based on TSFE->id. Use this param if you use this on a page with an extension with url params
 *  - enableCommenting: use this to make commenting read only (will display previous comments, but no option to post new ones)
 *  - sort: sorting (ASC or DESC)
 *
 * Example with url:
 *
 * <c:widget.comments url="{f:uri.action(action: 'detail', arguments: '{identifier: \'{item.uid}\'}', absolute: 1, noCacheHash: 1)}" />
 *
 * @package KoninklijkeCollective\KoningComments\ViewHelpers\Widget
 */
class CommentsViewHelper extends \TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper
{
    /**
     * @var \KoninklijkeCollective\KoningComments\ViewHelpers\Widget\Controller\CommentsController
     * @inject
     */
    protected $controller;

    /**
     * Initialize arguments.
     *
     * @api
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('url', 'string', 'URL to store with the comment', false);
        $this->registerArgument('enableCommenting', 'boolean', 'enablecommenting', false, true);
        $this->registerArgument('sort', 'string', 'sorting direction', false, 'DESC');
    }

    /**
     * Render commenting functionality
     * @return string
     */
    public function render()
    {
        return $this->initiateSubRequest();
    }
}
