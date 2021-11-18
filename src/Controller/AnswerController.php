<?php

namespace App\Controller;

use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController {
	/**
	 * @Route("/answers/{id}/vote", methods="POST", name="answer_vote")
	 */
	public function answerVote(Answer $answer, LoggerInterface $logger, Request $request, EntityManagerInterface $em) {
		$data = json_decode($request->getContent(), true);
		$direction = $data['direction'] ?? 'up';

		// todo - use id to query the database

		// use real logic here to save this to the database
		if ($direction === 'up') {
			$logger->info('Voting up!');
			$answer->setVotes($answer->getVotes() + 1);
		} else {
			$logger->info('Voting down!');
			$answer->setVotes($answer->getVotes() - 1);
		}

		$em->flush();

		return $this->json(['votes' => $answer->getVotes()]);
	}

  /**
   * @Route("/answers/popular", name="app_popular_answers")
   */
	public function popularAnswers(){
    return $this->render('answer/popularAnswers.html.twig');
  }
}
