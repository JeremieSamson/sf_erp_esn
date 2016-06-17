<?php

namespace ESN\HRBundle\Acl;

use FOS\CommentBundle\Acl\RoleCommentAcl as BaseRoleCommentAcl;
use FOS\CommentBundle\Model\CommentInterface;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class RoleCommentAcl extends BaseRoleCommentAcl
{
    /**
     * The current Security Context.
     *
     * @var SecurityContextInterface
     */
    private $securityContext;

    /**
     * Constructor.
     *
     * @param SecurityContextInterface $securityContext
     * @param string                   $createRole
     * @param string                   $viewRole
     * @param string                   $editRole
     * @param string                   $deleteRole
     * @param string                   $commentClass
     */
    public function __construct(SecurityContextInterface $securityContext,
                                $createRole,
                                $viewRole,
                                $editRole,
                                $deleteRole,
                                $commentClass
    )
    {
        parent::__construct(
            $securityContext,
            $createRole,
            $viewRole,
            $editRole,
            $deleteRole,
            $commentClass);

        $this->securityContext   = $securityContext;
    }


    /**
     * Checks if the Security token has an appropriate role to edit the supplied Comment.
     *
     * @param  CommentInterface $comment
     * @return boolean
     */
    public function canEdit(CommentInterface $comment)
    {
        if ($comment instanceof SignedCommentInterface)
        {
            if ($comment->getAuthor() == $this->securityContext->getToken()->getUser()){
                return true;
            }
        }
        return parent::canEdit($comment);
    }

    /**
     * Checks if the Security token is allowed to delete a specific Comment.
     *
     * @param  CommentInterface $comment
     * @return boolean
     */
    public function canDelete(CommentInterface $comment)
    {
        if ($comment instanceof SignedCommentInterface)
        {
            if ($comment->getAuthor() == $this->securityContext->getToken()->getUser()
                || $this->securityContext->getToken()->getUser()->isVp()
            ) {
                return true;
            }
        }
        return parent::canDelete($comment);
    }

}
