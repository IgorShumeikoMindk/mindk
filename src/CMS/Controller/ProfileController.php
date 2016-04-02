<?php

namespace CMS\Controller;

use Framework\Controller\Controller;

class ProfileController extends Controller{
    public function updateAction()
    {
      return $this->render('profile.html', array('action' => $this->generateRoute('profile'), 'errors' => isset($error)?$error:null));
    }
    public function getAction()
    {
      //return $this->render('profile.html', array('action' => $this->generateRoute('profile'), 'errors' => isset($error)?$error:null));
    }
}
?>
