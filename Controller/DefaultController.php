<?php

namespace AW\Bundle\CollectVerifiedEmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AW\Bundle\CollectVerifiedEmailBundle\Entity\Email;

class DefaultController extends Controller
{
    /**
     * HTTP param: email: email address to verify.
     * HTTP param: continue: where to redirect to after authenticating.
     */
    public function submitAction(Request $request)
    {
        $this->requireContinueParam($request);

        $email = $request->get('email');
        if (!$email) {
            throw new \AW\Bundle\CollectVerifiedEmailBundle\Exception('Email address required');
        }
        $request->getSession()->set('collected_email', $email);

        $emailObj = $this->getDoctrine()->getRepository('AWCollectVerifiedEmailBundle:Email')
                ->findOneByEmail($email);

        if ($emailObj && $emailObj->getVerified()) {
            // This email address is already verified.
            $request->getSession()->setFlash('notice', $this->get('translator')->trans('Your address has been verified'));
            return $this->redirect($request->get('continue'));
        } else if (!$emailObj) {
            // Haven't seen this email address before.
            $emailObj = new Email($email);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($emailObj);
            $em->flush();
        }

        // Send verification email.
        // @todo
        // Take user back to the continue URL.
        $request->getSession()->setFlash('notice', $this->get('translator')->trans('We have sent you an email - click the link inside it to verify your email address...'));
        return $this->redirect($request->get('continue'));
    }

    /**
     * HTTP param: id
     * HTTP param: token
     */
    public function verifyAction(Request $request)
    {
        $email = $this->getDoctrine()->getRepository('AWCollectVerifiedEmailBundle:Email')
                ->find($request->get('id'));

        if (!$email) {
            return $this->createNotFoundException();
        }

        if ($email->isVerifyTokenCorrect($request->get('token'))) {
            $email->setVerified(true);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($email);
            $em->flush();
            return $this->render('AWCollectVerifiedEmailBundle:Default:success.html.twig', array('email' => $email));
        } else {
            return $this->render('AWCollectVerifiedEmailBundle:Default:fail.html.twig', array('email' => $email));
        }
    }

    private function requireContinueParam(Request $request)
    {
        if (!$request->get('continue')) {
            throw new \AW\Bundle\CollectVerifiedEmailBundle\Exception('No continue parameter in the request query string');
        }
    }
}
