<?php
declare(strict_types=1);

namespace zin;

$files = !empty($feedback->files) ? array_values($feedback->files) : null;

formPanel
(
    set::title($lang->feedback->edit),
    set::back('GLOBAL'),
    set::backUrl(helper::createLink('feedback', 'view', "feedbackID={$feedback->id}")),
    set::labelWidth('120px'),
    set::submitBtnText($lang->save),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::name('product'),
            set::label($lang->feedback->product),
            set::control('picker'),
            set::items($products),
            set::value($feedback->product),
            set::required(true)
        ),
        formGroup
        (
            set::width('1/2'),
            set::name('module'),
            set::label($lang->feedback->module),
            set::control('picker'),
            set::items($modules),
            set::value($feedback->module)
        )
    ),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::name('type'),
            set::label($lang->feedback->type),
            set::control('picker'),
            set::items($lang->feedback->typeList),
            set::value($feedback->type)
        ),
        formGroup
        (
            set::width('1/2'),
            set::name('pri'),
            set::label($lang->feedback->pri),
            set::control('picker'),
            set::items($lang->feedback->priList),
            set::value($feedback->pri)
        )
    ),
    formGroup
    (
        set::name('title'),
        set::label($lang->feedback->title),
        set::value($feedback->title),
        set::required(true)
    ),
    formGroup
    (
        set::label($lang->feedback->public),
        checkbox(set::name('public'), set::value('on'), set::checked((bool)$feedback->public), set::text($lang->feedback->public))
    ),
    formGroup
    (
        set::label($lang->feedback->desc),
        editor(set::name('desc'), set::value($feedback->desc), set::rows('8'))
    ),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::name('assignedTo'),
            set::label($lang->feedback->assignedTo),
            set::control('picker'),
            set::items(array('' => '') + $users),
            set::value($feedback->assignedTo)
        ),
        formGroup
        (
            set::width('1/2'),
            set::name('feedbackBy'),
            set::label($lang->feedback->feedbackBy),
            set::value($feedback->feedbackBy)
        )
    ),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::name('source'),
            set::label($lang->feedback->source),
            set::value($feedback->source)
        ),
        formGroup
        (
            set::width('1/2'),
            set::name('notifyEmail'),
            set::label($lang->feedback->notifyEmail),
            set::value($feedback->notifyEmail)
        )
    ),
    formGroup
    (
        set::label($lang->feedback->mailto),
        mailto(set::items($users), set::value($feedback->mailto))
    ),
    formGroup
    (
        set::name('keywords'),
        set::label($lang->feedback->keywords),
        set::value($feedback->keywords)
    ),
    formGroup
    (
        set::label($lang->feedback->files),
        fileSelector($files ? set::defaultFiles($files) : null)
    ),
    formGroup
    (
        set::label($lang->feedback->notify),
        checkbox(set::name('notify'), set::value('on'), set::checked((bool)$feedback->notify), set::text($lang->feedback->notify))
    ),
    formGroup
    (
        set::label($lang->feedback->comment),
        editor(set::name('comment'), set::rows('3'))
    )
);

render();
