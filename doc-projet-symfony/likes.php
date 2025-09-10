<?php
class User{
    private string $email;
    private array $livresLikes;
    private array $livresPossedes;

}

//aunter fichier

class Like{
    private User $user;
    private Attraction $attraction;
    private array $usersLikes;
    private array $userPossedes;

    public function __construct(User $user, Attraction $attraction){
        $this->user = $user;
        $this->attraction = $attraction;
        
    }
}