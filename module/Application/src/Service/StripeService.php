<?php

namespace Application\Service;

use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveUserProgramStatus;
use Application\Entity\Coupon;
use Application\Entity\Installement;
use Application\Entity\Programs;
use Application\Entity\ScheduleCareerTalk;
use Application\Entity\Transaction;
use Application\Entity\TransactionStatus;
use Authentication\Entity\User;
use Stripe\StripeClient;
use Doctrine\ORM\EntityManager;
use Laminas\Session\Container;
use General\Service\GeneralService;
use Ramsey\Uuid\Uuid;

class StripeService
{
    /**
     * Undocumented variable
     *
     * @var StripeClient
     */
    private $stripeClient;


    /**
     * Undocumented variable
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;


    private $postmarkService;

    public function calculateTax($items, $currency)
    {

        $taxCalculation = $this->stripeClient->tax->calculations->create([
            'currency' => $currency,
            'customer_details' => [
                'address' => [
                    'line1' => '920 5th Ave',
                    'city' => 'Seattle',
                    'state' => 'WA',
                    'postal_code' => '98104',
                    'country' => 'US',
                ],
                'address_source' => 'shipping',
            ],
            'line_items' => array_map('buildLineItem', $items),
        ]);

        return $taxCalculation;
    }

    public function init($dedata)
    {
        $buyCourseSession = new Container("buy_course_uuid");
        /**
         * @var User
         */
        $auth = $this->generalService->getAuth()->getIdentity();

        $transactionRef = TransactionService::transactionUid();
        $em = $this->generalService->getEntityManager();
        /**
         * @var Programs
         */
        $programEntity = $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $buyCourseSession->uuid
        ]);


        $amount = $dedata["amount"];

        /**
         * This could also be a coupon or calculated amount 
         */
        // $amount = $programEntity->getCost();
        $transactionEntity = new Transaction();

        $uuid = Uuid::uuid4();



        $data = [
            "amount" => $amount,
            "ref" => $transactionRef,
            "email" => $auth->getEmail(),
            "fullname" => $auth->getFullname(),
            "coupon" => $dedata["coupon"]

        ];
        $buyCourseSession->sripeData = $data;
        $transactionEntity->setCreatedOn(new \Datetime())->setIsActive(TRUE)
            ->setProgram($programEntity)
            ->setTransactionId($transactionRef)->setUuid($uuid)
            ->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_INITITED))
            ->setUser($auth)
            // ->setPaystackData()
            ->setAmount($amount);
        $em->persist($transactionEntity);
        $em->flush();


        // return $data;

        $paymentIntent = $this->stripeClient->paymentIntents->create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        return $output;
    }

    public function initInstallment($data)
    {
        $settings = $this->generalService->getSettings();
        $buyCourseSession = new Container("buy_course_uuid");
        $auth = $this->generalService->getAuth()->getIdentity();

        $transactionRef = TransactionService::transactionUid();
        $em = $this->generalService->getEntityManager();

        $programEntity = $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $buyCourseSession->uuid
        ]);
        // var_dump($data);
        /**
         * @var Installement
         */
        $installmentEntity = $em->find(Installement::class, $data["uuid"]);
        /**
         * This could also be a coupon or calculated amount 
         */
        $amount = $installmentEntity->getAmountPayable();
        $transactionEntity = new Transaction();

        $uuid = Uuid::uuid4();

        // $data = [
        //     "price" => $amount,
        //     "tx_ref" => $transactionRef
        // ];

        // // $rdata = $this->paypalService->createOrder($data);
        // $decodedData = json_decode($rdata);
        // $transactionEntity->setCreatedOn(new \Datetime())->setIsActive(TRUE)
        //     ->setProgram($programEntity)
        //     ->setTransactionId($transactionRef)->setUuid($uuid)
        //     ->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_INITITED))
        //     ->setPaypalOrderId($decodedData->id)
        //     ->setAmount($amount);



        // $em->persist($transactionEntity);
        // $em->flush();


        $data = [
            "amount" => $amount,
            "ref" => $transactionRef,
            "email" => $auth->getEmail(),
            "fullname" => $auth->getFullname(),
            "iuuid" => $data["uuid"],
            "puuid" => $buyCourseSession->uuid

        ];
        $buyCourseSession->sripeInsData = $data;
        $transactionEntity->setCreatedOn(new \Datetime())->setIsActive(TRUE)
            ->setProgram($programEntity)
            ->setTransactionId($transactionRef)->setUuid($uuid)
            ->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_INITITED))
            ->setUser($auth)
            // ->setPaystackData()
            ->setAmount($data["amount"]);
        $em->persist($transactionEntity);
        $em->flush();


        $paymentIntent = $this->stripeClient->paymentIntents->create([
            'amount' => $data["amount"] * 100,
            'currency' => 'usd',
            // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        return $output;
    }

    public function final()
    {

        // send transaction email here
        // update transaction statusand 
        // $decodedData = Json::decode($response->getBody());
        $auth = $this->generalService->getAuth()->getIdentity();

        $transactionRef = TransactionService::transactionUid();
        $em = $this->generalService->getEntityManager();
        $buyCourseSession = new Container("buy_course_uuid");
        $data = $buyCourseSession->sripeData;
        // var_dump($data);
        /**
         * @var Transaction
         */
        $transactionEntity = $em->getRepository(Transaction::class)->findOneBy([
            "transactionId" => $data["ref"]
        ]);

        if ($data["coupon"] != "") {
            /**
             * @var Coupon
             */
            $couponEntity = $em->getRepository(Coupon::class)->findOneBy([
                "coupon" => $data["coupon"]
            ]);
            $couponEntity->setIsUsed(TRUE)->setUpdatedOn(new \DateTime());
            $em->persist($couponEntity);
        }

        $transactionEntity->setUpdatedOn(new \Datetime())->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_COMPLETED));


        // create Active user Training f

        $auth = $this->generalService->getAuth()->getIdentity();

        /**
         * @var Programs
         */
        $programEntity = $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $buyCourseSession->uuid
        ]);
        $activeUserProgramEntity = new ActiveUserProgram();
        $activeUserProgramEntity->setProgram($programEntity)->setUser($auth)
            ->setCreatedOn(new \Datetime())
            ->setIsActive(TRUE)
            ->setIsInstallement(FALSE)
            ->setStatus($em->find(ActiveUserProgramStatus::class, GeneralService::ACTIVE_USER_PROGRAM_STATUS_ACQUIRED))
            ->setUuid(Uuid::uuid4());

        $date = new \Datetime();

        $mail["to"] = $auth->getEmail();
        $mail["product_name"] = $programEntity->getTitle();
        $mail["customer_name"] = $auth->getFullname();
        $mail["tx_ref"] = $transactionEntity->getUuid();
        $mail["date"] = $date->format('Y-m-d');
        $mail["amount"] = $transactionEntity->getAmount();

        $this->postmarkService->acquisitionSuccessEmail($mail);

        $em->persist($activeUserProgramEntity);
        $em->persist($transactionEntity);
        $em->flush();


        // send EMailto customer

        // $transactionEntity->setUpdatedOn(new \Datetime())->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_FAILED));
        // $em->persist($transactionEntity);
        // $em->flush();
        // throw new \Exception("Payment was not completed");


    }

    public function finalCareerService()
    {

        // send transaction email here
        // update transaction statusand 
        // $decodedData = Json::decode($response->getBody());
        $auth = $this->generalService->getAuth()->getIdentity();

        $transactionRef = TransactionService::transactionUid();
        $em = $this->generalService->getEntityManager();
        $sess  = new Container("career_service_schedule");
        $uuid = $sess->uuid;

        /**
         * @var ScheduleCareerTalk
         */
        $schCareerEntity = $em->getRepository(ScheduleCareerTalk::class)->findOneBy([
            "uuid" => $uuid
        ]);

        $uuidt = Uuid::uuid4();

        $schCareerEntity->setUpdatedOn(new \Datetime())->setIsPayment(TRUE);
        $transactionEntity = new Transaction();
        $transactionEntity->setAmount(100)
            // ->setProgram($programEntity)
            ->setServicee("Payment for career talk")
            ->setCreatedOn(new \Datetime())
            ->setTransactionId($transactionRef)->setUuid($uuidt)
            ->setIsActive(TRUE)
            ->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_COMPLETED))
            ->setUser($auth);

        $em->persist($transactionEntity);
        $em->persist($schCareerEntity);

        $em->flush();

        $auth = $this->generalService->getAuth()->getIdentity();

        $date = new \Datetime();

        $mail["to"] = $auth->getEmail();
        $mail["product_name"] = "Scheduled Career talk";
        $mail["customer_name"] = $auth->getFullname();
        $mail["tx_ref"] = $transactionEntity->getUuid();
        $mail["date"] = $date->format('Y-m-d');
        $mail["amount"] = $transactionEntity->getAmount();

        $this->postmarkService->acquisitionSuccessEmail($mail);

        // $mailCustomer[]
        $mailCustomer["to"] = $auth->getEmail();
        $mailCustomer["name"] = $auth->getFullname();
        $mailCustomer["product_name"] = "Scheduled Career talk";
        $mailCustomer["customer_name"] = $auth->getFullname();
        $mailCustomer["sch_time"] = $schCareerEntity->getTimee();
        $mailCustomer["sch_date"] = $schCareerEntity->getDateString();
        $this->postmarkService->customerCareerTalkNotification($mailCustomer);
        $this->postmarkService->adminCareerTalkNotification($mailCustomer);


        $em->persist($transactionEntity);
        $em->flush();
    }

    public function finalInstallment()
    {
        $em = $this->generalService->getEntityManager();
        $buyCourseSession = new Container("buy_course_uuid");
        $cdata = $buyCourseSession->sripeInsData;

        $auth = $this->generalService->getAuth()->getIdentity();
        /**
         * @var Installement
         */
        $installmentEntity = $em->find(Installement::class, $cdata["iuuid"]);


        /**
         * @var Transaction
         */
        $transactionEntity = $em->getRepository(Transaction::class)
            ->findOneBy(["transactionId" => $cdata["ref"]]);
        $transactionEntity->setUpdatedOn(new \Datetime())->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_COMPLETED));



        $auth = $this->generalService->getAuth()->getIdentity();

        /**
         * @var Programs
         */
        $programEntity = $em->getRepository(Programs::class)->findOneBy([
            "uuid" => $cdata["puuid"]
        ]);
        $activeUserProgramEntity = $em->getRepository(ActiveUserProgram::class)->findOneBy([
            "user" => $auth->getId(),
            "program" => $programEntity->getId()
        ]);



        if ($activeUserProgramEntity == NULL) {
            /**
             * @var ActiveUserProgram
             */
            $activeUserProgramEntity = new ActiveUserProgram();
            $activeUserProgramEntity->setProgram($programEntity)->setUser($auth)
                ->setCreatedOn(new \Datetime())
                ->setIsActive(TRUE)
                ->setIsInstallement(FALSE)
                ->setStatus($em->find(ActiveUserProgramStatus::class, GeneralService::ACTIVE_USER_PROGRAM_STATUS_ACQUIRED))
                ->setIsInstallement(TRUE)
                ->setUuid(Uuid::uuid4());
        }
        $installmentEntity->setUpdatedOn(new \DateTime())->setIsSettled(TRUE)->setActiveUserProgram($activeUserProgramEntity);
        $activeUserProgramEntity->setIsInstallement(TRUE)->setUpdatedOn(new \DateTime())->setPaidInstallment($installmentEntity);

        $em->persist($installmentEntity);
        $date = new \Datetime();

        $mail["to"] = $auth->getEmail();
        $mail["product_name"] = $programEntity->getTitle();
        $mail["customer_name"] = $auth->getFullname();
        $mail["tx_ref"] = $transactionEntity->getUuid();
        $mail["date"] = $date->format('Y-m-d');
        $mail["amount"] = $transactionEntity->getAmount();

        $this->postmarkService->acquisitionSuccessEmail($mail);

        $em->persist($activeUserProgramEntity);
        $em->persist($transactionEntity);
        $em->flush();


        // send EMailto customer

    }


    function buildLineItem($item)
    {
        return [
            'amount' => $item->amount, // Amount in cents
            'reference' => $item->id, // Unique reference for the item in the scope of the calculation
        ];
    }

    function calculateOrderAmount($items, $taxCalculation)
    {
        // Replace this constant with a calculation of the order's amount
        // Calculate the order total with any exclusive taxes on the server to prevent
        // people from directly manipulating the amount on the client
        $orderAmount = 1400;
        $orderAmount += $taxCalculation->tax_amount_exclusive;
        return $orderAmount;
    }

    // Invoke this method in your webhook handler when `payment_intent.succeeded` webhook is received
    function handlePaymentIntentSucceeded($stripe, $paymentIntent)
    {
        // Create a Tax Transaction for the successful payment
        $this->stripeClient->tax->transactions->createFromCalculation([
            "calculation" => $paymentIntent->metadata['tax_calculation'],
            "reference" => "myOrder_123", // Replace with a unique reference from your checkout/order system
        ]);
    }

    /**
     * Get the value of stripeClient
     */
    public function getStripeClient()
    {
        return $this->stripeClient;
    }

    /**
     * Set the value of stripeClient
     *
     * @return  self
     */
    public function setStripeClient($stripeClient)
    {
        $this->stripeClient = $stripeClient;

        return $this;
    }

    /**
     * Get the value of entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Set the value of entityManager
     *
     * @return  self
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
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
     * Get the value of postmarkService
     */
    public function getPostmarkService()
    {
        return $this->postmarkService;
    }

    /**
     * Set the value of postmarkService
     *
     * @return  self
     */
    public function setPostmarkService($postmarkService)
    {
        $this->postmarkService = $postmarkService;

        return $this;
    }
}
