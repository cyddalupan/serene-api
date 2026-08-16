# SERENE
Strengthen Employees. Refine Expertise. Natural Excellence.

## Product & Technical Architecture Documentation

**Project:** Serene
**Platform:** Mobile Application
**Mobile:** React Native
**Backend:** Laravel
**Database:** MySQL
**Local Mobile Database:** SQLite
**Primary Roles:** Admin + Employee

---

# 1. Product Overview

Serene is an employee development and performance system designed to help companies turn employees into better, more capable, and more consistent workers.

Serene does not simply function as a training application.

It:

1. Understands who an employee is.
2. Establishes their initial employee profile.
3. Identifies strengths and weaknesses across 9 attributes.
4. Provides role-specific training when needed.
5. Keeps employees sharp through daily habits.
6. Gives employees real work-related quests and checklists.
7. Tracks progress over time.
8. Continuously builds an evolving picture of the employee.

The original product concept is centered around assessing employees, teaching them, keeping them sharp, and tracking their actual work.

The new product name is:

# SERENE

---

# 2. Core Product Philosophy

Serene should be designed around one fundamental idea:

> **Serene manages the employee's development and daily work life rather than simply providing separate features.**

The employee should not need to think:

> "Which feature do I need to open?"

Instead:

> **"What do I need to do today?"**

The application should therefore be centered around the employee's current day.

---

# 3. Platform Architecture

Serene consists of three primary technical layers.

```text
┌─────────────────────────────────────────────┐
│              SERENE MOBILE APP              │
│                                             │
│               React Native                  │
│                                             │
│  UI / Navigation / State / Business Flow    │
│                     │                       │
│              Data Repository                │
│                     │                       │
│              Local SQLite DB                │
│                     │                       │
│                Sync Engine                  │
└─────────────────────┬───────────────────────┘
                      │
                 HTTPS / API
                      │
┌─────────────────────▼───────────────────────┐
│                 LARAVEL API                 │
│                                             │
│ Authentication                              │
│ Business Logic                              │
│ Authorization                               │
│ Synchronization                             │
│ AI orchestration                            │
│ Attribute calculations                      │
│ Notifications / scheduling logic             │
│ Admin functionality                         │
└─────────────────────┬───────────────────────┘
                      │
┌─────────────────────▼───────────────────────┐
│                    MYSQL                    │
│                                             │
│ Users                                       │
│ Companies                                   │
│ Positions                                   │
│ Attributes                                  │
│ Assessments                                 │
│ Training                                    │
│ Quests                                      │
│ Habits                                      │
│ Reflections                                 │
│ Progress                                    │
│ Audit history                               │
└─────────────────────────────────────────────┘
```

---

# 4. Local-First Mobile Architecture

Serene should use a **local-first architecture**.

This means the mobile application should not depend on an API request for every interaction.

Instead:

```text
User
 ↓
React Native
 ↓
Local Database
 ↓
Immediate UI response
 ↓
Sync with Laravel when necessary
```

The server remains the authoritative source of truth, but the mobile application maintains a local working copy of the employee's data.

---

# 5. Why SQLite

SQLite is appropriate for Serene because it is an embedded database designed to run directly on the user's device.

The user does not need to install or configure anything.

The application bundles the necessary SQLite capability and creates Serene's local database on the device.

Conceptually:

```text
Employee Phone
│
└── Serene
    │
    └── SQLite
        ├── User
        ├── Profile
        ├── Attributes
        ├── Training
        ├── Quests
        ├── Habits
        ├── Reflections
        ├── Calendar
        └── Sync Queue
```

The exact React Native SQLite implementation/library should remain replaceable.

Serene should therefore **not allow the UI to directly depend on SQLite APIs**.

Instead:

```text
UI
 ↓
Repository / Data Layer
 ↓
SQLite implementation
```

This means the project can replace the SQLite library in the future without rewriting the entire application.

### Important distinction

SQLite is for:

> **Application data**

Secure device storage is for:

> **Authentication credentials and secrets**

Tokens and other sensitive credentials should not simply be treated as ordinary SQLite records.

---

# 6. Local Database Strategy

The mobile application maintains a local copy of the information required for normal employee operation.

Potential local entities include:

```text
users
companies
positions

attributes
attribute_history

assessments
assessment_questions
assessment_answers

trainings
training_modules
training_lessons
training_progress
training_attempts

daily_habits
habit_questions
habit_answers
reflections

quests
quest_assignments
quest_progress

streak_days

notifications
user_preferences

sync_queue
```

Not every server table needs to exist locally.

Only data required by the mobile experience should be replicated to the device.

---

# 7. Server vs Local Responsibility

## Local Mobile Database

The mobile device should be responsible for fast access to:

* Employee profile
* Position information
* Current attributes
* Attribute history
* Downloaded training
* Training progress
* Current quests
* Quest history
* Daily habit
* Habit answers
* Daily reflections
* Streak calendar
* Notification preferences
* Pending synchronization actions

---

## Laravel Server

Laravel remains responsible for:

* Authentication
* Authorization
* Company data
* Admin configuration
* Employee master records
* Position definitions
* Training assignments
* Training master content
* Quest definitions
* Quest assignments
* Attribute calculations
* AI processing
* Assessment processing
* Official completion validation
* Audit records
* Synchronization
* Cross-device consistency

---

# 8. Source of Truth

The mobile application is optimized for:

> **speed and availability**

The server is responsible for:

> **authority and consistency**

Therefore:

```text
Mobile
  ↓
"I completed this."

Server
  ↓
"Confirmed. This is officially completed."
```

The mobile app may optimistically update the UI before synchronization completes.

The server ultimately determines the official state.

This is particularly important for:

* Attribute changes
* Quest completion
* Training completion
* Assessment results
* Streak calculations
* Administrative actions

---

# 9. Offline-First Principle

The main rule for the mobile application is:

> **If an action does not inherently require server or AI processing, the employee should be able to perform it offline whenever the necessary data is already available locally.**

Examples:

| Action                   | Internet Required |
| ------------------------ | ----------------: |
| Open Serene              |                No |
| View profile             |                No |
| View attributes          |                No |
| View downloaded training |                No |
| Read lesson              |                No |
| Answer quiz              |                No |
| View quests              |                No |
| Start quest              |                No |
| Complete quest           |               No* |
| Complete daily habit     |               No* |
| Write reflection         |                No |
| View streak calendar     |                No |
| Face/Touch ID            |                No |
| Daily reminder           |                No |
| Initial login            |               Yes |
| Initial account setup    |               Yes |
| AI assessment processing |               Yes |
| AI-generated content     |               Yes |
| Server synchronization   |               Yes |
| Download new assignments |               Yes |

`*` The action can be completed locally and synchronized later. The server remains authoritative.

---

# 10. Synchronization Architecture

Synchronization is one of the most important components of Serene.

The mobile application should contain a synchronization engine.

```text
User performs action
        ↓
Save locally
        ↓
Update UI immediately
        ↓
Create sync_queue record
        ↓
Internet available
        ↓
Sync with Laravel
        ↓
Laravel validates/processes action
        ↓
Server returns changes
        ↓
Update local database
        ↓
Mark sync item complete
```

---

# 11. Sync Queue

The local database should contain a `sync_queue`.

Conceptually:

```text
sync_queue

id
operation
entity
entity_id
payload
created_at
retry_count
status
last_error
```

Example:

```text
Employee completes daily habit
        ↓
habit_answers
        ↓
sync_queue
        ↓
Internet unavailable
        ↓
Keep waiting
        ↓
Internet returns
        ↓
POST /sync
        ↓
Laravel processes answer
```

The employee should not lose work simply because the internet temporarily disappeared.

---

# 12. Synchronization Triggers

Synchronization should happen when useful rather than constantly polling the server.

Recommended triggers:

### App launch

```text
Open app
 ↓
Load local database immediately
 ↓
Display UI
 ↓
Start background sync
```

This is important.

The user should not stare at a loading screen while Serene waits for the API.

---

### App returns to foreground

```text
Background
 ↓
User opens Serene
 ↓
Load local data
 ↓
Check synchronization
```

---

### Internet becomes available

If pending changes exist:

```text
Internet restored
 ↓
Sync queue processed
```

---

### Important user actions

After actions such as:

* completing an assessment
* completing training
* completing a quest
* submitting a reflection

the application can attempt synchronization.

---

### Periodic/background synchronization

Where supported by the mobile platform, Serene can perform background synchronization.

However, the application should **never depend entirely on background execution**, because mobile operating systems control when background work is allowed.

The app should remain fully functional when background synchronization does not occur.

---

# 13. Initial Bootstrap

After authentication, Serene should retrieve the data necessary to initialize the user's device.

Conceptually:

```text
POST /auth/login
        ↓
Authentication successful
        ↓
GET /me/bootstrap
        ↓
Download employee environment
        ↓
Store in SQLite
        ↓
Open Home
```

Bootstrap may include:

```text
User
Company
Position
Attributes
Training assignments
Training content
Quest assignments
Current day
Streak information
User settings
Notification settings
Server time
Sync metadata
```

After this initial setup, the app should rely primarily on local data.

---

# 14. Authentication

The application should keep employees logged in for as long as reasonably possible.

Normal flow:

```text
First Login
    ↓
Laravel authentication
    ↓
Securely store credentials/tokens
    ↓
Employee enters Serene
```

Future app opening:

```text
Open Serene
    ↓
Check existing session
    ↓
If valid → Home
    ↓
If expired → refresh session
    ↓
If refresh fails → Login
```

The employee should not repeatedly enter a username and password.

---

# 15. Face ID / Touch ID

Biometric authentication is an optional convenience layer.

It should not replace the server authentication system.

Recommended flow:

```text
Normal Login
     ↓
"Enable Face ID / Touch ID?"
     ↓
Employee agrees
     ↓
Secure credential/session information
     ↓
Future app openings
     ↓
Biometric authentication
     ↓
Unlock Serene
```

Biometrics should be used primarily to unlock the existing authenticated session.

---

# 16. Native Mobile Features

Serene intentionally minimizes native functionality.

Only two major native capabilities are required initially:

### 1. Local Notifications

Used primarily for:

> Daily reminder to complete Serene.

Example:

```text
8:00 AM

"Good morning. Your Serene habit is ready."
```

The notification should be scheduled locally on the device.

The server does not need to send a network request every morning merely to remind the user.

---

### 2. Biometrics

Used for:

* Face ID
* Touch ID
* Equivalent supported biometric authentication

No other major native feature is required for the initial product.

---

# 17. Employee Experience

The mobile application should be centered around the employee's day.

The employee's primary screen should communicate:

```text
TODAY

Daily Habit
Training
Quests
Progress
Streak
```

The employee should immediately understand:

> **What do I need to do today?**

---

# 18. Employee Lifecycle

```text
New Employee
      ↓
Login
      ↓
Profile Incomplete?
      │
      ├── Yes
      │    ↓
      │ Character Assessment
      │    ↓
      │ AI Evaluation
      │    ↓
      │ 9 Attributes
      │    ↓
      │ Profile Complete
      │
      └── No
           ↓
         Home
           ↓
     Daily Serene Loop
           ↓
    ┌──────┼──────┐
    ↓      ↓      ↓
 Habit  Training Quests
    │      │      │
    └──────┼──────┘
           ↓
      Daily Reflection
           ↓
      Performance Data
           ↓
       9 Attributes
           ↓
    Continuous Development
```

---

# 19. User Profiling / Character Assessment

The first major feature is the employee profiling process.

The system detects when the employee has not completed their profile.

```text
Login
 ↓
Profile complete?
 ↓
NO
 ↓
Assessment
```

The assessment uses open-ended questions without a single correct answer.

The purpose is to understand the employee and establish their initial profile.

The original specification defines the assessment as open-ended questions used at hiring and periodic recalibration, with AI scoring against the 9 attributes.

---

# 20. Assessment Offline Behavior

Assessment answers should be saved locally as the employee progresses.

Example:

```text
Question 1
 ↓
Answer saved locally

Question 2
 ↓
Answer saved locally

Question 3
 ↓
Answer saved locally

...

Assessment complete
 ↓
Submit assessment
 ↓
Laravel / AI processing
```

The user should not lose answers if the connection disappears halfway through.

AI evaluation requires the server.

---

# 21. The 9 Attributes

Serene maintains exactly nine employee attributes:

1. Teachability / Learning agility
2. Attitude / Positivity
3. Integrity / Accountability
4. Adaptability
5. Initiative / Proactivity
6. Communication
7. Collaboration / Teamwork
8. Resilience / Stress tolerance
9. Leadership potential

These are the core character attributes defined by the original project.

There should not be a separate tenth "Consistency" attribute.

Missed activities can affect existing attributes, particularly:

* Integrity / Accountability
* Initiative / Proactivity

This preserves the fixed nine-attribute model.

---

# 22. Training

Training is the second major feature.

Training exists when an employee needs additional knowledge or capability for their role.

The system supports:

```text
Position
 ↓
Required Training
 ↓
Employee
 ↓
Training
 ↓
Lesson
 ↓
Quiz
 ↓
Grade
 ↓
Pass / Repeat
```

The existing training concept uses:

> teach → quiz → grade → repeat until satisfied → next lesson.

---

# 23. Training Assignment

Training assignment should work in two ways.

### Position-based

A position can have required training.

Example:

```text
Sales Representative
 ├── Sales Fundamentals
 ├── Customer Communication
 └── CRM Basics
```

### Individual assignment

An admin can assign additional training directly to an employee.

Example:

```text
Employee
 ↓
Promotion
 ↓
Admin assigns
"Team Leadership Training"
```

The original design explicitly supports required position training while allowing individual training overrides.

---

# 24. Training Mobile Architecture

Training content should be downloadable to the phone.

Once downloaded:

```text
Training
 ↓
SQLite
 ↓
Employee
```

The employee can:

* Open lessons
* Read lessons
* Answer quizzes
* Review material
* Continue training

without repeatedly requesting the server.

Training results are synchronized afterward.

---

# 25. AI Training

AI processing remains server-side.

The server can:

* Analyze assessment gaps
* Suggest training
* Generate training material where appropriate
* Grade answers
* Determine whether additional training is necessary

The original system uses an Admin-approved model where AI suggests curriculum based on assessment gaps and the Admin approves it.

---

# 26. Daily Habit

Daily Habit is the central recurring employee activity.

It consists of **three layers**.

```text
                 DAILY HABIT
                      │
        ┌─────────────┼─────────────┐
        │             │             │
     LAYER 1       LAYER 2       LAYER 3
        │             │             │
   Work Sharpness   Attributes   Daily Reflection
```

---

# 27. Layer 1 — Work Sharpening

Purpose:

> Keep the employee sharp in their actual work.

Content may include:

* Work trivia
* Work-related questions
* Position-specific questions
* Training-related questions
* Situational work questions

Content should be influenced by:

```text
Position
+
Role description
+
Current training
+
Relevant work context
```

The original design already establishes that the daily habit should connect to the employee's current position and training.

---

# 28. Layer 2 — Attribute Development

Purpose:

> Continuously maintain and improve the employee's 9 attributes.

Each daily session can target an attribute.

The system can rotate through or intelligently select attributes.

Example:

```text
Monday → Communication
Tuesday → Initiative
Wednesday → Adaptability
Thursday → Resilience
Friday → Accountability
```

The exact selection algorithm should remain configurable.

The original concept already uses daily habit activities to target one of the nine attributes.

---

# 29. Layer 3 — Daily Reflection

The employee gets an open-ended prompt such as:

> "How was your day?"

The employee can write freely.

Example:

```text
How was your day today?

[ Employee response... ]

Submit
```

The response is saved locally immediately.

It can then be synchronized to Laravel for processing.

Potential AI processing can later identify useful signals relating to the employee's development, but the exact analysis and scoring rules should be defined separately.

---

# 30. Daily Habit Offline Flow

```text
Notification
     ↓
Employee opens Serene
     ↓
Today's habit loaded from SQLite
     ↓
Layer 1
     ↓
Layer 2
     ↓
Layer 3
     ↓
Completed locally
     ↓
UI updates immediately
     ↓
Sync queue
     ↓
Laravel
     ↓
Official processing
```

---

# 31. Quest System

Quests represent real work, tasks, and checklists.

The system supports:

* Daily
* Weekly
* Monthly
* One-off quests

The original specification defines these cadences and fixed triggers.

---

# 32. Quest Generation

Recurring quests are generated by the server.

Example:

```text
Daily
→ Every day at configured time

Weekly
→ Every Monday

Monthly
→ Every 1st of the month
```

The original system uses:

* Daily: 8:00 AM
* Weekly: Monday
* Monthly: 1st of the month

with Admin configuration available for overrides.

These should ultimately be treated as **server-side business rules**, not something the mobile application independently decides.

---

# 33. Quest Mobile Flow

```text
Server assigns quest
       ↓
Sync
       ↓
SQLite
       ↓
Employee sees quest
       ↓
Employee works on quest
       ↓
Employee marks complete
       ↓
Local completion
       ↓
Sync
       ↓
Server validates
```

---

# 34. Quest → Attribute Relationship

Quests affect the employee's 9 attributes.

Completing quests appropriately can improve relevant attributes.

Missing quests can reduce relevant attributes.

The original specification specifically connects quest completion/misses to attributes, particularly Accountability and Initiative.

The server should calculate these changes.

The mobile app should display the resulting change after synchronization.

---

# 35. Streak Calendar

The streak calendar provides a visual history of employee activity.

Each day can have:

```text
Not Done
Partially Done
Completed
```

Additional tags can identify:

* Daily habit completed
* Daily quest completed
* One-off quest completed
* Weekly quest completed
* Monthly quest completed

The original specification defines this calendar structure and explicitly states that missing a day does not reset the streak.

---

# 36. Streak Calendar Architecture

The calendar should not become an independent source of truth.

Instead:

```text
Habit History
       +
Quest History
       +
Other Daily Activity
       ↓
Daily Status
       ↓
Streak Calendar
```

The calendar is therefore a **view of activity data**.

---

# 37. Employee Home

The Employee Home should provide a concise overview.

```text
SERENE

Good morning, [Employee]

TODAY

Daily Habit
[ Progress ]

Training
[ Continue ]

Quests
[ 2 remaining ]

Streak
[ Current streak ]

Character
[ Attribute summary ]
```

The employee should be able to reach the most important action quickly.

---

# 38. Employee Navigation

The exact UI can evolve, but the logical modules are:

```text
Home
│
├── Daily Habit
│   ├── Work Sharpening
│   ├── Attribute Development
│   └── Reflection
│
├── Training
│
├── Quests
│
├── Character
│   ├── 9 Attributes
│   └── Attribute History
│
├── Streak Calendar
│
└── Profile
```

---

# 39. Mobile API Philosophy

Serene should avoid unnecessary API requests.

Bad architecture:

```text
Open screen
 ↓
API request
 ↓
Wait
 ↓
Render

Open another screen
 ↓
API request
 ↓
Wait
 ↓
Render
```

Preferred architecture:

```text
Open app
 ↓
Read SQLite
 ↓
Render immediately
 ↓
Sync quietly
 ↓
Update SQLite
 ↓
UI updates
```

---

# 40. API Endpoint Strategy

The following is the initial logical API structure.

## Authentication

```text
POST /api/auth/login
POST /api/auth/refresh
POST /api/auth/logout
```

---

## Bootstrap

```text
GET /api/me/bootstrap
```

Used to initialize a device.

---

## Synchronization

```text
POST /api/sync
```

This becomes one of the most important mobile endpoints.

It can send:

```text
pending local changes
```

and receive:

```text
server changes
```

---

## User

```text
GET /api/me
PATCH /api/me/preferences
```

---

## Assessment

```text
GET  /api/assessment
POST /api/assessment/submit
GET  /api/assessment/history
```

---

## Training

```text
GET  /api/trainings
GET  /api/trainings/{id}
POST /api/trainings/{id}/progress
```

---

## Daily Habit

```text
GET  /api/habit/today
POST /api/habit/{id}/submit
POST /api/habit/{id}/reflection
```

Some of these GET requests may eventually be unnecessary if their data is fully provided through synchronization.

---

## Quests

```text
GET  /api/quests
GET  /api/quests/{id}
POST /api/quests/{id}/complete
```

Again, these may eventually be largely replaced by synchronized local data.

---

## Attributes

```text
GET /api/attributes
GET /api/attributes/history
```

---

## Streak

```text
GET /api/streak
```

---

# 41. API Request Timing

The mobile application should use APIs at predictable moments.

## Login

```text
Only when required
```

---

## Bootstrap

```text
First login on device
Potentially after major account reset
```

---

## Sync

```text
App opens
App returns to foreground
Internet becomes available
Important local action completed
Periodic background opportunity
```

---

## AI

```text
Only when AI processing is required
```

The application should never repeatedly call AI APIs merely because the employee navigated between screens.

---

# 42. Example Daily Timeline

A typical employee day could look like:

```text
07:30
Employee wakes up

08:00
Local notification
"Your Serene habit is ready."

08:05
Employee opens Serene

08:05
SQLite immediately loads today's data

08:06
Layer 1 completed

08:07
Layer 2 completed

08:08
Employee writes reflection

08:09
Daily Habit completed locally

08:09
Sync begins

09:00
Employee works normally

10:30
Employee opens quest

12:00
Employee completes quest

12:00
Quest saved locally

12:01
Sync

14:00
Employee continues training

17:00
Employee checks progress

End of day
Serene calendar reflects activity
```

The important part is that **none of the normal interactions depend on waiting for the API**.

---

# 43. Data Flow Example — Daily Habit

```text
                MOBILE
                  │
                  ▼
        SQLite: daily_habit
                  │
                  ▼
             Employee
                  │
                  ▼
             Completion
                  │
                  ▼
          SQLite + sync_queue
                  │
                  │
              POST /sync
                  │
                  ▼
                LARAVEL
                  │
        ┌─────────┴─────────┐
        │                   │
    Validate             Process
        │                   │
        └─────────┬─────────┘
                  ▼
            Attribute Logic
                  │
                  ▼
               MySQL
                  │
                  ▼
             Sync Response
                  │
                  ▼
                SQLite
```

---

# 44. Data Flow Example — Training

```text
Admin assigns training
        ↓
Laravel
        ↓
MySQL
        ↓
Employee sync
        ↓
Training downloaded
        ↓
SQLite
        ↓
Employee studies offline
        ↓
Quiz answers stored locally
        ↓
Sync
        ↓
Laravel
        ↓
Grade / progression
        ↓
MySQL
        ↓
Result returned
        ↓
SQLite updated
```

---

# 45. Data Flow Example — Assessment

Assessment is different because AI processing is involved.

```text
Employee
 ↓
Questions
 ↓
Answers saved locally
 ↓
Assessment completed
 ↓
Submit to Laravel
 ↓
Laravel
 ↓
AI processing
 ↓
9 attribute assessment
 ↓
MySQL
 ↓
Result returned
 ↓
Mobile SQLite updated
 ↓
Employee profile complete
```

---

# 46. Admin Architecture

The Admin experience should remain separate from the employee mobile experience.

Recommended architecture:

```text
                  SERENE
                    │
          ┌─────────┴─────────┐
          │                   │
    Employee Mobile       Admin Web
     React Native        Web Application
          │                   │
          └─────────┬─────────┘
                    │
               Laravel API
                    │
                  MySQL
```

The employee application should not attempt to reproduce the entire Admin system.

---

# 47. Admin Responsibilities

The Admin system manages:

* Employees
* Positions
* Training
* Assessments
* Quests
* Attribute configuration
* Company settings
* Reports
* Employee progress

The original Admin structure covers these areas in detail.

---

# 48. Core Admin Domains

```text
Admin
│
├── Dashboard
│
├── Employees
│   ├── Employee Profile
│   ├── Assessment
│   ├── Training
│   ├── Quests
│   ├── Streak
│   └── Attribute History
│
├── Positions
│
├── Training Modules
│
├── Assessment
│
├── Quests
│
├── Attributes
│
├── Settings
│
└── Reports
```

---

# 49. Server-Side Business Logic

Laravel should own business rules that should not be trusted to the mobile client.

Examples:

```text
Can this employee access this training?
Can this employee complete this quest?
Was the quest completed on time?
How should this action affect attributes?
Did the employee pass training?
Should the employee receive another lesson?
Is the employee's assessment valid?
What data should this employee receive?
```

The mobile application should never be the final authority for these decisions.

---

# 50. Security Principle

Never assume that anything coming from the mobile application is trustworthy.

The mobile application is a client.

Therefore:

```text
Mobile says:
"I completed Quest #123."

Laravel:
"Let me verify that."
```

Laravel verifies:

* Authentication
* Employee identity
* Company membership
* Assignment
* Quest state
* Completion rules
* Attribute impact

Then MySQL records the official result.

---

# 51. Database Architecture

The central server database is:

# MySQL

Potential major domains:

```text
users
companies
admins
employees

positions

attributes
attribute_scores
attribute_history

assessments
assessment_questions
assessment_answers
assessment_results

training_modules
training_lessons
training_assignments
training_attempts
training_progress

habits
habit_questions
habit_answers
reflections

quests
quest_templates
quest_assignments
quest_completions

streaks
daily_activity

notifications
settings

sync-related metadata

audit_logs
```

The exact schema should be designed separately before implementation.

---

# 52. Important Data Relationship

One important relationship is:

```text
Position
    │
    ├── Required Trainings
    │
    └── Employees
             │
             └── Individual Training Overrides
```

This allows a position to define default training while still allowing Admins to assign special training to individual employees.

This follows the original system's position → training model.

---

# 53. Position Data for AI

Position should contain enough structured information for AI-generated content.

At minimum:

```text
Position
├── Name
├── Description
├── Responsibilities
├── Skills
├── Expected behaviors
└── Other structured context
```

This is important because Layer 1 daily habit content needs reliable information about what the employee actually does.

The original specification already identifies the need for a structured position description to provide reliable AI context.

---

# 54. What Does NOT Need to Be Native

Serene should avoid unnecessary native development.

The following should remain standard React Native/application functionality:

* Profile
* Training
* Quests
* Habit
* Reflection
* Character sheet
* Streak calendar
* Progress
* History
* Most UI interactions

Native/platform capabilities should primarily be used for:

```text
Notifications
Biometrics
SQLite/native database layer
```

This keeps the application maintainable.

---

# 55. Future-Proofing Strategy

The architecture should avoid making assumptions about one particular mobile database implementation.

Use:

```text
React Native UI
       ↓
Application services
       ↓
Repositories
       ↓
Local database abstraction
       ↓
SQLite
```

For example:

```text
HabitRepository

getToday()
saveAnswer()
completeHabit()
getHistory()
```

The UI should call:

```text
habitRepository.completeHabit()
```

rather than:

```text
sqlite.execute(...)
```

This means the database technology can evolve without forcing changes throughout the application.

---

# 56. Recommended Development Principle

Build the application around **domains**, not screens.

Good:

```text
Authentication
Assessment
Training
Habit
Quest
Attributes
Streak
Synchronization
```

Less ideal:

```text
HomeScreenService
TrainingScreenService
QuestScreenService
ProfileScreenService
```

Screens are UI.

Domains are the actual product.

---

# 57. Recommended Project Structure

A conceptual React Native structure:

```text
src/
│
├── app/
│   ├── navigation/
│   ├── providers/
│   └── configuration/
│
├── features/
│   ├── auth/
│   ├── profile/
│   ├── assessment/
│   ├── training/
│   ├── habit/
│   ├── quests/
│   ├── attributes/
│   ├── streak/
│   └── notifications/
│
├── data/
│   ├── repositories/
│   ├── local/
│   ├── remote/
│   └── sync/
│
├── services/
│   ├── authentication/
│   ├── synchronization/
│   └── notifications/
│
├── components/
│
└── utils/
```

The exact folder structure can change, but the separation of UI, domain logic, local data, remote data, and synchronization should remain.

---

# 58. Initial Development Phases

## Phase 1 — Mobile Foundation

```text
React Native
SQLite
Secure storage
Navigation
Authentication
Session persistence
Repository architecture
Sync engine
Local notifications
Biometric authentication
```

---

## Phase 2 — Employee Profile

```text
Login
 ↓
Profile detection
 ↓
Assessment
 ↓
Local answer storage
 ↓
Assessment submission
 ↓
AI evaluation
 ↓
9 attributes
```

---

## Phase 3 — Daily Habit

```text
Layer 1
Layer 2
Layer 3
Local completion
Sync
Attribute processing
```

---

## Phase 4 — Training

```text
Training assignments
Training download
Local lessons
Quiz
Progress
Server grading
```

---

## Phase 5 — Quest System

```text
Daily
Weekly
Monthly
One-off
Completion
Sync
Attribute impact
```

---

## Phase 6 — Character & Streak

```text
9 attributes
Attribute history
Streak calendar
Daily activity
Progress visualization
```

---

## Phase 7 — Admin System

```text
Dashboard
Employees
Positions
Training
Assessment
Quests
Attributes
Reports
Settings
```

---

# 59. MVP Priority

The first usable version of Serene should not require every reporting feature.

The core loop is:

```text
Employee
 ↓
Profile
 ↓
Assessment
 ↓
9 Attributes
 ↓
Training if needed
 ↓
Daily Habit
 ↓
Quests
 ↓
Reflection
 ↓
Progress
 ↓
9 Attributes evolve
 ↓
Repeat
```

If this loop works extremely well, the foundation of Serene is working.

---

# 60. Final Architecture

The final high-level architecture is:

```text
                         SERENE
                           │
          ┌────────────────┴────────────────┐
          │                                 │
   EMPLOYEE MOBILE                     ADMIN SYSTEM
    React Native                       Web Application
          │                                 │
          └────────────────┬────────────────┘
                           │
                     Laravel API
                           │
             ┌─────────────┼─────────────┐
             │             │             │
        Auth / API      Business       AI
                         Logic
             │             │             │
             └─────────────┼─────────────┘
                           │
                         MySQL
```

And on the mobile side:

```text
                    REACT NATIVE
                         │
                 Application Logic
                         │
                  Repository Layer
                         │
              ┌──────────┴──────────┐
              │                     │
        Local Data              Remote Data
              │                     │
            SQLite             Laravel API
              │                     │
              └──────────┬──────────┘
                         │
                    Sync Engine
                         │
                    Laravel API
```

---

# 61. The Core Rule of Serene

The architecture can ultimately be summarized in one sentence:

> **Serene should feel like a native mobile application first, while Laravel and MySQL quietly provide the authoritative backend and synchronization layer behind it.**

The employee should be able to open the app, see their day, read their training, answer their habits, complete their quests, write their reflection, and view their progress **without constantly thinking about whether the internet or API is available**.

The API should become mostly invisible to the employee.

That gives Serene a fast, resilient, scalable architecture while still allowing Laravel/MySQL to remain the central authority for company data, AI processing, employee scoring, administration, and reporting.
