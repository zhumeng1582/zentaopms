<?php
declare(strict_types=1);

class feedback extends control
{
    public function index()
    {
        return $this->locate($this->createLink('feedback', 'browse'));
    }

    public function admin(string $browseType = 'all', int $productID = 0, string $orderBy = 'id_desc', int $recTotal = 0, int $recPerPage = 20, int $pageID = 1)
    {
        return $this->browse($browseType, $productID, $orderBy, $recTotal, $recPerPage, $pageID);
    }

    public function browse(string $browseType = 'all', int $productID = 0, string $orderBy = 'id_desc', int $recTotal = 0, int $recPerPage = 20, int $pageID = 1)
    {
        $this->session->set('feedbackList', $this->app->getURI(true), 'feedback');

        $this->app->loadClass('pager', true);
        $pager     = pager::init($recTotal, $recPerPage, $pageID);
        $feedbacks = $this->feedback->getList($browseType, $productID, $orderBy, $pager);

        $this->view->title       = $this->lang->feedback->common;
        $this->view->browseType  = $browseType;
        $this->view->productID   = $productID;
        $this->view->orderBy     = $orderBy;
        $this->view->pager       = $pager;
        $this->view->feedbacks   = $feedbacks;
        $this->view->products    = $this->loadModel('product')->getPairs('', 0, '', 'all');
        $this->view->modules     = $this->loadModel('tree')->getOptionMenu($productID, 'feedback', 0);
        $this->view->users       = $this->loadModel('user')->getPairs('noletter|nodeleted|noclosed');
        $this->display();
    }

    public function create()
    {
        if(!empty($_POST))
        {
            $feedback = $this->buildFeedbackFromPost();
            $feedbackID = $this->feedback->create($feedback);
            if(!$feedbackID || dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'load' => $this->createLink('feedback', 'view', "feedbackID=$feedbackID")));
        }

        $products = $this->loadModel('product')->getPairs('', 0, '', 'all');
        $productID = 0;
        foreach($products as $id => $name)
        {
            if((int)$id > 0)
            {
                $productID = (int)$id;
                break;
            }
        }

        $this->view->title     = $this->lang->feedback->create;
        $this->view->products  = $products;
        $this->view->productID = $productID;
        $this->view->modules   = $productID ? $this->loadModel('tree')->getOptionMenu($productID, 'feedback', 0) : array(0 => '/');
        $this->view->users     = $this->loadModel('user')->getPairs('noletter|nodeleted|noclosed');
        $this->display();
    }

    public function edit(int $feedbackID)
    {
        $feedback = $this->feedback->getByID($feedbackID);
        if(!$feedback) return print(js::error($this->lang->feedback->notFound));

        if(!empty($_POST))
        {
            $feedbackData = $this->buildFeedbackFromPost();
            $changes = $this->feedback->update($feedbackID, $feedbackData);
            if($changes === false || dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'load' => $this->createLink('feedback', 'view', "feedbackID=$feedbackID")));
        }

        $this->view->title    = $this->lang->feedback->edit;
        $this->view->feedback = $feedback;
        $this->view->products = $this->loadModel('product')->getPairs('', 0, '', 'all');
        $this->view->modules  = $this->loadModel('tree')->getOptionMenu((int)$feedback->product, 'feedback', 0);
        $this->view->users    = $this->loadModel('user')->getPairs('noletter|nodeleted|noclosed');
        $this->display();
    }

    public function view(int $feedbackID)
    {
        $feedback = $this->feedback->getByID($feedbackID);
        if(!$feedback) return print(js::error($this->lang->feedback->notFound));

        $this->view->title    = "#{$feedback->id} {$feedback->title}";
        $this->view->feedback = $feedback;
        $this->view->products = $this->loadModel('product')->getPairs('', 0, '', 'all');
        $this->view->modules  = $this->loadModel('tree')->getOptionMenu((int)$feedback->product, 'feedback', 0);
        $this->view->users    = $this->loadModel('user')->getPairs('noletter|nodeleted|noclosed');
        $this->view->actions  = $this->loadModel('action')->getList('feedback', $feedbackID);
        $this->display();
    }

    public function assignTo(int $feedbackID)
    {
        if(!empty($_POST))
        {
            $assignedTo = trim((string)$this->post->assignedTo);
            $comment    = trim((string)$this->post->comment);
            if(!$assignedTo) return $this->send(array('result' => 'fail', 'message' => array('assignedTo' => sprintf($this->lang->error->notempty, $this->lang->feedback->assignedTo))));

            $this->feedback->assignTo($feedbackID, $assignedTo, $comment);
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'load' => true));
        }

        $this->view->title    = $this->lang->feedback->assignTo;
        $this->view->feedback = $this->feedback->getByID($feedbackID);
        $this->view->users    = $this->loadModel('user')->getPairs('noletter|nodeleted|noclosed');
        $this->display();
    }

    public function close(int $feedbackID)
    {
        if(!empty($_POST))
        {
            $this->feedback->close($feedbackID, trim((string)$this->post->closedReason), trim((string)$this->post->comment));
            if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'load' => true));
        }

        $this->view->title    = $this->lang->feedback->close;
        $this->view->feedback = $this->feedback->getByID($feedbackID);
        $this->display();
    }

    public function delete(int $feedbackID)
    {
        $this->feedback->deleteFeedback($feedbackID);
        if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));
        return $this->send(array('result' => 'success', 'message' => $this->lang->deleteSuccess, 'load' => true));
    }

    public function ajaxGetModules(int $productID)
    {
        $modules = $this->loadModel('tree')->getOptionMenu($productID, 'feedback', 0);
        return print(html::select('module', $modules, 0, "class='form-control chosen'"));
    }

    private function buildFeedbackFromPost(): object
    {
        $feedback = new stdclass();
        $feedback->product     = (int)$this->post->product;
        $feedback->module      = (int)$this->post->module;
        $feedback->type        = $this->post->type ? (string)$this->post->type : 'requirement';
        $feedback->solution    = $this->post->solution ? (string)$this->post->solution : '';
        $feedback->title       = strip_tags((string)$this->post->title);
        $feedback->desc        = (string)$this->post->desc;
        $feedback->pri         = (int)($this->post->pri ? $this->post->pri : 3);
        $feedback->status      = $this->post->status ? (string)$this->post->status : 'wait';
        $feedback->public      = isset($_POST['public']) && $_POST['public'] !== '0' ? 1 : 0;
        $feedback->notify      = isset($_POST['notify']) && $_POST['notify'] !== '0' ? 1 : 0;
        $feedback->notifyEmail = strip_tags((string)$this->post->notifyEmail);
        $feedback->source      = strip_tags((string)$this->post->source);
        $feedback->assignedTo  = strip_tags((string)$this->post->assignedTo);
        $feedback->feedbackBy  = strip_tags((string)$this->post->feedbackBy);
        $feedback->keywords    = strip_tags((string)$this->post->keywords);

        $mailto = isset($_POST['mailto']) ? $_POST['mailto'] : array();
        if(is_array($mailto)) $mailto = implode(',', array_filter($mailto));
        $feedback->mailto = strip_tags((string)$mailto);

        if(isset($_POST['comment'])) $feedback->comment = (string)$this->post->comment;

        return $feedback;
    }
}
