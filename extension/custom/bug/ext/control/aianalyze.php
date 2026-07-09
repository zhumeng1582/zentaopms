<?php
helper::importControl('bug');

class myBug extends bug
{
    /**
     * Minimal AI analysis endpoint for the bug detail extension.
     *
     * @param  int $bugID
     * @access public
     * @return void
     */
    public function aiAnalyze(int $bugID = 0)
    {
        if($bugID <= 0) return $this->send(array('result' => 'fail', 'message' => 'Invalid bug ID.'));
        if(!common::hasPriv('bug', 'view')) return $this->send(array('result' => 'fail', 'message' => $this->lang->error->accessDenied));

        $bug = $this->bug->getByID($bugID);
        if(empty($bug) || !empty($bug->deleted)) return $this->send(array('result' => 'fail', 'message' => 'Bug not found.'));

        $data = array(
            'summary'           => sprintf('AI demo: Bug #%s "%s" is ready for analysis.', $bug->id, $bug->title),
            'suggestedPriority' => 'P2',
            'riskLevel'         => 'medium',
            'similarBugs'       => array(),
            'evidence'          => array(
                array('type' => 'bug', 'id' => $bug->id, 'title' => $bug->title)
            )
        );

        return $this->send(array('result' => 'success', 'data' => $data));
    }
}
