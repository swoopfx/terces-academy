<?php

namespace Application\View;

use Application\Entity\ActiveUserProgram;
use General\Service\GeneralService;
use Laminas\View\Helper\AbstractHelper;
use Psr\Container\ContainerInterface;

class IsSubscribed extends AbstractHelper
{

    private $em;

    private $auth;

    public function __invoke($programId)
    {

        if (!$this->auth->hasIdentity()) {
            return false;
        } else {
            $activeUserProgramEntity = $this->em->getRepository(ActiveUserProgram::class)->findOneBy([
                "user" => $this->auth->getIdentity()->getId(),
                "program" => $programId,
            ]);

            if ($activeUserProgramEntity != NULL) {
                return true;
            } else {
                return false;
            }
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
