<?php
declare(strict_types=1);

namespace zin;

modalHeader(set::title($lang->feedback->assignTo));

formPanel
(
    set::submitBtnText($lang->feedback->assignTo),
    formGroup
    (
        set::width('1/2'),
        set::name('assignedTo'),
        set::label($lang->feedback->assignedTo),
        set::control('picker'),
        set::items($users),
        set::value($feedback->assignedTo),
        set::required(true)
    ),
    formGroup
    (
        set::label($lang->feedback->comment),
        editor(set::name('comment'), set::rows(5))
    )
);
hr();
history(set::objectID($feedback->id));

render();
