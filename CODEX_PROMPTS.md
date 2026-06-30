# CODEX_PROMPTS.md

Use these short prompts with Codex to save tokens.

## Standard Task Prompt

```txt
Read AGENTS.md, DECISIONS.md, and TASKS.md.
Implement TASK-XXX only.
Do not implement any future task.
Do not refactor unrelated files.
Keep changes minimal and scoped.
Update TASKS.md status after implementation.
Return only:
Summary
Changed files
Tests
Notes
```

## Investigation Prompt

```txt
Read AGENTS.md and DECISIONS.md.
Inspect only the files related to TASK-XXX.
Do not modify files.
Return a short implementation plan and the files that will likely change.
```

## Fix Prompt

```txt
Read AGENTS.md and DECISIONS.md.
Fix only the issue described below.
Do not change architecture.
Do not touch unrelated files.
Issue: ...
Return Summary, Changed files, Tests, Notes only.
```

## Review Prompt

```txt
Read AGENTS.md, DECISIONS.md, and the diff.
Review whether the changes follow the spec.
Check for scope creep, hardcoded content, Filament usage, AdminLTE misuse, database-specific SQL, and missing tests.
Return only findings and required fixes.
```
