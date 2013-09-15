## Requirements ##

* Symfony 2.1. The bundle has not been tested in Symfony 2.0 but might work in that too.

* Swiftmailer bundle must be enabled. See http://symfony.com/doc/2.0/cookbook/email/email.html

## Sample Use In A Controller Action ##

    $email = $this->get('aw_collect_verified_email')->getEmailFromSession();
    // Email is of type \AW\Bundle\CollectVerifiedEmailBundle\Entity\Email.

    if ($email && $email->getVerified()) {
        return $this->redirect($this->generateUrl('your_page'));
    }

    $email = $request->get('email');
    if (!$email) {
        $this->setTranslatedFlashNotice('Please enter your email address...');
        return $this->redirect($this->generateUrl('your_page'));
    }

    return $this->redirect($this->generateUrl(
        'aw_collect_verified_email',
        array('email' => $email, 'continue' => $this->generateUrl('your_page'))
    ));

## Install ##

* If you use Git, run `git submodule add git@github.com:amyboyd/symfony2-collect-verified-emails-bundle.git path/to/bundles/AW/Bundle/CollectVerifiedEmailBundle`

* If you don't use Git, download the source and put it into your bundles
  directory.

* Enable AWCollectVerifiedEmailBundle in your `app/AppKernel.php`

* Copy the contents of `Resources/config/parameters.yml.sample` to your own `app/config/parameters.yml`

* Review `app/console doctrine:schema:update --dump-sql`

* Run `app/console doctrine:schema:update --force` if the above was OK.
