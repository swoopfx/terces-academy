<?php

namespace Application\Service;

use Application\Entity\ActiveUserProgram;
use Application\Entity\ActiveUserProgramStatus;
use Application\Entity\Programs;
use Application\Entity\Transaction;
use Application\Entity\TransactionStatus;
use Laminas\Http\Client;
use Laminas\Json\Json;
use Laminas\Session\Container;
use Ramsey\Uuid\Uuid;
use Authentication\Entity\User;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use General\Service\PostMarkService;

class PaystackService
{

    private $generalService;

    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;

    private $baseEndpoint;

    //     private 

    /**
     * 
     * @var string
     */
    private $publicKey;

    /**
     * 
     * @var string
     */
    private $secretKey;

    /**
     * Undocumented variable
     *
     * @var PostMarkService
     */
    private $postmarkService;


    public function intiatializeTransaction()
    {
        // $settings = $this->generalService->getSettings();
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
        /**
         * This could also be a coupon or calculated amount 
         */
        $amount = $programEntity->getCost();
        $transactionEntity = new Transaction();

        $uuid = Uuid::uuid4();


        $data = [
            "amount" => $amount,
            "ref" => $transactionRef,
            "email" => $auth->getEmail(),
            "fullname" => $auth->getFullname(),

        ];


        // $endPoint = "{$this->baseEndpoint}/transaction/initialize";

        // $client = new Client();
        // $headers["Content-Type"] = "application/json";
        // $paystackAmount = $amount * 100;
        // $body = [
        //     "amount" => $paystackAmount,
        //     "email" => $auth->getEmail(),
        //     "currency" => "USD",
        //     "callback_url" => "",
        //     "channels" => ["card"]

        // ];
        // $headers["Authorization"] = "Bearer " . $this->secretKey;
        // $client->setHeaders($headers);
        // $client->setMethod("POST");
        // $client->setRawBody(json_encode($body));
        // //         $client->setParameterGet($getBody);
        // $client->setUri($endPoint);

        // $response = $client->send();

        // if ($response->isSuccess()) {
        // send transaction email here


        // $rdata = $this->paypalService->createOrder($data);
        // $decodedData = json_decode($rdata);
        $transactionEntity->setCreatedOn(new \Datetime())->setIsActive(TRUE)
            ->setProgram($programEntity)
            ->setTransactionId($transactionRef)->setUuid($uuid)
            ->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_INITITED))
            ->setUser($auth)
            // ->setPaystackData()
            ->setAmount($amount);
        $em->persist($transactionEntity);
        $em->flush();


        return $data;
        // } else {
        //     throw new \Exception("Could not get transaction status");
        // }
    }

    public function verifyTrasaction($data)
    {
        $endPoint = "{$this->baseEndpoint}/transaction/verify/" . $data["reference"];
        $em = $this->entityManager;
        $client = new Client();
        $headers["Content-Type"] = "application/json";
        //         $getBody = [
        //             "transactionReference"=>$data["transactionReference"],
        //         ];
        $headers["Authorization"] = "Bearer " . $this->secretKey;
        $client->setHeaders($headers);
        $client->setMethod("GET");
        //         $client->setParameterGet($getBody);
        $client->setUri($endPoint);

        $response = $client->send();
        // var_dump()
        if ($response->isSuccess()) {
            // send transaction email here
            // update transaction statusand 
            $decodedData = Json::decode($response->getBody());
            /**
             * @var Transaction
             */
            $transactionEntity = $em->getRepository(Transaction::class)->findOneBy([
                "transactionId" => $data["reference"]
            ]);

            if (filter_var($decodedData->status, FILTER_VALIDATE_BOOL)) {

                $transactionEntity->setUpdatedOn(new \Datetime())->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_COMPLETED));


                // create Active user Training f
                $buyCourseSession = new Container("buy_course_uuid");
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
            } else {
                $transactionEntity->setUpdatedOn(new \Datetime())->setStatus($em->find(TransactionStatus::class, TransactionService::TRANSACTION_STATUS_FAILED));
                $em->persist($transactionEntity);
                $em->flush();
                throw new \Exception("Payment was not completed");
            }
            
        } 
        else {
            throw new \Exception($response);
        }
    }

    public function getPaystackConfig()
    {
        return [
            "public_key" => $this->publicKey,
            "secret_key" => $this->secretKey,
        ];
    }

    /**
     * Get the value of publicKey
     *
     * @return  string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set the value of publicKey
     *
     * @param  string  $publicKey
     *
     * @return  self
     */
    public function setPublicKey(string $publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * Get the value of secretKey
     *
     * @return  string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Set the value of secretKey
     *
     * @param  string  $secretKey
     *
     * @return  self
     */
    public function setSecretKey(string $secretKey)
    {
        $this->secretKey = $secretKey;

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
     * Get the value of generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     * Set the value of generalService
     *
     * @return  self
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;

        return $this;
    }

    /**
     * Get the value of baseEndpoint
     */
    public function getBaseEndpoint()
    {
        return $this->baseEndpoint;
    }

    /**
     * Set the value of baseEndpoint
     *
     * @return  self
     */
    public function setBaseEndpoint($baseEndpoint)
    {
        $this->baseEndpoint = $baseEndpoint;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  PostMarkService
     */
    public function getPostmarkService()
    {
        return $this->postmarkService;
    }

    /**
     * Set undocumented variable
     *
     * @param  PostMarkService  $postmarkService  Undocumented variable
     *
     * @return  self
     */
    public function setPostmarkService(PostMarkService $postmarkService)
    {
        $this->postmarkService = $postmarkService;

        return $this;
    }
}
