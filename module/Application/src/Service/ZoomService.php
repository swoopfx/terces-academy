<?php

namespace  Application\Service;

use Application\Entity\ActiveBusinessMasterclassCohort;
use Application\Entity\ActiveUserProgram;
use Application\Entity\InternshipCohort;
use Application\Entity\MasterClassCohort;
use Application\Entity\P6FreeCohort;
use Application\Entity\Programs;
use Application\Entity\ZoomMeetingResponse;
use Doctrine\ORM\EntityManager;
use General\Service\PostMarkService;
use Laminas\Http\Client;
use Laminas\Http\Request;
use Ramsey\Uuid\Uuid;

class ZoomService
{

    /**
     * Undocumented variable
     * 
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * Zoom Token response
     *
     * @var array
     */
    private $zoomTokenRes;

    /**
     * Undocumented variable
     *
     * @var []
     */
    private $zoomConfig;

    /**
     * Undocumented variable
     *
     * @var array
     */
    private $config;

    /**
     * Undocumented variable
     *
     * @var PostMarkService
     */
    private PostMarkService $postmarkService;



    /**
     * Undocumented function
     *
     * @param array $data || agenda, user_email, date_time , duration
     * @return void
     */
    public function createMeeting(array $data)
    {
        $token = $this->zoomTokenRes;
        $em = $this->entityManager;
        $client = new Client();
        $client->setMethod(Request::METHOD_POST);
        // $meetingDatime =  new \DateTime('2011-12-25 13:00:00');
        $meetingDatime =  $data["date_time"];
        $meetingDatime->setTimezone(new \DateTimeZone('UTC'));
        $meetingDatime->format('Y-m-d\TH:i:s\Z');
        $startDate = date_format($meetingDatime, 'Y-m-d\TH:i:s\Z');

        // var_dump($startDate);

        // Change the timezone to GMT.

        $activeBusinessMasterClassCohort = $em->getRepository(ActiveUserProgram::class)
            ->createQueryBuilder("a")
            ->select("u.email")
            ->innerJoin("a.user", "u")
            ->where("a.program = :program")->setParameters([
                "program" => $data["program"]
            ])->getQuery()->getScalarResult();



        $client->setUri($this->zoomConfig["base_url"] . "/users/me/meetings");
        $client->setHeaders([
            "Authorization" => "Bearer {$token["access_token"]}",
            "Content-Type" => "application/json"
        ]);
        $body = [
            "agenda" => $data["agenda"],
            "default_password" => false,
            "duration" => str_replace("min", "", $data["duration"]),
            "password" => "123456",
            "pre_schedule" => false,
            "schedule_for" => "Teeveyan@yahoo.com",

            "settings" => [
                // "additional_data_center_regions" => [
                //     "TY"
                // ],
                "allow_multiple_devices" => true,
                "alternative_hosts" => "Teeveyan@yahoo.com;app@tercesjobs.com",
                "alternative_hosts_email_notification" => true,
                "approval_type" => 2,
                // "approved_or_denied_countries_or_regions" => [
                //     "approved_list" => [
                //         "CX"
                //     ],
                //     "denied_list" => [
                //         "CA"
                //     ],
                //     "enable" => true,
                //     "method" => "approve"
                // ],
                "audio" => "both",
                // "audio_conference_info" => "test",
                // "authentication_domains" => "example.com",
                // "authentication_exception" => [
                //     [
                //         "email" => "jchill@example.com",
                //         "name" => "Jill Chill"
                //     ]
                // ],
                // "authentication_option" => "signIn_D8cJuqWVQ623CI4Q8yQK0Q",
                "auto_recording" => "none",
                // "breakout_room" => [
                //     "enable" => true,
                //     "rooms" => [
                //         [
                //             "name" => "room1",
                //             "participants" => [
                //                 "jchill@example.com"
                //             ]
                //         ]
                //     ]
                // ],
                "calendar_type" => 1,
                "close_registration" => false,
                "contact_email" => $data["user_email"],
                "contact_name" => $data["user_name"],
                "email_notification" => true,
                "encryption_type" => "enhanced_encryption",
                "focus_mode" => true,
                // "global_dial_in_countries" => [
                //     "US"
                // ],
                "host_video" => false,
                "jbh_time" => 5,
                "join_before_host" => true,
                // "language_interpretation" => [
                //     "enable" => true,
                //     "interpreters" => [
                //         [
                //             "email" => "interpreter@example.com",
                //             "languages" => "US,FR"
                //         ]
                //     ]
                // ],
                // "sign_language_interpretation" => [
                //     "enable" => true,
                //     "interpreters" => [
                //         [
                //             "email" => "interpreter@example.com",
                //             "sign_language" => "American"
                //         ]
                //     ]
                // ],
                "meeting_authentication" => false,
                "meeting_invitees" => [
                    [
                        "email" => $data["user_email"],
                    ]
                ],
                "mute_upon_entry" => true,
                "participant_video" => false,
                "private_meeting" => true,
                "registrants_confirmation_email" => true,
                "registrants_email_notification" => true,
                "registration_type" => 1,
                "show_share_button" => false,
                "use_pmi" => false,
                "waiting_room" => false,
                "watermark" => false,
                "host_save_video_order" => true,
                "alternative_host_update_polls" => true,
                "internal_meeting" => false,
                // "continuous_meeting_chat" => [
                //     "enable" => true,
                //     "auto_add_invited_external_users" => true
                // ],
                "participant_focused_meeting" => false,
                "push_change_to_calendar" => false,
                // "resources" => [
                //     [
                //         "resource_type" => "whiteboard",
                //         "resource_id" => "X4Hy02w3QUOdskKofgb9Jg",
                //         "permission_level" => "editor"
                //     ]
                // ]
            ],
            "start_time" => $startDate, //$data["date_time"],
            "timezone" => "UTC",
            "topic" => $data["agenda"],
            "tracking_fields" => [],
            "type" => 2


        ];
        $client->setRawBody(json_encode($body));
        // $client->setParameterPost($body);
        $response = $client->send();
        if ($response->isSuccess()) {
            $zoomResponse = json_decode($response->getBody());
            // hydrate into data base
            // var_dump($bodi);
            // $zoomResponse = $bodi;
            try {
                // var_dump($zoomResponse->title);
                // print_r($zoomResponse);
                // exit();
                // $zoomResponse = $bodi->response;
                // $zoomResponseSerialized = json_encode($zoomResponse);
                $zoomEntity = new ZoomMeetingResponse();
                $zoomEntity->setCreatedOn(new \Datetime())
                    ->setUuid(Uuid::uuid4()->toString())
                    // ->setZoomAssitantId($zoomResponse->assistant_id)
                    ->setZoomTitle($zoomResponse->topic)
                    ->setZoomStartTime($zoomResponse->start_time)
                    ->setZoomDuration($zoomResponse->duration)
                    ->setZoomTimeZone($zoomResponse->timezone)
                    ->setProgram($em->find(Programs::class, $data["program"]))
                    ->setZoomResponse(json_encode($zoomResponse))
                    ->setZoomRegUrl($zoomResponse->start_url)
                    ->setZoomJoinUrl($zoomResponse->join_url)
                    ->setZoomEncryptPassword($zoomResponse->encrypted_password)
                    ->setZoomPassword($zoomResponse->pstn_password)
                    ->setZoomId($zoomResponse->id)
                    ->setZoomhostId($zoomResponse->host_id)
                    ->setZoomUuid($zoomResponse->uuid);

                $registeredUsers = [];
                $arrayEmail = [];
                if ($data["program"] == 4) {
                    // Free master class
                    $zoomEntity->setFreeBusinessMasterClassCohort($em->find(MasterClassCohort::class, $data["cohort"]));
                    $activeBusinessMasterClassCohort = $em->getRepository(ActiveBusinessMasterclassCohort::class)->findBy([
                        "cohort" => $data["cohort"],
                    ]);
                    if (count($activeBusinessMasterClassCohort) == 1) {
                        $activeBusinessMasterClassCohort = $em->getRepository(ActiveUserProgram::class)
                            ->createQueryBuilder("a")
                            ->select("u.email")
                            ->innerJoin("a.user", "u")
                            ->where("a.program = :program")->setParameters([
                                "program" => $data["program"]
                            ])->getQuery()->getScalarResult();

                        $emails = array_map('current',  $activeBusinessMasterClassCohort);

                        if (count($emails) > 50) {
                            $arrayEmail = array_chunk($emails, 49);
                        } else {
                            $arrayEmail = $emails;
                        }
                        // $stringEmail = implode(', ', $emails);
                    }
                } elseif ($data["program"] == 10) {
                    // Business Analysis Work Experience Program
                    $zoomEntity->setBusinessAnalysisCohort($em->find(InternshipCohort::class, $data["cohort"]));
                } elseif ($data["program"] ==  50) {
                    // Free ORACLE Masterclass
                    $zoomEntity->setFreeOracleCohort($em->find(P6FreeCohort::class, $data["cohort"]));
                }

                $zoomMailData["to"] = $data["user_email"];

                $zoomMailData["join"] = $zoomResponse->join_url;
                $zoomMailData["topic"] = $zoomResponse->topic;
                $zoomMailData["start_time"] = date('F jS, Y h:i:s A', strtotime($zoomResponse->start_time)) . " {$zoomResponse->timezone} timezone";
                $zoomMailData["meeting_id"] = $zoomResponse->id;
                $zoomMailData["password"] = $zoomResponse->pstn_password;

                if (count($emails) > 50) {
                    foreach ($arrayEmail as $mail) {
                        $zoomMailData["bcc"] = implode(', ', $mail);
                        $this->postmarkService->manySendZoomMeetingNotification($zoomMailData);
                    }
                } else {
                    $zoomMailData["bcc"] = implode(', ', $arrayEmail);
                    $this->postmarkService->manySendZoomMeetingNotification($zoomMailData);
                }



                $em->persist($zoomEntity);
                $em->flush();


                return $zoomEntity;
            } catch (\Throwable $th) {
                throw new \Exception($th->getMessage());
            }
        } else {
            throw new \Exception($response->getReasonPhrase());
        }
    }


    public function resendZoomEvent($data)
    {
        $em = $this->entityManager;
        $activeCohort = '';
        $arrayEmail = [];
        if ($data["program"] == 4) {
            $activeCohort = "freeBusinessMasterClassCohort";
            $activeBusinessMasterClassCohort = $em->getRepository(ActiveBusinessMasterclassCohort::class)->findBy([
                "cohort" => $data["cohort"],
            ]);

            if (count($activeBusinessMasterClassCohort) == 1) {
                $activeBusinessMasterClassCohort = $em->getRepository(ActiveUserProgram::class)
                    ->createQueryBuilder("a")
                    ->select("u.email")
                    ->innerJoin("a.user", "u")
                    ->where("a.program = :program")->setParameters([
                        "program" => $data["program"]
                    ])->getQuery()->getScalarResult();

                $emails = array_map('current',  $activeBusinessMasterClassCohort);

                if (count($emails) > 50) {
                    $arrayEmail = array_chunk($emails, 49);
                } else {
                    $arrayEmail = $emails;
                }
                // $stringEmail = implode(', ', $emails);
            }
        } elseif ($data["program"] == 10) {
        }
        /**
         * @var []
         */
        $zoomResponse = $em->getRepository(ZoomMeetingResponse::class)->findBy([
            "program" => $data["program"],
            $activeCohort => $data["cohort"]
        ]);
        if (count($zoomResponse) == 0) {
            throw new \Exception("No Zoom Meeting availaible");
        }
        $zoomResponse = $zoomResponse[0];
        $zoomMailData["to"] = "app@tercesjobs.com";

        $zoomMailData["join"] = $zoomResponse->getZoomJoinUrl();
        $zoomMailData["topic"] = $zoomResponse->getZoomTitle();
        $zoomMailData["start_time"] = date('F jS, Y h:i:s A', strtotime($zoomResponse->getZoomStartTime())) . " {$zoomResponse->getZoomTimezone()} timezone";
        $zoomMailData["meeting_id"] = $zoomResponse->getZoomId();
        $zoomMailData["password"] = $zoomResponse->getZoomPassword();

        if (count($emails) > 50) {
            foreach ($arrayEmail as $mail) {
                $zoomMailData["bcc"] = implode(', ', $mail);
                $this->postmarkService->manySendZoomMeetingReminder($zoomMailData);
            }
        } else {
            $zoomMailData["bcc"] = implode(', ', $arrayEmail);
            $this->postmarkService->manySendZoomMeetingReminder($zoomMailData);
        }
    }


    public function assignMeetingTouser()
    {
    }

    public function deleteMeeting()
    {
    }

    public function updateMeeting()
    {
    }

    /**
     * Set undocumented variable
     *
     * @param  array  $zoomTokenRes  Undocumented variable
     *
     * @return  self
     */
    public function setZoomTokenRes(array $zoomTokenRes)
    {
        $this->zoomTokenRes = $zoomTokenRes;

        return $this;
    }

    /**
     * Set undocumented variable
     *
     * @param  array  $config  Undocumented variable
     *
     * @return  self
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Set undocumented variable
     *
     * @param  array  $zoomConfig  Undocumented variable
     *
     * @return  self
     */
    public function setZoomConfig(array $zoomConfig)
    {
        $this->zoomConfig = $zoomConfig;

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
