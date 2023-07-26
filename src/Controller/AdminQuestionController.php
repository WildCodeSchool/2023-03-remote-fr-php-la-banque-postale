<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Tutorial;
use App\Form\QuestionType;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/questions')]
class AdminQuestionController extends AbstractController
{
    #[Route('/', name: 'app_admin_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository, AnswerRepository $answerRepository): Response
    {
        return $this->render('/admin/admin_question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
            'answers' => $answerRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_admin_question_new', methods: ['GET', 'POST'])]
    public function new(Tutorial $tutorial, Request $request, QuestionRepository $questionRepository): Response
    {
        $question = new Question();
        $question->setTutorial($tutorial);

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_admin_tutorial_show', [
                'id' => $tutorial->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/admin/admin_question/new.html.twig', [
            'question' => $question,
            'form' => $form,
            'tutorial' => $tutorial,
        ]);
    }


    #[Route('/{id}', name: 'app_admin_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        return $this->render('/admin/admin_question/show.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_admin_tutorial_show', [
                'id' => $question->getTutorial()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/admin/admin_question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_admin_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        $tutorialId = $question->getTutorial()->getId();
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
        }

        return $this->redirectToRoute('app_admin_tutorial_show', [
            'id' => $tutorialId
        ], Response::HTTP_SEE_OTHER);
    }
}
