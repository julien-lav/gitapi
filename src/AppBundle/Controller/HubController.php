<?php 

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class HubController extends Controller 
{
    /**
    * @Route("/{username}", name="hub", defaults={"username": "julien-lav"})
    */
    public function hubAction(Request $request, $username)
    {
       $this->get('hub_api')->getRepos($username);

        return $this->render('hub/index.html.twig', [
            'username' => $username,
        ]);
    } 

    /**
    * @Route("profile/{username}", name="profile")
    */
    public function profileAction(Request $request, $username) 
    {
        $profileData = $this->get('hub_api')->getProfile($username);

        return $this->render('hub/profile.html.twig', $profileData);

    }

    /**
    * @Route("/repos/{username}", name="repos")
    */
    public function reposAction(Request $request, $username)
    {
        $reposData = $this->get('hub_api')->getRepos($username);

        return $this->render('hub/repos.html.twig', $reposData);
    }

}