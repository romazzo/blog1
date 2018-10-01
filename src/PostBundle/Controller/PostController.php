<?php

namespace PostBundle\Controller;


use PostBundle\Form\PostDeleteForm;
use PostBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PostBundle\Entity\Post;
use UserBundle\Entity\User;

class PostController extends Controller{

    public function listAction(Request $request){
		$pageRepo = $this->getDoctrine()->getRepository('PostBundle:Post');
        /** @var Post $pages  */
        $pager = $request->query->get('page') ? $request->query->get('page') : 1;
        $limit = 5;
        $pages = $pageRepo->findLastPosts($pager, $limit);
        $pager = [
            'pager' => $pager,
            'total' => $pageRepo->countPage(),
            'limit' => $limit
        ];
        return $this->render('PostBundle:Page:list.html.twig', [
                'pages' => $pages,
                'navigator' => $pager
            ]);
    }

    public function viewAction(Post $post){
        return $this->render('PostBundle:Page:view.html.twig', [
                'page' => $post
            ]);
    }

    public function addAction(Request $request){
        $post = new Post();
        $post->user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new PostType(), $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('page_view', ['id' => $post->getId()]);
        }
        $this->addFlash('success', 'Вы успешно добавили объявление!');
        return $this->render('PostBundle:Page:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $editForm = $em->getRepository('PostBundle:Post');
        $edit_post = $editForm->find($id);
        if(!$edit_post){
            return $this->redirectToRoute('page_list');
        }
        $form = $this->createForm(new PostType(), $edit_post);
        $form->add('createdAt');
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($edit_post);
            $em->flush();
            return $this->redirectToRoute('page_list', ['id' => $edit_post->getId()]);
        }
        $this->addFlash('success', 'Вы успешно обновили объявление!');
        return $this->render('PostBundle:Page:edit.html.twig', [
            'edit_form' => $form->createView()
        ]);
    }

    public function deleteAction(Post $post, Request $request){

        if($post === null){
            return $this->redirectToRoute('page_list');
        }
        if ($this->getUser()->getId() == $post->getUser()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
            $this->addFlash('success', 'Вы успешно удалили объявление!');
            return $this->redirectToRoute('page_list');
        }
    }

} 