# Psychology Quiz API - Laravel MVP

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-F52525?logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Testing-Pest-EB6B3D?logo=phpunit&logoColor=white" alt="Pest">
  <img src="https://img.shields.io/badge/API-RESTful-222222?style=flat" alt="API">
  <img src="https://img.shields.io/badge/Status-MVP%20Complete-brightgreen" alt="Status">
</p>

> A clean, modern, and fully tested Laravel API for a psychology quiz platform with authentication, quiz logic, and result calculation.

**Developer:** Siamak Naghel  
**Project Status:** MVP Complete — Ready for Stripe, PDF Webhooks & Production Deployment

---

## 📌 Overview

This is a **Minimum Viable Product (MVP)** backend for a psychology brand launching diagnostic quizzes with a subscription model.

Built with **Laravel 12**, this API provides a solid foundation for user authentication, quiz delivery, scoring logic, and extensibility for future features like Stripe subscriptions and PDF generation.

All code is clean, well-structured, fully tested, and Git-tracked with meaningful commit history.

---

## ✅ Features Implemented

- ✅ **User Authentication**
  - Register, Login, Logout
  - Token-based auth via Laravel Sanctum
  - Password reset ready (route + controller structure)
- ✅ **Quiz Engine**
  - 7-question diagnostic quiz (easily extendable to 24+8 questions)
  - Dynamic scoring by personality traits (e.g., introvert/extrovert)
  - Answer submission & result calculation
  - Quiz history per user
- ✅ **Subscription Management (Stripe)**
  - Create subscription with 7-day trial
  - Cancel and resume subscription
  - Status tracking (trialing, active, canceled)
  - Integration via Laravel Cashier
- ✅ **Database & Seeding**
  - Clean migrations (users, quiz, subscriptions)
  - Seeder with structured JSON data (`questions.json`)
- ✅ **Testing**
  - Full Pest test suite
  - Integration tests for Auth, Quiz, and Subscription
  - Uses `RefreshDatabase` for isolated, reliable testing
- ✅ **Code Quality**
  - Git commit history with semantic messages
  - No sensitive files in repo (`.env`, `vendor/`)
  - Proper `.gitignore` and structure
- ✅ **Documentation**
  - This README
  - Clear API examples
  - Ready-to-use Postman collection for API testing

---

## 🔮 Upcoming Features (Planned)

- 🔹 **Stripe Webhook Integration** – Handle `invoice.paid`, `customer.subscription.updated`, `trial_will_end`
- 🔹 **PDF Webhook Endpoint** – Receive PDF generation status via `POST /webhook/pdf-status`
- 🔹 **Email Notifications** – On registration, subscription, and quiz results (Mailgun/SMTP)
- 🔹 **Password Reset Flow** – Token-based reset with API endpoints
- 🔹 **User Dashboard API** – Extend `/api/user` with subscription & quiz status
- 🔹 **GDPR Compliance** – Add data export/delete endpoints
- 🔹 **Staging & Production Deployment** – Laravel Forge / VPS with SSL & queue workers

---

## 🚀 Getting Started

### 1. Clone the Repository
```bash
git clone git@github.com:siamaknaghel/psychology-quiz-api-mvp.git
cd psychology-quiz-api-mvp
```
###2. Install Dependencies
```bash
composer install
```
###3. Configure Environment
```bash
cp .env.example .env
```
##Edit .env and set your database credentials:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=psychology_quiz_api_mvp
DB_USERNAME=root
DB_PASSWORD=
```
###4. Generate Application Key
```bash
php artisan key:generate
```
###5. Run Migrations & Seed Data
```bash
php artisan migrate
php artisan db:seed --class=QuizDataSeeder
```
###6. Start the Development Server
```bash
php artisan serve
```
👉 API is now available at: http://localhost:8000

🔐 API Endpoints
🔐 Authentication

| ENDPOINT | METHOD | DESCRIPTION |
|----------|--------|-------------|
| `/api/register` | `POST` | Register a new user |
| `/api/login` | `POST` | Login and receive Bearer token |
| `/api/logout` | `POST` | Logout (invalidate current token) |
| `/api/user` | `GET` | Get authenticated user |

🧠 Quiz API
| ENDPOINT | METHOD | DESCRIPTION |
|:--------:|:------:|:-----------:|
| `/api/quiz/questions` | `GET` | Get all quiz questions with options |
| `/api/quiz/submit` | `POST` | Submit answers and get scored result |
| `/api/quiz/history` | `GET` | Get user's quiz history |

## 🔐 Subscription API

| Endpoint | Method | Description |
|:--------:|:------:|:-----------:|
| `/api/subscription` | `POST` | Start a new subscription (with 7-day trial) using a payment method |
| `/api/subscription` | `GET` | Get current subscription status, trial end date, and plan |
| `/api/subscription` | `DELETE` | Cancel the subscription (user can continue until period ends) |
| `/api/subscription/resume` | `POST` | Resume a canceled subscription during the grace period |

> 💡 Uses **Laravel Cashier** + **Stripe**  
> 🧪 Test with `payment_method: pm_card_visa` (always succeeds)

🧪 Running Tests
```bash
php artisan test
```
#To run only quiz tests:
```bash
php artisan test --filter=QuizTest
```

#All tests are passing and cover:

- 🔹User registration & login
- 🔹Quiz question retrieval
- 🔹Answer submission & scoring
- 🔹History retrieval
- 🔹 Subscription management (trial, cancel, resume)
---
## 🧪 How to Use the Postman Collection

1. **Download & Install Postman**  
   👉 [https://www.postman.com/downloads/](https://www.postman.com/downloads/)

2. **Import the Collection**  
   - Open Postman
   - Click `File > Import`
   - Select: `postman/psychology-quiz-api-mvp.postman_collection.json`

3. **Set Environment Variables**  
   Create a new environment and define:
   - `base_url`: `http://localhost:8000` (or your deployment URL)
   - `user_token`: (copy after login)

4. **Test the API**  
   - Run `Auth → Register` → `Login`
   - Copy the token and set `user_token`
   - Try `Quiz` or `Subscription` endpoints

📌 The collection includes full examples for all API features.

---
## 📂 Project Structure Highlights

```bash
database/
├── migrations/           # Users, quiz, and subscription tables
├── seeders/
│   ├── data/questions.json  # Structured quiz data
│   └── QuizDataSeeder.php   # Seeder for quiz content
app/
├── Http/Controllers/Api/
│   ├── Auth/               # Register, Login, Logout
│   ├── QuizController.php  # Quiz logic
│   └── SubscriptionController.php  # Stripe subscription management
tests/
└── Feature/                # Pest feature tests (Auth, Quiz, Subscription)
postman/
└── psychology-quiz-api-mvp.postman_collection.json  # Ready-to-use API testing collection
```

## 🔮 Planned Features & Roadmap

This project is currently in **MVP (Minimum Viable Product)** phase. The core API is complete and tested. Below is the planned roadmap for upcoming features:

### ✅ Completed (MVP)
- [x] User Authentication (Register, Login, Logout)
- [x] Quiz API (Questions, Submission, Result Calculation)
- [x] Quiz History & User Profile
- [x] Subscription API (Stripe integration with trial, cancel, resume)
- [x] Pest Test Suite (Auth, Quiz, Subscription)
- [x] Git Version Control with Semantic Commits
- [x] Postman Collection for API Testing
- [x] Basic Documentation

### 🔜 Upcoming Features (Next 4 Weeks)

| Feature | Description | Timeline |
|--------|-------------|----------|
| **Stripe Webhook Setup** | Secure endpoint for `invoice.paid`, `customer.subscription.updated`, and `trial_will_end` events | Week 1-2 |
| **PDF Webhook Endpoint** | Add `POST /webhook/pdf-status` to receive PDF generation status and trigger notifications | Week 2 |
| **Email Notifications** | Send emails on: user registration, subscription success, and quiz results (via Mailgun/SMTP) | Week 2-3 |
| **Password Reset** | Add `/forgot-password` and `/reset-password` endpoints with token-based flow | Week 3 |
| **User Dashboard API** | Extend `/api/user` to include subscription status, quiz history, and next steps | Week 3 |
| **GDPR Compliance** | Add data export/delete endpoints and logging compliance | Week 4 |
| **Staging & Production Deployment** | Deploy to Laravel Forge / VPS with SSL, queue workers, and monitoring | Week 4 |


### 🛠️ Technology Stack (Planned)
- `laravel/cashier` – Stripe integration
- `spatie/laravel-webhook-server` – Secure webhook handling
- `laravel/mail` – Email notifications
- `laravel/fortify` or custom auth – Password reset
- GitHub Actions – CI/CD (optional)

---

## 📬 Handover Notes for Client

- This MVP is **fully functional, tested, and ready for the next phase**.
- All code is clean, well-structured, and follows Laravel best practices.
- I am available for the next 2+ months to continue working on this project.

📬 Contact
- Siamak Naghel
- Laravel & Full-Stack Developer
- 📧 30amak89@gmail.com
