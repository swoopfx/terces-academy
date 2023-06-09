<?php


namespace Authentication\Controller;

// use AuthentiicationServic

use Doctrine\ORM\EntityManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\SessionManager;
use Laminas\View\Model\ViewModel;
use Application\Entity\User;
use Application\Service\UserService;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Identical;
use Laminas\View\Model\JsonModel;
use Application\Service\MailService;
use Application\Service\MailtrapService;



class AuthController  extends AbstractActionController
{


    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $entityManager;


    /**
     * Undocumented variable
     *
     * @var AuthenticationService
     */
    private $authService;

    public function loginjsonAction()
    {

        // $data = $inputFilter->getValues();
        $user = $this->identity();
        if ($user) {
            return $this->redirect()->toRoute("home");
        }
        $jsonModel = new JsonModel();
        $response = $this->getResponse();
        // $data = $inputFilter->getValues();

        $uri = $this->getRequest()->getUri();

        $fullUrl = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        // use the generated controllerr plugin for the redirection

        // $form = $this->loginForm->createUserForm($this->userEntity, 'login');
        $messages = null;
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = $request->getPost()->toArray();
            $inputFilter = new InputFilter();
            $inputFilter->add(array(
                'name' => 'email',
                'required' => true,
                'allow_empty' => false,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Phone number or email is required'
                            )
                        )
                    )
                )
            ));

            $inputFilter->add(array(
                'name' => 'password',
                'required' => true,
                'allow_empty' => false,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Password is required'
                            )
                        )
                    )
                )
            ));

            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                $data = $inputFilter->getValues();

                $authService = $this->authService;
                $adapter = $authService->getAdapter();
                $email = $data["email"];

                try {
                    $user = $this->entityManager->createQuery("SELECT u FROM  Application\Entity\User u WHERE u.email = '$email' ")->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);

                    // $user = $this->user->selectUserDQL($phoneOrEmail);
                    if (count($user) == 0) {
                        $response->setCustomStatusCode(498);
                        $response->setReasonPhrase('Invalid token!');
                        return $jsonModel->setVariables([
                            "messages" => "The username or email is not valid!"
                        ]);
                    } else {
                        $user = $user[0];
                    }

                    // var_dump($user);
                    // var_dump($user);
                    // if ($user == NULL) {

                    // $messages = 'The username or email is not valid!';
                    // // return new ViewModel(array(
                    // // 'error' => $this->translatorHelper->translate('Your authentication credentials are not valid'),
                    // // 'form' => $form,
                    // // 'messages' => $messages,
                    // // 'navMenu' => $this->options->getNavMenu()
                    // // ));

                    // $response->setStatusCode(Response::STATUS_CODE_422);
                    // return $jsonModel->setVariables([
                    // "messages" => $messages
                    // ]);
                    // }
                    // if (! $user->getEmailConfirmed() == 1) {
                    //     $messages = $this->translatorHelper->translate('You are yet to confirm your account, please go to the registered email to confirm your account');
                    //     $response->setStatusCode(Response::STATUS_CODE_422);
                    //     return $jsonModel->setVariables([
                    //         "messages" => $messages
                    //     ]);
                    // }
                    if (!$user->getIsActive()) {
                        $messages = 'Your username is disabled. Please contact an administrator.';
                        $response->setStatusCode(Response::STATUS_CODE_422);
                        return $jsonModel->setVariables([
                            "messages" => $messages
                        ]);
                    }

                    $adapter->setIdentity($user->getEmail());
                    $adapter->setCredential($data["password"]);

                    $authResult = $authService->authenticate();
                    // $class_methods = get_class_methods($adapter);
                    // echo "<pre>";print_r($class_methods);exit;

                    if ($authResult->isValid()) {
                        $identity = $authResult->getIdentity();
                        $authService->getStorage()->write($identity);

                        // Last Login Date
                        // $this->lastLogin($this->identity());
                        $userEntity = $this->identity();
                        if ($this->params()->fromPost('rememberme')) {
                            $time = 1209600; // 14 days (1209600/3600 = 336 hours => 336/24 = 14 days)
                            $sessionManager = new SessionManager();
                            $sessionManager->rememberMe($time);
                        }

                        // var_dump($this->identity());
                        /**
                         * At this region check if the user varible isProfiled is true
                         * If it is true make sure continue with the login
                         * If it is false branch into the condition get the user role mand seed it to
                         * the userProfile Sertvice
                         * to display the required form to fill the profile
                         * if required redirect to the copletinfg profile Page
                         */
                        $redirect = $fullUrl . "/admin";

                        $response->setStatusCode(201);
                        $jsonModel->setVariables([
                            "redirect" => $redirect
                        ]);
                        $jsonModel->setVariables([]);
                        return $jsonModel;
                        // return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
                    } else {
                        $messages = 'Invalid Credentials';
                        $response->setStatusCode(Response::STATUS_CODE_422);
                        return $jsonModel->setVariables([
                            "messages" => $messages
                        ]);
                    }

                    foreach ($authResult->getMessages() as $message) {
                        $messages .= "$message\n";
                    }
                } catch (\Exception $e) {
                    // echo "Something went wrong";
                    // return $this->errorView->createErrorView($this->translatorHelper->translate('Something went wrong during login! Please, try again later.'), $e, $this->options->getDisplayExceptions(), $this->options);
                    // ->getNavMenu();
                    $response->setStatusCode(Response::STATUS_CODE_400);
                    return $jsonModel->setVariables([
                        "messages" => 'Something went wrong during login! Please, try again later.',
                        "data" => $e->getMessage(),
                    ]);
                }
            }
        }

        $response->setStatusCode(Response::STATUS_CODE_500);
        $jsonModel->setVariables([
            'messages' => "Some thing went wrong"
        ]);
        return $jsonModel;

        // 'navMenu' => $this->options->getNavMenu()
    }

    public function resetPasswordAction()
    {
        $viewmodel = new ViewModel();
        return $viewmodel;
    }

    public function resetAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();

        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost();
            $email = $post["email"];
            /**
             * @var User
             */
            $userEntity = $this->entityManager->getRepository(User::class)->findOneBy([
                "email" => $email
            ]);
            if ($userEntity == null) {
                $response->setStatusCode(423);
                return $jsonModel;
            } else {
                try {
                    // generate new Token 
                    $token = md5(uniqid(mt_rand(), true));
                    // Hy
                    $userEntity->setRegistrationToken($token)->setUpdatedOn(new \Datetime());

                    $fullLink = $this->getBaseUrl() . $this->url()->fromRoute('admin-auth', array(
                        'action' => 'newpassword',
                        'id' => $userEntity->getRegistrationToken()

                    ));

                    // send email

                    $this->entityManager->persist($userEntity);
                    $mailData["to"] = $userEntity->getEmail();
                    $mailData["subject"] = "AIB Reset Password";
                    $mailData["toName"] = $userEntity->getFullname();
                    $mailData["template"] = "reset-password-mail";
                    $mailData["fulllink"] = $fullLink;
                    // $mailData["var"] = [
                    //     "link" => $fullLink
                    // ];

                    // $this->mailService->execute($mailData);

                    $this->mailtrap->passwordResetMail($mailData);

                    $this->entityManager->flush();
                    $response->setStatusCode(201);
                } catch (\Throwable $th) {
                    $response->setStatusCode(400);
                    $jsonModel->setVariables([
                        "messages" => $th->getMessage(),
                        "data" => $th->getTrace()
                    ]);
                }
            }
        }
        return $jsonModel;
    }

    public function newpasswordAction()
    {
        $viewmodel = new ViewModel();
        $jsonmodel = new JsonModel();
        $response = $this->getResponse();
        $token = $this->params()->fromRoute('id');
        try {
            $entityManager = $this->entityManager;
            // if ($token !== '' && $user = $entityManager->getRepository(User::class)->findOneBy(array(
            //     'registrationToken' => $token
            // ))) {
            $request = $this->getRequest();
            if ($request->isPost()) {
                $post = $request->getPost();
                // var_dump($post);
                $inputFilter = new InputFilter();

                $inputFilter->add(array(
                    'name' => 'password',
                    'required' => true,
                    'allow_empty' => false,
                    'filters' => array(
                        array(
                            'name' => 'StripTags'
                        ),
                        array(
                            'name' => 'StringTrim'
                        )
                    ),
                    'validators' => array(
                        array(
                            'name' => 'NotEmpty',
                            'options' => array(
                                'messages' => array(
                                    'isEmpty' => 'password is required'
                                )
                            )
                        )
                    )
                ));

                $inputFilter->add(array(
                    'name' => 'token',
                    'required' => true,
                    'allow_empty' => false,
                    'filters' => array(
                        array(
                            'name' => 'StripTags'
                        ),
                        array(
                            'name' => 'StringTrim'
                        )
                    ),
                    'validators' => array(
                        array(
                            'name' => 'NotEmpty',
                            'options' => array(
                                'messages' => array(
                                    'isEmpty' => 'Token is required'
                                )
                            )
                        )
                    )
                ));

                $inputFilter->add(array(
                    'name' => 'verifypassword',
                    'required' => true,
                    'allow_empty' => false,
                    'filters' => array(
                        array(
                            'name' => 'StripTags'
                        ),
                        array(
                            'name' => 'StringTrim'
                        )
                    ),
                    'validators' => array(
                        array(
                            'name' => 'NotEmpty',
                            'options' => array(
                                'messages' => array(
                                    'isEmpty' => 'Verified Password is required'
                                )
                            )
                        ),
                        array(
                            'name' => 'Identical',
                            'options' => array(
                                'token' => 'password',
                                "messages" => array(
                                    Identical::NOT_SAME => "The Passwords are not identical"
                                )
                            )
                        )
                    )
                ));
                $inputFilter->setData($post);
                if ($inputFilter->isValid()) {
                    $data = $inputFilter->getValues();
                    /**
                     * @var User
                     */
                    $userEntity = $entityManager->getRepository(User::class)->findOneBy(array(
                        'registrationToken' => $data["token"]
                    ));
                    if ($userEntity) {
                        $userEntity->setPassword(UserService::encryptPassword($data["password"]))->setUpdatedOn(new \Datetime());

                        $entityManager->persist($userEntity);
                        $entityManager->flush();

                        // Send a success mail

                        // return $this->redirect()->toRoute("login");
                        $response->setStatusCode(201);
                        // $jsonmodel->setVariables([

                        // ]);
                        return  $jsonmodel;
                    }
                } else {
                    $response->setStatusCode(400);
                    $jsonmodel->setVariables([
                        "messages" => $inputFilter->getMessages()
                    ]);
                    return  $jsonmodel;
                }
            }
            // }
        } catch (\Throwable $th) {
            //throw $th;
            $response->setStatusCode(400);
            $jsonmodel->setVariables([
                "messages" => $th->getMessage()
            ]);
            return  $jsonmodel;
        }

        $viewmodel->setVariables([
            // "data"=>[
            "token" => $token,

            // ]
        ]);
        return $viewmodel;
    }



    // public function submitnewPasswordAction(){
    //     $jsonModel = new JsonModel();
    //     $request = $this->getRequest();
    //     if ($request->isPost()) {
    //         // $post 
    //     }
    //     return $jsonModel;
    // }

    /**
     * Confirm Email Change Action
     *
     * Confirms password change through given token
     *
     * @return Laminas\View\Model\ViewModel
     */
    public function confirmEmailChangePasswordAction()
    {
        $token = $this->params()->fromRoute('id');
        try {
            $entityManager = $this->entityManager;
            if ($token !== '' && $user = $entityManager->getRepository(User::class)->findOneBy(array(
                'registrationToken' => $token
            ))) {
                $user->setRegistrationToken(md5(uniqid(mt_rand(), true)));
                $password = $this->generatePassword();
                $user->setPassword(UserService::encryptPassword($password));
                $email = $user->getEmail();
                $fullLink = $this->getBaseUrl() . $this->url()->fromRoute('user-index', array(
                    'action' => 'login'
                ));

                // send email here
                // $this->sendEmail($user->getEmail(), 'Your password has been changed!', sprintf($this->translator->translate('Hello again %s. Your new password is: %s. Please, follow this link %s to log in with your new password.'), $user->getUsername(), $password, $fullLink));

                $entityManager->persist($user);
                $entityManager->flush();

                $viewModel = new ViewModel(array(
                    'email' => $email,

                ));
                return $viewModel;
            } else {
                return $this->redirect()->toRoute('admin');
            }
        } catch (\Exception $e) {
            // return $this->getServiceLocator()->get('csnuser_error_view')->createErrorView(
            // $this->getTranslatorHelper()->translate('An error occured during the confirmation of your password change! Please, try again later.'),
            // $e,
            // $this->options->getDisplayExceptions(),
            // $this->options->getNavMenu()
            // );
        }
    }


    public function logoutAction()
    {
        $auth = $this->authService;
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
            $sessionManager = new SessionManager();
            $sessionManager->forgetMe();
            $sessionManager->destroy();
        }

        return $this->redirect()->toRoute("login");
    }

    private function getBaseUrl()
    {
        $uri = $this->getRequest()->getUri();
        return sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
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
}
