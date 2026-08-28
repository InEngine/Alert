# Session handoff (Alert)

Use this file so new chats pick up **package work**, **branch focus**, and **next steps**. Newest sessions at the top below the intro. **No secrets.**

**Repo:** https://github.com/InEngine/Alert — Composer `inengine/alert`. GitHub project: [InEngine #2](https://github.com/orgs/InEngine/projects/2).

## Platform map

| Consumer | Notes |
|----------|--------|
| LTC | Uses Alert today |
| Provost | Parity issue **#7** — Alert / notifications module |
| Core | Optional shared module via path repos |

## How to update

1. Paste a new block **below** `<!-- SESSION_LOG_START -->`.
2. Note Laravel major compatibility (`illuminate` constraints) when changing Composer.

<!-- SESSION_LOG_START -->

### 2026-08-28 — Handoff seeded

- **Done:** Cursor session handoff + always-apply rule added for multi-level platform continuity.
- **Next:** Confirm Laravel 13 constraint alignment with Core/Provost when Alert is required by Provost (#7).
