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

    const FIRST_PAYMENT =  20;

    const SECOND_PAYMENT = 30;

    const THIRD_PAYMENT  = 38;

    const FOURTH_PAYMENT = 43;

    public function __invoke($programId,  $presentIndex = null)
    {

        if (!$this->auth->hasIdentity()) {
            return false;
        } else {

            /**
             * @var ActiveUserProgram
             */
            $activeUserProgramEntity = $this->em->getRepository(ActiveUserProgram::class)->findOneBy([
                "user" => $this->auth->getIdentity()->getId(),
                "program" => $programId,
            ]);

            if ($activeUserProgramEntity != NULL) {
                if ($activeUserProgramEntity->getIsInstallement()) {
                    // $courseCount = count($data);
                    if (count($activeUserProgramEntity->getActiveInstallment()) == 1) {
                        if ($presentIndex <  self::FIRST_PAYMENT) {
                            return true;
                        } else {
                            return false;
                        }
                    } else if (count($activeUserProgramEntity->getActiveInstallment()) == 2) {
                        if ($presentIndex <  self::SECOND_PAYMENT) {
                            return true;
                        } else {
                            return false;
                        }
                    } else if (count($activeUserProgramEntity->getActiveInstallment()) == 3) {
                        if ($presentIndex <  self::THIRD_PAYMENT) {
                            return true;
                        } else {
                            return false;
                        }
                    } else if (count($activeUserProgramEntity->getActiveInstallment()) == 4) {
                        if ($presentIndex <  self::FOURTH_PAYMENT) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    if ($activeUserProgramEntity != NULL) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }


            return false;
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
