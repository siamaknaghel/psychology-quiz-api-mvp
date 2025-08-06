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
- ✅ **Database & Seeding**
  - Clean migrations
  - Seeder with structured JSON data (`questions.json`)
- ✅ **Testing**
  - Full Pest test suite
  - Integration tests for Auth & Quiz
  - Uses `RefreshDatabase` for isolated, reliable testing
- ✅ **Code Quality**
  - Git commit history with semantic messages
  - No sensitive files in repo (`.env`, `vendor/`)
  - Proper `.gitignore` and structure
- ✅ **Documentation**
  - This README
  - Clear API examples

---

## 🔮 Upcoming Features (Planned)

- 🔹 Stripe Subscription Integration (1 tier + trial)
- 🔹 PDF Generation Webhook Endpoint
- 🔹 Email Notifications (Welcome, Subscription, Results)
- 🔹 Password Reset Flow
- 🔹 Staging & Production Deployment
- 🔹 GDPR Compliance (Data export/delete)

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
---
📂 Project Structure Highlights
```bash
database/
├── migrations/           # Users, quiz tables
├── seeders/
│   ├── data/questions.json  # Structured quiz data
│   └── QuizDataSeeder.php   # Seeder for quiz content
app/
├── Http/Controllers/Api/
│   ├── Auth/               # Register, Login, Logout
│   └── QuizController.php  # Quiz logic
tests/
└── Feature/                # Pest feature tests
```

📬 Contact
Siamak Naghel
Laravel & Full-Stack Developer
📧 30amak89@gmail.com
