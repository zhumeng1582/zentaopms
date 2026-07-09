<?php
declare(strict_types=1);

namespace zin;

jsVar('aiAnalyzeLink', createLink('bug', 'aiAnalyze', "bugID={$bug->id}"));

$aiResultSection = div
(
    setClass('detail-section zentao-ai-result-section'),
    div
    (
        setClass('detail-section-title row items-center gap-2'),
        span(setClass('text-md py-1 font-bold'), 'AI 分析结果')
    ),
    div
    (
        setClass('detail-section-content py-1'),
        div
        (
            setID('zentao-ai-bug-panel'),
            setStyle('color', '#6b7280'),
            setStyle('line-height', '1.7'),
            '点击右上角“AI 分析”生成结果。'
        )
    )
);

$aiAnalyzeButton = btn
(
    setClass('toolbar-item zentao-ai-analyze-action'),
    set::icon('magic'),
    set::type('secondary'),
    set::url('javascript:;'),
    'AI 分析'
);

query('.detail-main .detail-sections')->prepend($aiResultSection);
query('.detail-toolbar .toolbar')->append($aiAnalyzeButton);
