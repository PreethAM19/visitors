# Visitors Repo Audit And 10-Day Modernization Plan

## 1. Executive Summary

This repository is **not** a React / Next.js / FastAPI codebase today. It is a **PHP + MySQL + jQuery + Bootstrap** visitor management application with a session-driven multi-step flow.

The current live path is centered around:

1. `index.php`
2. `form.php` + `controller.php`
3. `send_otp.php`
4. `webcam.php`
5. `webcam_imagesave.php`
6. `submission.php`
7. `qr_code_after_submission.php`

The app currently records visitor details into the local MySQL database, generates QR codes, optionally captures a visitor image, updates exit time, and shows a daily summary report.

The codebase is workable as a prototype, but it has major cleanup needs:

- large duplicated files
- hard-coded DB credentials and URLs
- SQL concatenation in multiple places
- mixed concerns: HTML, validation, DB logic, and session logic all in the same files
- large amounts of commented-out / legacy code
- old experimental files mixed into the production root
- missing dependencies referenced outside this repo

The most important planning constraint is this:

> If you want to **keep the DB touchpoints and query contract stable**, then your first clean rewrite should still treat the current MySQL schema as the source of truth.

That means:

- **Phase 1**: Next.js + FastAPI + the same MySQL tables/fields/query behavior
- **Phase 2**: add Firebase / Firestore for realtime dashboards, audit events, or notifications
- **Phase 3**: add LDAP SSO for admin/staff authentication

Trying to replace the SQL-backed app with Firestore immediately while also preserving the exact current DB behavior is not realistic.

---

## 2. Current Stack Snapshot

### Runtime / architecture

- PHP server-rendered pages
- MySQL access through `mysqli`
- jQuery AJAX for OTP and some page actions
- Bootstrap + custom CSS
- PHP sessions for multi-step visitor flow
- QR generation through bundled `qrphp/`

### Database tables touched directly in this repo

- `visitors`
- `mast_lookup`
- `pw_entity`
- `pw_lookups`
- `login_details`

### External / missing dependencies

The repo references files that are **not present inside this repository**:

- `../pw_xcon.php`
- `Mail.php`
- `/usr/share/pear/mime.php`

These likely provide:

- session/bootstrap state
- DB or app helpers
- email support
- tenant/user metadata needed by `utils.php`

This matters because a clean rewrite should first document what those missing files are responsible for.

---

## 3. Root File Inventory

This section focuses on the files in the repo root, because that is where the real maintenance burden is.

## 3.1 Core active files

| File | Status | Current role | Notes |
| --- | --- | --- | --- |
| `index.php` | Active | Main landing page and active-visitor dashboard | Only the visitor card is visibly enabled; other categories appear partially commented out |
| `form.php` | Active | Main entry form UI | Very large monolithic file with HTML, CSS hooks, and JS |
| `controller.php` | Active | Validation, field normalization, session staging, host lookup | Behaves more like a mixed controller + service + view helper |
| `send_otp.php` | Active | AJAX OTP generation and verification | Uses session to store OTP |
| `webcam.php` | Active | Generates visitor ID + QR and shows camera capture step | Pre-submission bridge page |
| `webcam_imagesave.php` | Active support | Saves base64 visitor image into uploads folder | Tied to webcam flow |
| `submission.php` | Active | Inserts visitor data into DB and sends email approval links | Main write path into `visitors` |
| `qr_code_after_submission.php` | Active | Displays QR and visitor details for print/exit | Final confirmation page |
| `configure.php` | Active support | Loads category duration config from `mast_lookup` into session | Used by `index.php` |
| `visitor_report.php` | Active | Daily summary and counts page | Separate reporting screen |
| `out_time_update.php` | Active | Marks visitor exit date/time | Triggered from active visitor list |
| `approve.php` | Active secondary | Updates `hoststatus` to approved | Email approval link target |
| `deny.php` | Active secondary | Updates `hoststatus` to denied | Email deny link target |
| `top_logo_title_header.php` | Shared | Shared top banner/header block | Outputs full HTML/head/body wrapper, which is structurally wrong for a partial |
| `top_logo_title_header.css` | Shared | Styling for shared banner | Small shared stylesheet |

## 3.2 Secondary / admin / side-path files

| File | Status | Current role | Notes |
| --- | --- | --- | --- |
| `db.php` | Active secondary | DB connection for login/signup pages | Duplicates credentials already present elsewhere |
| `visitor_login.php` | Active secondary | Simple local username/password login | Uses `login_details` |
| `visitor_signup.php` | Active secondary | Simple local sign-up page | Uses raw SQL string interpolation |
| `visitor_logout.php` | Active secondary | Session destroy and redirect | Small and clear |
| `details_preplanned_visitor.php` | Active side-path | Loads a pre-booked visitor and redirects them into webcam/submission flow | Side path from "Yet to Visit" tab |
| `visitor_duration_edit.php` | Semi-active / manual | UI for editing visit durations | Not linked from main home page |
| `visitor_duration_setup.php` | Semi-active / manual | AJAX save target for duration editor | Paired with `visitor_duration_edit.php` |
| `visitor_duration_edit.css` | Semi-active / manual | Styling for duration editor | Only used by duration editor |
| `utils.php` | Active infrastructure | Insert helpers, auto-ID logic, email helper | Depends on missing external state/files |

## 3.3 Likely legacy / unused / non-production files

These files are either unreferenced by the current root flow, obviously experimental, or shadow copies of active files.

| File | Likely status | Why it looks non-primary |
| --- | --- | --- |
| `controller_extra.php` | Legacy fork | Alternate version of `controller.php` with old fields/options |
| `form_extra.php` | Legacy fork | Alternate copy of `form.php` |
| `submission_extra.php` | Legacy fork | Alternate copy of `submission.php` |
| `submissionold.php` | Legacy fork | Much older submission flow, also regenerates IDs/QRs |
| `webcam_extra.php` | Legacy fork | Alternate webcam flow |
| `wecam_og.php` | Legacy fork | Older auto-submit webcam variant |
| `config_home.php` | Old config | Uses different DB/table model from older version |
| `employeesql.php` | Debug script | Dumps employee query results |
| `otp.php` | Legacy OTP stub | Hard-coded OTP test endpoint |
| `verify_otp.php` | Legacy OTP stub | Minimal direct verify endpoint |
| `indextx.html` | Unrelated experiment | OCR/document-scan demo that posts to unrelated script |
| `process_form.php` | Unrelated experiment | Writes to `quarters.meter_readings`, not visitor app DB |
| `cameratrail.php` | Camera experiment | Standalone browser camera demo |
| `swamipro.html` | Unrelated document | Survey/ratings page, unrelated to visitor workflow |
| `test.css` | Likely unused styling | Not referenced by active root flow |

## 3.4 Third-party / asset folders

| Path | Purpose | Notes |
| --- | --- | --- |
| `qrphp/` | QR code library | Bundled third-party package |
| `qrphp/cache/` | Generated QR cache files | Build/runtime artifact, not source |
| `images/` | UI assets and logos | Includes some images that may be unused |
| `OTP/` | Older OTP sub-project | Appears separate from the current `send_otp.php` flow |

---

## 4. Database Touchpoints You Must Preserve First

If the goal is "clean rewrite without breaking DB behavior", these are the current touchpoints that must be mapped exactly before changing stack.

## 4.1 `visitors`

This is the main application table.

Current usage includes:

- insert new visitor rows from `submission.php`
- fetch active open visitors in `index.php`
- fetch pre-booked visitors in `index.php`
- fetch visitor ticket details in `qr_code_after_submission.php`
- update `hoststatus` in `approve.php` / `deny.php`
- update `exitdate` and `exittime` in `out_time_update.php`
- generate sequential-ish visitor IDs in `webcam.php`
- daily count/reporting in `visitor_report.php`

Important fields actively used in the app:

- `visitorid`
- `visitorname`
- `mobile`
- `sf_mobile`
- `assignedname`
- `purpose`
- `vehicle_type`
- `vehicleno`
- `visitdate`
- `totime`
- `exitdate`
- `exittime`
- `category`
- `qrcode`
- `image`
- `duration`
- `docstatus`
- `hoststatus`
- `recordtype`

## 4.2 `mast_lookup`

Used as the duration configuration store.

Relevant keys:

- `Individual_Visitor`
- `Cab_Visitor`
- `Delivery_Visitor`
- `Other_Visitors`

The current code reads `num2`, converts it into `"+N minutes"`, and stores that in `$_SESSION['visiting_duration']`.

## 4.3 `pw_entity`

Used as a source of staff/student data.

Current use:

- populating "Whom To Meet" options in `controller.php`
- finding the email/`userid` for notification mail in `submission.php`

## 4.4 `pw_lookups`

Used indirectly by `utils.php` in `GetAutoID()` to generate IDs for `ds2insert()`.

This means a clean rewrite cannot only copy visible page behavior; it also needs to preserve the helper logic around sequence generation if those IDs matter to downstream systems.

## 4.5 `login_details`

Used by:

- `visitor_login.php`
- `visitor_signup.php`

This is a simple local auth table, separate from the future LDAP/SSO target.

---

## 5. Current Existing Workflow

This is the live workflow as the repo currently behaves.

## 5.1 Walk-in visitor flow

1. User lands on `index.php`.
2. User clicks the visible `Visitors` card.
3. App opens `form.php?category=visitor`.
4. `form.php` includes `controller.php`.
5. `controller.php` loads employee/student names from `pw_entity`.
6. User fills visitor details and triggers OTP via `send_otp.php`.
7. On valid submit, `controller.php` stores the staged form payload in `$_SESSION["data_at_level_one_submit"]`.
8. App redirects to `webcam.php`.
9. `webcam.php` creates a visitor ID pattern, generates a QR image, and shows the camera/snapshot step.
10. Snapshot is saved by `webcam_imagesave.php`.
11. Submit posts to `submission.php`.
12. `submission.php` builds `$ds` and inserts into `visitors` through `ds2insert()`.
13. For visitor entries, the code also sends an email with approve/deny links.
14. User can later open/print `qr_code_after_submission.php?visitor_id=...`.

## 5.2 Pre-booked visitor flow

1. User switches to the "Yet to Visit" view in `index.php`.
2. Page queries rows from `visitors` where `recordtype LIKE 'Pre Booking'`.
3. Clicking a person opens `details_preplanned_visitor.php`.
4. That page loads the current-day booking, copies fields into session, and redirects to `webcam.php`.
5. After the flow continues, the booking is updated to `recordtype = 'Booking Cleared'`.

## 5.3 Exit flow

1. Active visitor list is shown on `index.php`.
2. Exit form posts to `out_time_update.php`.
3. That script writes:
   - `exitdate`
   - `exittime`
4. Then it redirects back to `index.php`.

## 5.4 Approval flow

1. `submission.php` builds approve/deny links using the saved `visitorid`.
2. Email recipient is derived from `pw_entity`.
3. Approve or deny opens:
   - `approve.php`
   - `deny.php`
4. These pages update `visitors.hoststatus`.

## 5.5 Reporting flow

1. `visitor_report.php` queries today’s rows from `visitors`.
2. It renders:
   - a table of today’s entries
   - per-category counts
   - per-category out counts
3. It also supports print/export-ish behavior in the page script.

## 5.6 Duration config flow

1. `configure.php` reads duration minutes from `mast_lookup`.
2. It stores session values like:
   - `visitor => +30 minutes`
   - `cab => +30 minutes`
3. `index.php` reads those session values for time calculations.
4. `visitor_duration_edit.php` + `visitor_duration_setup.php` are manual admin pages for editing those values.

---

## 6. What Is Redundant Or Poorly Structured Today

## 6.1 Duplicate file families

There are multiple near-duplicate branches of the same logic:

- `form.php` and `form_extra.php`
- `controller.php` and `controller_extra.php`
- `submission.php`, `submission_extra.php`, and `submissionold.php`
- `webcam.php`, `webcam_extra.php`, and `wecam_og.php`
- `configure.php` and `config_home.php`

This is a classic sign of "copy-paste evolution" instead of one maintained source of truth.

## 6.2 Mixed concerns in single files

Examples:

- `controller.php` both validates request data and prints HTML/JS
- `form.php` contains markup, front-end logic, modal logic, validation hooks, and UX branching
- `submission.php` handles transformation, DB persistence, email, and response output
- `top_logo_title_header.php` outputs a full document wrapper even though it is used like a partial

## 6.3 Hard-coded secrets and infrastructure values

The repo contains hard-coded:

- DB credentials
- domain URLs
- OTP API key
- path assumptions for upload directories

These should be moved to environment configuration before any serious deployment story.

## 6.4 SQL safety issues

Some queries are parameterized, but many are not.

Risky patterns include string concatenation with:

- `$_GET`
- `$_POST`
- search input
- visitor names / IDs

Examples of raw concatenation exist in:

- `index.php`
- `details_preplanned_visitor.php`
- `out_time_update.php`
- `visitor_login.php`
- `visitor_signup.php`
- `qr_code_after_submission.php`

## 6.5 Hidden workflow mismatch

The codebase contains category logic for:

- `visitor`
- `cab`
- `delivery`
- `other_services`

But the home page visibly enables only the `visitor` card, with other category cards largely commented out. That means the codebase has more branches than the currently exposed product.

## 6.6 Missing/unclear ownership of session state

Session values are heavily used as the application transport layer:

- form input staged in session
- duration config stored in session
- per-visitor staged payload keyed by generated IDs
- OTP stored in session

This makes the behavior harder to reason about, test, and migrate.

---

## 7. Probable Unused Lines / Dead Zones

This is a **heuristic** view, not a compiler-proof dead-code report.

I measured root PHP files for:

- total lines
- blank lines
- comment-like lines
- debug-like lines (`var_dump`, `print_r`, etc.)

The biggest cleanup zones are:

| File | Total | Blank | Comment-like | Debug-like | Why it matters |
| --- | ---: | ---: | ---: | ---: | --- |
| `form.php` | 2413 | 1409 | 348 | 0 | Large monolith with huge commented legacy blocks and whitespace |
| `controller.php` | 1086 | 622 | 217 | 17 | Validation, dead branches, and debug residue mixed together |
| `index.php` | 1080 | 638 | 101 | 6 | Dashboard plus hidden legacy/category logic |
| `controller_extra.php` | 1047 | 605 | 190 | 17 | Likely alternate legacy fork |
| `submissionold.php` | 746 | 342 | 71 | 16 | Strong candidate for archival/removal |
| `visitor_duration_edit.php` | 633 | 338 | 81 | 12 | Contains old duplicate markup and debug traces |
| `webcam_extra.php` | 525 | 250 | 62 | 6 | Alternate flow copy |
| `submission.php` | 287 | 96 | 50 | 7 | Active file still contains debug output |

### Examples of likely unused / low-value line groups

- large commented form fields in `form.php`
- commented department / address / old host fields in `controller.php`
- commented legacy SQL and old DB-table references in `configure.php`
- debug `var_dump()` and `print_r()` statements in:
  - `submission.php`
  - `details_preplanned_visitor.php`
  - `employeesql.php`
  - `out_time_update.php`
- whole alternate branches preserved as full extra files rather than Git history

### Practical interpretation

The repo does not just need prettier code. It needs:

1. a live-path freeze
2. a legacy-path archive decision
3. one source of truth per workflow

---

## 8. Specific Improvement Opportunities

## 8.1 Immediate cleanup opportunities

1. Centralize DB config into one source.
2. Move secrets into environment variables.
3. Remove debug output from active flow.
4. Replace raw SQL concatenation with parameterized queries.
5. Extract shared visitor insert logic into one service.
6. Split form rendering from validation logic.
7. Archive or delete `_extra`, `_old`, and experimental files after confirming they are not used.
8. Separate reusable UI partials from full document wrappers.
9. Add one documented schema map for `visitors`.
10. Document every current query before rewrites begin.

## 8.2 Structural improvements for the clean rewrite

1. Define typed DTOs for:
   - visitor intake payload
   - visitor DB row
   - report row
   - host lookup result
2. Create a repository layer around current SQL operations.
3. Create service modules for:
   - OTP
   - QR generation
   - visitor ID generation
   - image upload
   - notification email
4. Create API endpoints that mirror existing behavior instead of letting UI hit SQL directly.
5. Add tests around the current DB contract before swapping the UI stack.

## 8.3 Product improvements once the codebase is cleaner

1. Better operator UI for gate staff
2. Search and filters that do not rely on giant SQL concatenation
3. Approval audit trail
4. Realtime active visitor board
5. Pre-booking management
6. Faster repeat-entry or known-visitor flow
7. Better error states for OTP/image/submit failures
8. Real reporting and gate-delay metrics

---

## 9. Recommended Modern Target Architecture

If your end goal is to eventually say:

> Built and deployed an in-house Visitor Management Platform using React / Next.js, FastAPI, Firebase / Firestore, and LDAP SSO, replacing a commercial solution and reducing gate delays by 40%

then the safest technical path is:

## 9.1 Phase 1: keep MySQL contract stable

Use:

- Next.js + React + TypeScript for frontend
- FastAPI for backend
- current MySQL schema as source of truth

Why:

- this preserves your current DB touchpoints
- this avoids breaking gate operations
- this gives you a clean platform to compare against the PHP app

## 9.2 Phase 2: add Firebase / Firestore only where it helps

Use Firestore for:

- realtime dashboards
- activity/event feeds
- notifications / operator presence
- analytics snapshots

Do **not** make Firestore the first source of truth if your goal is preserving current SQL behavior.

## 9.3 Phase 3: add LDAP SSO

Replace local `login_details` auth with:

- LDAP or SSO-backed admin/staff sign-in
- role-based access for reception, security, admin

For the first 10-day build, a mocked auth adapter is enough. Real LDAP integration can come after the new flow works.

---

## 10. What You Need To Honestly Claim The Resume Bullet

To legitimately claim the future resume statement, you should be able to show:

1. a deployed Next.js frontend
2. a deployed FastAPI backend
3. a real staff/admin login flow, ideally LDAP-backed
4. real operational usage or pilot usage
5. a measurable before-vs-after gate process baseline
6. evidence that the old solution was replaced or materially displaced

### What "reducing gate delays by 40%" requires

You need actual measurement:

- baseline average entry time before rollout
- average entry time after rollout
- sample window size
- definition of "delay"

Until that exists, use a more honest project line such as:

> Modernized a legacy PHP visitor-entry system into a typed Next.js + FastAPI platform while preserving the existing visitor database contract and QR/OTP workflow.

After production rollout and measurement, then upgrade the wording.

---

## 11. 10-Day Learning + Implementation Plan

This plan is designed for someone **new to Next.js, React, TypeScript, and FastAPI**.

The goal is not just "rewrite the app". The goal is:

- learn the new stack
- preserve the working business logic
- ship a clean, demo-ready final deliverable

### Daily rhythm

For each day:

- 60 to 90 min: concept learning
- 2 to 4 hrs: implementation
- 30 min: write notes and commit what changed

## Day 1: Understand The Legacy App And Freeze The Contract

### Learn

- how the current PHP flow works
- what data is stored in `visitors`
- how sessions are used today
- what "contract-first migration" means

### Build

- create a DB field map for `visitors`
- list current queries by page/action
- capture current UI screenshots
- define the minimum features for v1 rewrite

### Deliverable

- this audit doc
- a field mapping doc
- a "must preserve" checklist

### End-of-day outcome

You should be able to explain the current system without opening the PHP files.

## Day 2: Learn React + TypeScript Basics And Scaffold Next.js

### Learn

- components
- props
- state
- controlled inputs
- TypeScript interfaces/types
- App Router basics in Next.js

### Build

- create a new Next.js app
- create routes for:
  - home/dashboard
  - new visitor form
  - report page
- add a clean layout and shared UI shell

### Deliverable

- working Next.js skeleton
- typed page structure

### End-of-day outcome

You have a clean frontend shell, even if it is still static.

## Day 3: Rebuild The Visitor Form In React

### Learn

- client components vs server components
- form state in React
- conditional rendering
- reusable form components

### Build

- rebuild the main visitor form UI
- create typed fields for:
  - visitor name
  - visitor mobile
  - host to meet
  - host mobile
  - vehicle info
  - purpose/comments

### Deliverable

- a clean React form page that matches the current visitor use case

### End-of-day outcome

The old `form.php` begins to disappear conceptually into small, readable components.

## Day 4: Add Strong Validation

### Learn

- `react-hook-form`
- `zod`
- schema-based validation
- client + server validation separation

### Build

- add validation schema for visitor form
- add category-aware validation rules
- remove implicit session-only assumptions from the frontend

### Deliverable

- typed, validated visitor form

### End-of-day outcome

You understand how to replace large manual PHP validation blocks with typed schemas.

## Day 5: Learn FastAPI And Build The First API Endpoints

### Learn

- FastAPI routers
- Pydantic models
- request/response models
- dependency injection
- basic project structure

### Build

- create FastAPI project
- create endpoints for:
  - `GET /hosts`
  - `GET /durations`
  - `POST /otp/generate`
  - `POST /otp/verify`

### Deliverable

- local FastAPI server running
- Next.js frontend calling basic APIs

### End-of-day outcome

You now have a frontend/backend split instead of PHP pages doing everything.

## Day 6: Preserve The Current Database Contract

### Learn

- repository pattern
- raw SQL adapters
- DB abstraction without changing behavior
- contract tests

### Build

- create repository modules for:
  - create visitor
  - fetch active visitors
  - fetch pre-booked visitors
  - mark exit
  - approve/deny visitor
  - fetch report counts
- keep table names and field meanings unchanged

### Deliverable

- FastAPI backed by the current MySQL schema
- documented repository layer

### End-of-day outcome

The backend is now clean without breaking the existing DB assumptions.

## Day 7: Implement End-To-End Visitor Submission

### Learn

- file/image upload handling
- server-generated IDs
- QR generation
- async background tasks

### Build

- submit visitor entry through FastAPI
- generate visitor ID using current rules
- generate QR code
- save image upload
- store row into `visitors`

### Deliverable

- one working end-to-end visitor check-in flow in the new stack

### End-of-day outcome

You now have a real replacement for the legacy walk-in flow.

## Day 8: Add Authentication And Prepare LDAP Integration

### Learn

- authentication basics
- session vs token auth
- LDAP concepts
- adapter/interface design

### Build

- create admin sign-in flow
- create an auth abstraction:
  - local/dev auth adapter
  - future LDAP adapter interface
- protect report/admin routes

### Deliverable

- working dev auth now
- clear LDAP integration point later

### End-of-day outcome

You avoid blocking the project on enterprise auth while still designing for it properly.

## Day 9: Reports, Approvals, Exit Updates, And Optional Firestore Layer

### Learn

- dashboards/tables in React
- backend filtering
- audit event thinking
- when Firestore is useful

### Build

- recreate daily summary page
- recreate active visitor list
- add approve/deny actions
- add exit update action
- optionally mirror visitor events into Firestore for realtime dashboarding

### Deliverable

- operational dashboard
- working admin/report flow

### End-of-day outcome

The new app now covers most of the real business workflow, not just data entry.

## Day 10: Testing, Deployment, Demo, And Storytelling

### Learn

- basic automated testing
- deployment workflow
- demo readiness
- writing an honest project narrative

### Build

- add smoke tests for core flows
- deploy frontend/backend
- write setup instructions
- record demo steps
- define how gate-delay improvement will be measured

### Deliverable

- final demo app
- deployment links
- architecture diagram
- project README
- realistic resume bullet draft

### End-of-day outcome

You finish with a working deliverable and a believable story of what you built.

---

## 12. Suggested Final Deliverable For The 10-Day Version

Aim for this scope:

### Must-have

- Next.js frontend
- TypeScript throughout frontend
- FastAPI backend
- MySQL compatibility layer preserving current DB behavior
- visitor check-in form
- OTP flow
- QR generation
- image capture/upload
- active visitor dashboard
- exit update
- daily report
- basic admin auth

### Nice-to-have

- approval email flow
- pre-booked visitor flow
- Firestore event mirror
- LDAP mock adapter

### Defer until after day 10

- full Firestore replacement of storage
- full LDAP production integration
- advanced analytics
- deep role/permission matrix

---

## 13. Recommended Order Of Refactor In This Repo

If you also want to improve this current PHP repo before or during the rewrite, do it in this order:

1. Document the DB contract.
2. Remove secrets from source.
3. Remove debug prints from active flows.
4. Archive legacy duplicate files into a `legacy/` folder.
5. Centralize DB connection and config.
6. Parameterize raw queries.
7. Extract pure helper functions from `controller.php` and `submission.php`.
8. Freeze the legacy repo except for critical fixes.
9. Build the new Next.js + FastAPI app beside it.
10. Switch traffic only after the replacement flow is complete.

---

## 14. Bottom Line

You can absolutely turn this repo into the foundation for a much stronger project, but the clean path is:

1. understand and freeze the current DB behavior
2. rebuild the app cleanly in Next.js + TypeScript + FastAPI
3. preserve MySQL compatibility first
4. add Firestore and LDAP in staged layers
5. measure real operational improvements before claiming the final business impact

That path gives you both:

- a safer technical migration
- a much stronger learning journey

It also produces a project story that is both impressive and honest.
