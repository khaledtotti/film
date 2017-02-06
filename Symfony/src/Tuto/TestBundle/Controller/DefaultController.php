<?php

namespace Tuto\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function testAction() {
        $film = $this->getDoctrine()
                ->getRepository('TutoTestBundle:films')
                ->findall();

        return $this->render('TutoTestBundle:Default:filmview.html.twig', array(
                    'film' => $film));
    }

    public function filtersAction() {

        return $this->render('TutoTestBundle:Default:filters.html.twig');
    }

    public function resultatAction() {
// for the request DBL
        $em = $this->getDoctrine()->getManager();
        // to get the value of the checkbox
        $checked_woman = $this->get('request')->request->get('woman_name');
        $checked_bechdel = $this->get('request')->request->get('button_bechdel');
        $checked_direct = $this->get('request')->request->get('woman_write');
        $checked_write = $this->get('request')->request->get('woman_direct');
        if (($checked_woman) && ($checked_bechdel)) {
            $query = $em->createQuery(
                    'SELECT p
    FROM TutoTestBundle:films p
    WHERE p.dialogueWomen > p.dialogueMen and p.bechdel>0'
            );

            $products = $query->getResult();
            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
        } else if ($checked_woman) {
            $query = $em->createQuery(
                    'SELECT p
    FROM TutoTestBundle:films p
    WHERE p.dialogueWomen > p.dialogueMen'
            );

            $products = $query->getResult();
            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
        } else if ($checked_bechdel) {
            $query = $em->createQuery(
                    'SELECT p
    FROM TutoTestBundle:films p
    WHERE p.bechdel > 0'
            );

            $products = $query->getResult();
            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
        } else if ($checked_direct) {
            $e = $this->getDoctrine()->getManager();
            $qb = $e->createQueryBuilder();
            $qb
                    ->select('f.name')
                    ->from('Tuto\TestBundle\Entity\films', 'f')
                    ->leftJoin('f.idFilm', 'wf')
                    ->leftJoin('wf.idwriter', 'w')
                    ->where('w.gender = "a"');

            $query = $qb->getQuery();
            $products = $query->getResult();


            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
//..
        } else {
            return $this->render('TutoTestBundle:Default:filters.html.twig')
            ;
        }
    }

}
