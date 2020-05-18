<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Idea;
use App\Form\IdeaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends AbstractController
{
    /**
     * @Route("/idea/list", name="idea_list")
     */
    public function list(EntityManagerInterface $em)
    {
        $repo = $em->getRepository('App:Idea');

        $ideas = $repo->findAll();

        return $this->render('idea/list.html.twig', [
            'ideas' => $ideas,
        ]);
    }

    /**
     * @Route("/idea/detail/{id}", name="idea_detail",
     *     requirements={"id":"\d+"})
     */
    public function detail(EntityManagerInterface $em, $id)
    {
        $repo = $em->getRepository(Idea::class);

        $idea = $repo->find($id);

        return $this->render('idea/detail.html.twig',[
            "idea" => $idea,
        ]);
    }

    /**
     * @Route("/idea/add", name="idea_add")
     */
    public function add(EntityManagerInterface $em, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $idea = new Idea();
        $idea->setDateCreated(new \DateTime());
        $idea->setIsPublished(true);
        $idea->setAuthor($this->getUser()->getUsername());

        $ideaForm = $this->createForm(IdeaType::class,$idea);

        $ideaForm->handleRequest($request,$idea);

        if ($ideaForm->isSubmitted() && $ideaForm->isValid()){
            $em->persist($idea);

            $em->flush();

            $this->addFlash('success',"Idea successfully added!");
            return $this->redirectToRoute('idea_detail', [
                'id' => $idea->getId()
            ]);
        }

        return $this->render('idea/add.html.twig', [
            'ideaForm' => $ideaForm->createView(),
        ]);
    }
}
