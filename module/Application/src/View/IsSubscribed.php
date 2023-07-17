<?php

namespace Application\View;

use Application\Entity\ActiveUserProgram;
use General\Service\GeneralService;
use Laminas\View\Helper\AbstractHelper;
use Psr\Container\ContainerInterface;

class isSubscribed extends AbstractHelper
{

    private $em;

    private $auth;

    public function __invoke($programId)
    {
        // var_dump($this->auth->getIdentity()->getId());
        if (!$this->auth->hasIdentity()) {
            return false;
        } else {
            // /**
            //  * @var GeneralService
            //  */
            // $generalService = $container->get("general_service");
            // $auth = $generalService->getAuth();
            // $em = $generalService->getEntityManager();
            // $identity = $auth->getIdentity();
            // if ($this->auth->hasIdentity()) {
            $activeUserProgramEntity = $this->em->getRepository(ActiveUserProgram::class)->findOneBy([
                "user" => $this->auth->getIdentity()->getId(),
                "program" => $programId,
            ]);

            if ($activeUserProgramEntity != NULL) {
                return true;
            } else {
                return false;
            }
            // }
        }
    }

    /**
     * Get the value of em
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * Set the value of em
     *
     * @return  self
     */
    public function setEm($em)
    {
        $this->em = $em;

        return $this;
    }



    /**
     * Set the value of auth
     *
     * @return  self
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;

        return $this;
    }
}
