<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType ;
use App\Util\CalculateOutput;

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

            //get form data and extract numbers from each line
            $data = $form->getData();

            $values = trim($data['userInput']);
            $trimmedInputArr = explode("\n", $values);

            $calculatedOutput = array();
            $userInput = array();

            //import class from src/Util
            $CalculateOutput = new CalculateOutput();

            //add extracted numbers to the arrays
            foreach ($trimmedInputArr as $val) {
                //in the first case calculate the output before adding it to the array
                array_push($calculatedOutput, $CalculateOutput -> highestValueInSequence((int)$val));
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
