<?php 

namespace AppBundle\Service;

class HubApi
{
	
	public function getProfile($username) {

		  $client = new \GuzzleHttp\Client();
	      $response = $client->request('GET', 'https://api.github.com/users/'. $username);
	      $data = json_decode($response->getBody()->getContents(), true);

	       return [

                'avatar_url' => $data['avatar_url'],
                'name' => $data['name'],
                'login' => $data['login'],
                'details' => [
                    'company' => $data['company'],
                    'location' => $data['location'],
                    'joined_on' => 'Joined on ' . (new \DateTime($data['created_at']))->format('d-m-Y'),
                ],
                'blog' => $data['blog'],
                "social_data" => [
                    "Public Repos" => $data['public_repos'],
                    "Followers" => $data['followers'],
                    "Following" => $data['following'],
                ]
	       ];
	}

	public function getRepos($username) 
	{
		$client = new \GuzzleHttp\Client();
		$response = $client->request('GET', 'https://api.github.com/users/' . $username . '/repos');
		/*
		$response2 = $client->request('GET', 'https://api.github.com/users/' . $username . '/repos?page=2');
		
		$response3 = $client->request('GET', 'https://api.github.com/users/' . $username . '/repos?page=3');

		dump($response3);
		exit();
		*/
		//if !empty faire un while avec ?page=i


		$data = json_decode($response->getBody()->getContents(), true);
		//$data2 = json_decode($response2->getBody()->getContents(), true);


		return  [
					'username' => $username,
		            'repo_count' => count($data),
		            'most_stars' => array_reduce($data, function($mostStars, $currentRepo) {
		            	return $currentRepo['stargazers_count'] > $mostStars ? $currentRepo['stargazers_count'] : $mostStars;
		            }, 0),
		            'repos' => $data,
		            //'repos2' => $data2
            	];

	}
}