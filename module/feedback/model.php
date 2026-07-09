<?php
declare(strict_types=1);

class feedbackModel extends model
{
    public function getByID(int $feedbackID): object|false
    {
        $feedback = $this->dao->select('*')->from(TABLE_FEEDBACK)
            ->where('id')->eq($feedbackID)
            ->andWhere('deleted')->eq('0')
            ->fetch();

        if($feedback) $feedback->files = $this->loadModel('file')->getByObject('feedback', $feedbackID);
        return $feedback;
    }

    public function getByList($idList): array
    {
        if(empty($idList)) return array();
        return $this->dao->select('*')->from(TABLE_FEEDBACK)
            ->where('id')->in($idList)
            ->andWhere('deleted')->eq('0')
            ->fetchAll('id');
    }

    public function getList(string $browseType = 'all', int $productID = 0, string $orderBy = 'id_desc', ?object $pager = null): array
    {
        $account = $this->app->user->account;
        return $this->dao->select('*')->from(TABLE_FEEDBACK)
            ->where('deleted')->eq('0')
            ->beginIF($productID > 0)->andWhere('product')->eq($productID)->fi()
            ->beginIF($browseType == 'wait')->andWhere('status')->eq('wait')->fi()
            ->beginIF($browseType == 'doing')->andWhere('status')->eq('doing')->fi()
            ->beginIF($browseType == 'toclosed')->andWhere('status')->eq('toclosed')->fi()
            ->beginIF($browseType == 'review')->andWhere('status')->eq('review')->fi()
            ->beginIF($browseType == 'assigntome')->andWhere('assignedTo')->eq($account)->fi()
            ->beginIF($browseType == 'openedbyme')->andWhere('openedBy')->eq($account)->fi()
            ->beginIF($browseType == 'public')->andWhere('public')->eq('1')->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    public function create(object $feedback): int|false
    {
        $feedback->openedBy     = $this->app->user->account;
        $feedback->openedDate   = helper::now();
        $feedback->assignedDate = !empty($feedback->assignedTo) ? helper::now() : null;
        $feedback->status       = empty($feedback->status) ? 'wait' : $feedback->status;

        $this->dao->insert(TABLE_FEEDBACK)->data($feedback, 'uid,files,labels')
            ->autoCheck()
            ->batchCheck($this->config->feedback->create->requiredFields, 'notempty')
            ->exec();
        if(dao::isError()) return false;

        $feedbackID = (int)$this->dao->lastInsertID();
        $this->loadModel('file')->saveUpload('feedback', $feedbackID);
        $this->loadModel('action')->create('feedback', $feedbackID, 'Opened');
        if(!empty($feedback->assignedTo)) $this->action->create('feedback', $feedbackID, 'Assigned', '', $feedback->assignedTo);

        return $feedbackID;
    }

    public function update(int $feedbackID, object $feedback): array|false
    {
        $oldFeedback = $this->getByID($feedbackID);
        if(!$oldFeedback) return false;

        $feedback->editedBy   = $this->app->user->account;
        $feedback->editedDate = helper::now();

        $this->dao->update(TABLE_FEEDBACK)->data($feedback, 'uid,files,labels,comment')
            ->autoCheck()
            ->batchCheck($this->config->feedback->edit->requiredFields, 'notempty')
            ->where('id')->eq($feedbackID)
            ->exec();
        if(dao::isError()) return false;

        $this->loadModel('file')->saveUpload('feedback', $feedbackID);
        $newFeedback = $this->getByID($feedbackID);
        $changes     = common::createChanges($oldFeedback, $newFeedback);
        $actionID    = $this->loadModel('action')->create('feedback', $feedbackID, 'Edited', !empty($feedback->comment) ? $feedback->comment : '');
        if($changes) $this->action->logHistory($actionID, $changes);

        return $changes;
    }

    public function assignTo(int $feedbackID, string $assignedTo, string $comment = ''): bool
    {
        $oldFeedback = $this->getByID($feedbackID);
        if(!$oldFeedback) return false;

        $feedback = new stdclass();
        $feedback->assignedTo     = $assignedTo;
        $feedback->prevAssignedTo = $oldFeedback->assignedTo;
        $feedback->assignedDate   = helper::now();
        if($oldFeedback->status == 'wait') $feedback->status = 'doing';

        $this->dao->update(TABLE_FEEDBACK)->data($feedback)->where('id')->eq($feedbackID)->exec();
        if(dao::isError()) return false;

        $newFeedback = $this->getByID($feedbackID);
        $changes     = common::createChanges($oldFeedback, $newFeedback);
        $actionID    = $this->loadModel('action')->create('feedback', $feedbackID, 'Assigned', $comment, $assignedTo);
        if($changes) $this->action->logHistory($actionID, $changes);
        return true;
    }

    public function close(int $feedbackID, string $closedReason = '', string $comment = ''): bool
    {
        $oldFeedback = $this->getByID($feedbackID);
        if(!$oldFeedback) return false;

        $feedback = new stdclass();
        $feedback->status       = 'closed';
        $feedback->closedBy     = $this->app->user->account;
        $feedback->closedDate   = helper::now();
        $feedback->closedReason = $closedReason;

        $this->dao->update(TABLE_FEEDBACK)->data($feedback)->where('id')->eq($feedbackID)->exec();
        if(dao::isError()) return false;

        $newFeedback = $this->getByID($feedbackID);
        $changes     = common::createChanges($oldFeedback, $newFeedback);
        $actionID    = $this->loadModel('action')->create('feedback', $feedbackID, 'Closed', $comment, $closedReason);
        if($changes) $this->action->logHistory($actionID, $changes);
        return true;
    }

    public function deleteFeedback(int $feedbackID): bool
    {
        $this->dao->update(TABLE_FEEDBACK)->set('deleted')->eq('1')->where('id')->eq($feedbackID)->exec();
        if(dao::isError()) return false;
        $this->loadModel('action')->create('feedback', $feedbackID, 'Deleted');
        return true;
    }

    public function isClickable(object $feedback, string $action): bool
    {
        if($action == 'assignTo') return $feedback->status != 'closed';
        if($action == 'close')    return $feedback->status != 'closed';
        if($action == 'delete')   return true;
        if($action == 'edit')     return true;

        return true;
    }

    public function getFeedbackPairs($type = ''): array
    {
        return $this->loadModel('user')->getPairs('noletter|nodeleted|noclosed');
    }
}
