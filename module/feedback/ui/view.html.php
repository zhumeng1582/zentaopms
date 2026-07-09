<?php
declare(strict_types=1);

namespace zin;

$statusName = zget($lang->feedback->statusList, $feedback->status, $feedback->status);
$typeName   = zget($lang->feedback->typeList, $feedback->type, $feedback->type);
$priName    = zget($lang->feedback->priList, $feedback->pri, $feedback->pri);
$browseLink = $this->session->feedbackList ? $this->session->feedbackList : helper::createLink('feedback', 'browse');

$filesHtml = '';
if(!empty($feedback->files))
{
    foreach($feedback->files as $file)
    {
        $isImage = in_array(strtolower($file->extension), array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'));
        $title   = htmlspecialchars($file->title, ENT_QUOTES);
        if($isImage)
        {
            $readLink     = helper::createLink('file', 'read', "fileID={$file->id}");
            $downloadLink = helper::createLink('file', 'download', "fileID={$file->id}&mouse=left");
            $filesHtml   .= "<a href='{$downloadLink}' target='_blank'><img src='{$readLink}' title='{$title}' style='max-width:280px;max-height:180px;margin:8px 12px 8px 0;border:1px solid var(--color-gray-300);border-radius:4px' /></a>";
        }
        else
        {
            $downloadLink = helper::createLink('file', 'download', "fileID={$file->id}");
            $filesHtml   .= "<div><a href='{$downloadLink}'><i class='icon icon-paper-clip'></i> {$title}</a></div>";
        }
    }
}

detailHeader
(
    to::prefix
    (
        btn(setClass('ghost'), set::icon('back'), set::url($browseLink), $lang->goback)
    ),
    to::title
    (
        entityLabel(set(array('entityID' => $feedback->id, 'level' => 1, 'text' => $feedback->title)))
    ),
    to::suffix
    (
        btn(setClass('secondary'), set::icon('hand-right'), set::url(helper::createLink('feedback', 'assignTo', "feedbackID={$feedback->id}")), setData(array('toggle' => 'modal', 'size' => 'sm')), $lang->feedback->assignTo),
        btn(setClass('primary'), set::icon('edit'), set::url(helper::createLink('feedback', 'edit', "feedbackID={$feedback->id}")), $lang->feedback->edit),
        btn(setClass('secondary'), set::icon('off'), set::url(helper::createLink('feedback', 'close', "feedbackID={$feedback->id}")), setData(array('toggle' => 'modal', 'size' => 'sm')), $lang->feedback->close)
    )
);

detailBody
(
    sectionList
    (
        section
        (
            set::title($lang->feedback->desc),
            set::content($feedback->desc ? $feedback->desc : $lang->noData),
            set::useHtml(true)
        ),
        !empty($feedback->files) ? section
        (
            set::title($lang->feedback->files),
            set::content($filesHtml),
            set::useHtml(true)
        ) : null,
        tableData
        (
            item(set::name($lang->feedback->product),      zget($products, $feedback->product, '')),
            item(set::name($lang->feedback->module),       zget($modules, $feedback->module, '/')),
            item(set::name($lang->feedback->status),       $statusName),
            item(set::name($lang->feedback->type),         $typeName),
            item(set::name($lang->feedback->pri),          $priName),
            item(set::name($lang->feedback->solution),     zget($lang->feedback->solutionList, $feedback->solution, $feedback->solution)),
            item(set::name($lang->feedback->openedBy),     zget($users, $feedback->openedBy, $feedback->openedBy) . ' ' . $feedback->openedDate),
            item(set::name($lang->feedback->assignedTo),   zget($users, $feedback->assignedTo, $feedback->assignedTo)),
            item(set::name($lang->feedback->feedbackBy),   $feedback->feedbackBy),
            item(set::name($lang->feedback->source),       $feedback->source),
            item(set::name($lang->feedback->notifyEmail),  $feedback->notifyEmail),
            item(set::name($lang->feedback->mailto),       $feedback->mailto),
            item(set::name($lang->feedback->keywords),     $feedback->keywords),
            item(set::name($lang->feedback->closedReason), zget($lang->feedback->closedReasonList, $feedback->closedReason, $feedback->closedReason))
        )
    ),
    history()
);

render();
