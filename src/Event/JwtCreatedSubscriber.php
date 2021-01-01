<?php


namespace App\Event;


use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber
{
    /**
     * @var UserRepository
     */
    private UserRepository $user;

    public function __construct(UserRepository $user){
        $this->user = $user;
    }
    public function updateJwtData(JWTCreatedEvent $event)
    {

        // On enrichit le data du Token
        $data = $event->getData();
        $res = $this->user->findBy(['username'=>$data['username']]);
        $data['archived'] =$res[0]->getStatus();
        $data['id'] =  $res[0]->getId();

        $event->setData($data);
    }
}
