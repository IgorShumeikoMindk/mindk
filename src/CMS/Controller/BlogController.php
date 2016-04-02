<?php

namespace CMS\Controller;

use Framework\Controller\Controller;
use Blog\Model\Post;
use Framework\Validation\Validator;

class BlogController extends Controller{
    public function editAction($id)
    {
      if ($this->getRequest()->isPost()) {
              try{
                  $post          = new Post();
                  $date          = new \DateTime();
                  $post->id      = $id;
                  $post->title   = $this->getRequest()->post('title');
                  $post->content = trim($this->getRequest()->post('content'));
                  $post->date    = $date->format('Y-m-d H:i:s');

                  $validator = new Validator($post);
                  if ($validator->isValid()) {
                      $post->save();
                      return $this->redirect($this->generateRoute('home'), 'The data has been saved successfully');
                  } else {
                      $error = $validator->getErrors();
                  }
              } catch(DatabaseException $e){
                  $error = $e->getMessage();
              }
        }

      return $this->render('update.html', array('post' => Post::find($id), 'action' => $this->generateRoute('edit_post'), 'errors' => isset($error)?$error:null));
    }
}
?>
