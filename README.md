🏥 Laravel Clinic Management System 📘 Overview

A comprehensive Clinic Management System built with Laravel 8, designed to streamline healthcare operations. It provides a powerful and secure platform for managing patients, appointments, doctors, payments, and administrative tasks efficiently. The system leverages modern web technologies to ensure scalability, security, and ease of use.

✨ Features

🧑‍⚕️ Patient Management: Complete profiles with medical history and emergency contacts.

📅 Appointment Scheduling: Multi-step wizard for booking appointments with time slots.

👨‍⚕️ Doctor Management: Manage doctor profiles, specializations, and availability.

💳 Payment Integration: Secure Stripe payment gateway for fees and services.

🧑‍💼 Admin Dashboard: Role-based admin panel using AdminLTE for managing users and roles.

🔐 User Authentication: Role-based access for Patients, Doctors, Admins, and Receptionists.

🗂️ Task Management: Assign and track clinic-related tasks.

📧 Email Verification: Secure user registration with verification flow.

📱 Responsive Design: Fully mobile-friendly layout using Bootstrap and AdminLTE.

Category	Technologies
Framework	Laravel 8
Frontend	Blade Templates, Bootstrap (AdminLTE), JavaScript
Database	MySQL
Payment	Stripe API
Authentication	Laravel Sanctum
UI Library	AdminLTE 3
Build Tool	Laravel Mix (Webpack)
Testing	PHPUnit
Other Tools	Guzzle, CORS Support
⚙️ Installation 🧩 Prerequisites

PHP ^7.3 or ^8.0

Composer

Node.js & npm

MySQL

Git

🚀 Steps to Setup

Clone the repository
git clone https://github.com/your-username/laravel-clinic-management.git cd laravel-clinic-management

Install dependencies
composer install npm install

Configure environment
cp .env.example .env php artisan key:generate

📝 Update your .env file with database and Stripe credentials: DB_DATABASE=clinic_db DB_USERNAME=your_username DB_PASSWORD=your_password

STRIPE_KEY=your_stripe_publishable_key STRIPE_SECRET=your_stripe_secret_key

Run migrations and seeders
php artisan migrate --seed

Build assets
npm run dev # or npm run prod

Start development server
php artisan serve

➡ App will be available at http://localhost:8000

👥 User Roles and Access

Role	Permissions
Admin	Full control of users, roles, and settings
Doctor	Manage appointments and patient records
Receptionist	Schedule appointments and assist patients
Patient	Book appointments and view medical records
Nurse	Assist doctors and manage patient care
🧱 Project Structure app/ # Controllers, Models database/ # Migrations, Seeders resources/views/ # Blade Templates routes/ # Web & API Routes public/ # CSS, JS, Images config/ # Configuration Files

💻 Common Commands php artisan migrate php artisan migrate:rollback php artisan db:seed php artisan cache:clear php artisan config:clear npm run dev npm run prod
