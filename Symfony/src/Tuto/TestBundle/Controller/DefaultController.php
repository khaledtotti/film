<?php

namespace Tuto\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function filtersAction() {

        return $this->render('TutoTestBundle:Default:filters.html.twig');
    }

    public function resultatAction() {
// for the request DBL
        $em = $this->getDoctrine()->getManager();
        // to get the value of the checkbox
        $checked_woman = $this->get('request')->request->get('woman_name');
        $checked_bechdel = $this->get('request')->request->get('button_bechdel');
        $checked_writer = $this->get('request')->request->get('woman_write');
        $checked_director = $this->get('request')->request->get('woman_direct');
        if (($checked_woman) && ($checked_bechdel)) {
            $query = $em->createQuery(
                    'SELECT p
    FROM TutoTestBundle:films p
    WHERE p.dialogueWomen > p.dialogueMen and p.bechdel>0 ORDER BY p.title'
            );

            $products = $query->getResult();
            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
        } else if ($checked_woman) {
            $query = $em->createQuery(
                    'SELECT p
    FROM TutoTestBundle:films p
    WHERE p.dialogueWomen > p.dialogueMen ORDER BY p.title'
            );

            $products = $query->getResult();
            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
        } else if ($checked_bechdel) {
            $query = $em->createQuery(
                    'SELECT p
    FROM TutoTestBundle:films p
    WHERE p.bechdel > 0 ORDER BY p.title'
            );

            $products = $query->getResult();
            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
        } else if ($checked_writer) {

            $query = $em
                    ->createQuery("select f
                        from TutoTestBundle:films f
                        , TutoTestBundle:writerfilm wf
                         , TutoTestBundle:writers w

                        where   f.id=wf.idFilm and w.id=wf.idWriter and w.gender = 'W' ORDER BY f.title
          ");

            $products = $query->getResult();
            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
        } else if ($checked_director) {

            $query = $em
                    ->createQuery("select f
                        from TutoTestBundle:films f
                        , TutoTestBundle:directorfilm df
                         , TutoTestBundle:Directors d

                        where   f.id=df.filmId and d.id=df.directorId and d.gender = 'W'

          ");

            $products = $query->getResult();
            return $this->render('TutoTestBundle:Default:resultat.html.twig', array(
                        'products' => $products));
        }




//..
        else {
            return $this->render('TutoTestBundle:Default:filters.html.twig')
            ;
        }
    }

}
