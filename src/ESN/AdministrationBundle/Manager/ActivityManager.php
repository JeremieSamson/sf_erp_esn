<?php

namespace ESN\AdministrationBundle\Manager;

use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\Activity;
use ESN\UserBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Created by PhpStorm.
 * User: ylly
 * Date: 15/11/15
 * Time: 18:44
 */
class ActivityManager
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(SecurityContext $securityContext, EntityManager $em){
        $this->em   = $em;
        $this->user = $securityContext->getToken()->getUser();
    }

    public function login(){
        $activityNewLog = new Activity();
        $activityNewLog->setAction(Activity::$ACTIONS["li"]);

        $this->save($activityNewLog);
    }

    public function logout(){
        $activityNewLog = new Activity();
        $activityNewLog->setAction(Activity::$ACTIONS["lo"]);

        $this->save($activityNewLog);
    }

    public function update($old, $new){
        $activity = new Activity();
        $activity->setAction("u");
        $activity->setOld($old);
        $activity->setNew($new);

        $this->save($activity);
    }

    /**
     * @param $object
     */
    public function delete($object){
        $activity = new Activity();
        $activity->setAction(Activity::$ACTIONS["d"]);
        $activity->setOld(get_class($object));

        $this->save($activity);
    }

    /**
     * @param $object
     */
    public function create($object){
        $activity = new Activity();
        $activity->setAction(Activity::$ACTIONS["c"]);
        $activity->setNew(get_class($object));

        $this->save($activity);
    }

    public function save(Activity $activity){
        $this->user->addActivity($activity);

        $this->em->persist($activity);
        $this->em->flush();
    }
}