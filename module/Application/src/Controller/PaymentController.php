<?php

namespace Application\Controller;

use Application\Service\PaystackService;
use Application\Service\StripeService;
use Application\Service\TransactionService;
use Doctrine\ORM\EntityManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\Container;
use Laminas\View\Model\JsonModel;

class PaymentController extends AbstractActionController
{
    /**
     * Undocumented variable
     *
     * @var PaystackService
     */
    private PaystackService $paystackService;

    /**
     * Undocumented variable
     *
     * @var TransactionService
     */
    private TransactionService $transactionService;

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * Undocumented variable
     *
     */
    private $paystackConfig;

    /**
     * Undocumented variable
     *
     * @var StripeService
     */
    private StripeService $stripeService;

    public function initPaystackCareerServiceNairaAction()
    {
        $jsonModel = new JsonModel();

        $request = $this->getRequest();
        $response = $this->getResponse();


        try {
            $data = $this->paystackService->intiatializeTransactionCareerServiceNaira();
            $data["public_key"] = $this->paystackConfig["public_key"];
            $jsonModel->setVariables($data);
            $response->setStatusCode(201);
        } catch (\Throwable $th) {
            $response->setStatusCode(400);
            $jsonModel->setVariables([
                "trace" => $th->getTrace(),
                "message" => $th->getMessage()
            ]);
        }

        return $jsonModel;
    }


    public function finalizeCareerServiceNairaAction()
    {

        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        $query = $this->params()->fromQuery();
        // $intentSession = new Container("intent_session");
        $sess  = new Container("career_service_schedule");
        $uuid = $sess->uuid;
        if ($uuid != NULL) {
            if ($request->isPost()) {
                $post  = $request->getPost()->toArray();
                try {
                    // $data = $this->paystackService->intiatializeTransaction();\
                    if ($post["reference"] == NULL) {
                        throw new \Exception("Absent payment reference");
                    }
                    $data = $this->paystackService->verifyCareerServiceTrasaction($post);
                    $data = $this->stripeService->finalCareerService();
                    $response->setStatusCode(201);
                    return $jsonModel;
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        // "trace" => $th->getTraceAsString(),
                        "message" => $th->getMessage()
                    ]);
                    return $jsonModel;
                }
            } else {
                $response->setStatusCode(400);
                // $jsonModel->setVariables([
                //     // "trace" => $th->getTraceAsString(),
                //     "message" => $th->getMessage()
                // ]);
                return $jsonModel;
            }
        }
        return $jsonModel;
    }

    /**
     * Set undocumented variable
     *
     * @param  StripeService  $stripeService  Undocumented variable
     *
     * @return  self
     */
    public function setStripeService(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;

        return $this;
    }

    /**
     * Set undocumented variable
     *
     * @param  PaystackService  $paystackService  Undocumented variable
     *
     * @return  self
     */
    public function setPaystackService(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;

        return $this;
    }

    /**
     * Set undocumented variable
     *
     * @param  TransactionService  $transactionService  Undocumented variable
     *
     * @return  self
     */
    public function setTransactionService(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;

        return $this;
    }

    /**
     * Set undocumented variable
     *
     * @param  EntityManager  $entityManager  Undocumented variable
     *
     * @return  self
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Set undocumented variable
     *
     * @return  self
     */ 
    public function setPaystackConfig($paystackConfig)
    {
        $this->paystackConfig = $paystackConfig;

        return $this;
    }
}
