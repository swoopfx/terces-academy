<?php

namespace Application\Service;

use Application\Entity\Programs;
use Application\Entity\Transaction;
use Application\Entity\TransactionStatus;
use General\Service\GeneralService;
use Laminas\Session\Container;
use Ramsey\Uuid\Uuid;

class TransactionService
{

    const TRANSACTION_STATUS_INITITED = 100;

    const TRANSACTION_STATUS_COMPLETED = 800;

    const TRANSACTION_STATUS_FAILED = 200;

    const TRANSACTION_STATUS_PROCESSING = 500;

    const TRANSACTION_STATUS_CANCELED = 700;

    /**
     * Undocumented variable
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     * Undocumented variable
     *
     * @var PaypalService
     */
    private $paypalService;


    public function hydrateTransaction()
    {
        $em = $this->generalService->getEntityManager();
    }


    public function verifyFlutterwaveTransaction()
    {
    }

    public function preTransaction(?array $data): array
    {
        $settings = $this->generalService->getSettings();
        $buyCourseSession = new Container("buy_course_uuid");
        $auth = $this->generalService->getAuth()->getIdentity();

        $transactionRef = self::transactionUid();
        $em = $this->generalService->getEntityManager();
        /**
         * @var Programs
         */
        $programEntity = $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $buyCourseSession->uuid
        ]);
        /**
         * This could also be a coupon or calculated amount 
         */
        $amount = $programEntity->getCost();
        $transactionEntity = new Transaction();

        $transactionEntity->setCreatedOn(new \Datetime())->setIsActive(TRUE)
            ->setProgram($programEntity)
            ->setTransactionId($transactionRef)->setUuid(Uuid::uuid4())
            ->setStatus($em->find(TransactionStatus::class, self::TRANSACTION_STATUS_INITITED))
            ->setAmount($amount);

        $em->persist($transactionEntity);
        $em->flush();
        $data = [
            "public_key" => $settings->getFlutterwavePublicKey(),
            "tx_ref" => $transactionRef,
            "program_uuid" => $buyCourseSession->uuid,
            "amount" => $amount,
            "customer" => [
                "email" => $auth->getEmail(),
                "fullname" => $auth->getFullname(),
                "uuid" => $auth->getUuid(),

            ],
            "description" => "Payment for {$programEntity->getTitle()}"
        ];
        return $data;
    }


    public function paypalCreateOrder()
    {
        $settings = $this->generalService->getSettings();
        $buyCourseSession = new Container("buy_course_uuid");
        $auth = $this->generalService->getAuth()->getIdentity();

        $transactionRef = self::transactionUid();
        $em = $this->generalService->getEntityManager();
        /**
         * @var Programs
         */
        $programEntity = $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $buyCourseSession->uuid
        ]);
        /**
         * This could also be a coupon or calculated amount 
         */
        $amount = $programEntity->getCost();
        $transactionEntity = new Transaction();

        $uuid = Uuid::uuid4();

        $data = [
            "price" => $amount,
            "tx_ref" => $transactionRef
        ];

        $rdata = $this->paypalService->createOrder($data);
        $decodedData = json_decode($rdata);
        $transactionEntity->setCreatedOn(new \Datetime())->setIsActive(TRUE)
            ->setProgram($programEntity)
            ->setTransactionId($transactionRef)->setUuid($uuid)
            ->setStatus($em->find(TransactionStatus::class, self::TRANSACTION_STATUS_INITITED))
            ->setPaypalOrderId($decodedData->id)
            ->setAmount($amount);

      

        $em->persist($transactionEntity);
        $em->flush();

        
        return $rdata;
    }


    public function 


    public static function transactionUid()
    {
        return uniqid("transact");
    }

    /**
     * Get undocumented variable
     *
     * @return  GeneralService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * Set undocumented variable
     *
     * @param  GeneralService  $generalService  Undocumented variable
     *
     * @return  self
     */
    public function setGeneralService(GeneralService $generalService)
    {
        $this->generalService = $generalService;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  PaypalService
     */
    public function getPaypalService()
    {
        return $this->paypalService;
    }

    /**
     * Set undocumented variable
     *
     * @param  PaypalService  $paypalService  Undocumented variable
     *
     * @return  self
     */
    public function setPaypalService(PaypalService $paypalService)
    {
        $this->paypalService = $paypalService;

        return $this;
    }
}
