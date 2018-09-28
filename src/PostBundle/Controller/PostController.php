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
        return $this->render('PostBundle:Page:list.html.twig',
            [
                'pages' => $pages,
                'navigator' => $pager
            ]);
    }

    public function viewAction($id){
        $pageRepo = $this->getDoctrine()->getRepository('PostBundle:Post');
        $page = $pageRepo->find($id);
        if(!$page){
            throw $this->createNotFoundException('The page does not exist');
        }
        return $this->render('PostBundle:Page:view.html.twig',
            [
                'page' => $page
            ]);
    }

    public function addAction(Request $request){
        $post = new Post();
        $form = $this->createForm(new PostType(), $post);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            /** @var User $post_user  */
            $post_user = $form->getData();
            //var_dump($post_user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('page_view', ['id' => $post->getId()]);
        }
        return $this->render('PostBundle:Page:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PostBundle:Post');
        $edit_post = $repo->find($id);
        if(!$edit_post){
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(new PostType(), $edit_post);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($edit_post);
            $em->flush();
            return $this->redirectToRoute('page_list', ['id' => $edit_post->getId()]);
        }
        return $this->render('PostBundle:Page:edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function removeAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PostBundle:Post');
        $post = $repo->find($id);
        if(!$post){
            return $this->redirectToRoute('page_list');
        }
        $form = $this->createForm(new PostDeleteForm(), null, array( 'delete_id' => $post->getId() ) );
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->remove($post);
            $em->flush();
            return $this->redirectToRoute('page_list');
        }
        return $this->render('PostBundle:Page:delete.html.twig', [
            'form' => $form->createView()
        ]);
    }

} 