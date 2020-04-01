<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType ;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {
        //I didn't think that form with one field
        //demanded usage of a form factory

        $form = $this->createFormBuilder()
        ->add('numbers', TextareaType ::class)
        ->add('submit', SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            //functions needed to calculate the output
            function countAn($n)
            {
                if ($n == 0) {
                    return 0;
                }

                if ($n == 1 || $n == 2) {
                    return 1;
                }

                if ($n % 2 == 0) {
                    return countAn($n/2);
                }

                $i = ($n-1)/2;
                return countAn($i) + countAn($i+1);
            }

            function getHighest($a)
            {
                $highest = 0;
                for ($i=0; $i<$a; $i++) {
                    $result = countAn($a);

                    if ($result > $highest) {
                        $highest = $result;
                    }
                    $a--;
                }
                return $highest;
            }

            //get form data and extract numbers from each line
            $data = $form->getData();

            $val = trim($data['numbers']);
            $textAr = explode("\n", $val);
            $textAr = array_filter($textAr, 'trim');

            //$arr - array with output vals, $secarr - one with user input
            $arr = array();
            $secarr = array();

            //add extracted numbers to the arrays
            foreach ($textAr as $line) {
                //in the first case calculate the output before adding it to the array
                array_push($arr, getHighest((int)$line));
                array_push($secarr, (int)$line);
            }

            //render template passing arrays with user input and calculated output
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController', 'inputdata' => $secarr, 'data' => $arr,'form' => $form->createView(),
            ]);
        }

        //if request doesn't contain submitted form (i.e. it isn't a post request)
        //render website without the table
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController', 'form' => $form->createView(), 'data' => 'not yet'
        ]);
    }
}
