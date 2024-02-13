<?php

namespace  Application\Service;

use Laminas\Http\Client;

class ZoomService
{

    /**
     * Undocumented variable
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



    public function createMeeting($data)
    {
        $token = $this->zoomTokenRes;
        $client = new Client();
        $client->setUri($this->zoomConfig["base_url"] . "/users/me/meetings");
        $client->setHeaders([
            "Authorization" => "Bearer {$token["access_token"]}",
            "Content-Type" => "application/x-www-form-urlencoded",
        ]);
        $body = [
            "agenda" => "Career Talk",
            "default_password" => false,
            "duration" => 30,
            "password" => "Simple123@",
            "pre_schedule" => false,
            "schedule_for" => $data["user_email"],

            "settings" => [
                // "additional_data_center_regions" => [
                //     "TY"
                // ],
                "allow_multiple_devices" => true,
                // "alternative_hosts" => "jchill@example.com;thill@example.com",
                "alternative_hosts_email_notification" => true,
                "approval_type" => 0,
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
                // "auto_recording" => "cloud",
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
                "meeting_authentication" => true,
                "meeting_invitees" => [
                    [
                        "email" => $data["user_email"],
                    ]
                ],
                "mute_upon_entry" => false,
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
            "start_time" => $data["date_time"],
            "timezone" => "America/Montreal",
            "topic" => ""


        ];
        $client->setRawBody(json_encode($body));
        $response = $client->send();
        if ($response->isSuccess()) {
            $body = json_decode($response->getBody());
            return $body;
        } else {
            throw new \Exception("could not create the meeting");
        }
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
}
