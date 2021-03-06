<?php

/*
 * This file is part of the package bk2k/bootstrap-package.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace BK2K\BootstrapPackage\ViewHelpers\File;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

class IsMediaViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $file = $renderChildrenClosure();
        $allowedFileExtensions = $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'] ?? '';
        $allowedFileExtensions = GeneralUtility::trimExplode(',', $allowedFileExtensions);

        if (is_object($file)
            && in_array(get_class($file), [FileReference::class, File::class], true)
            && (
                in_array($file->getExtension(), $allowedFileExtensions, true)
                || $file->getType() === File::FILETYPE_VIDEO
            )
        ) {
            return true;
        }

        return false;
    }
}
