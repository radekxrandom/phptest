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
        ->add('userInput', TextareaType ::class)
        ->add('submit', SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            //functions needed to calculate the output
            //btw as I don't have much experience with symfony
            //I am not sure about the placement of these functions
            //i.e. shouldn't they be methods of MainController?

            function calcElementValue($index)
            {
                //for 0 return 0, for 1 and 2 return 1, afterwards use recursion to
                //"reduce" the number and calculate the result
                if ($index == 0) {
                    return 0;
                }

                if ($index == 1 || $index == 2) {
                    return 1;
                }

                if ($index % 2 == 0) {
                    return calcElementValue($index/2);
                }

                $index = ($index-1)/2;

                return calcElementValue($index) + calcElementValue($index+1);
            }


            function highestValueInSequence($n)
            {
                if ($n == 0) {
                    return "Input not valid.";
                }

                $highestValue = 0;
                for ($i=0; $i<$n; $i++, $n--) {
                    $currentElementValue = calcElementValue($n);
                    if ($currentElementValue > $highestValue) {
                        $highestValue = $currentElementValue;
                    }
                }

                return $highestValue;
            }

            //get form data and extract numbers from each line
            $data = $form->getData();

            $values = trim($data['userInput']);
            $trimmedInputArr = explode("\n", $values);

            $calculatedOutput = array();
            $userInput = array();

            //add extracted numbers to the arrays
            foreach ($trimmedInputArr as $val) {
                //in the first case calculate the output before adding it to the array
                array_push($calculatedOutput, highestValueInSequence((int)$val));
                array_push($userInput, $val);
            }

            //render template passing arrays with user input and calculated output
            return $this->render('main/index.html.twig', [
                'controller_name' => 'MainController', 'userInput' => $userInput,
                'calculatedOutput' => $calculatedOutput,'form' => $form->createView(),
            ]);
        }

        //if request doesn't contain submitted form (i.e. it isn't a post request)
        //render website without the table
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController', 'form' => $form->createView(),
             'calculatedOutput' => []
        ]);
    }
}
