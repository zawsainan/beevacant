# Job Platform

A full-featured job platform built with Laravel and Blade, allowing job seekers to apply for jobs and recruiters to post and manage job listings. This project is designed as a portfolio piece to demonstrate Laravel development with clean architecture, authentication, and real-world features.

## Features

### Recruiters

* Register and manage their recruiter/company profile
* Create, update, and delete job posts
* Tags are automatically generated when creating new jobs
* View only their own job listings

### Job Seekers

* Register and complete their resume (WorkProfile)
* Browse available jobs by tags
* Apply for jobs via a simple form
* Manage their job applications

### System

* Laravel Blade for all frontend views
* Laravel’s built-in authentication
* Role-based views and functionality
* Tailwind CSS for styling

## Models

* `User` – base user model
* `Company` – recruiter profile
* `Job` – job postings
* Industry – job industries
* `Tag` – skill or keyword tags
* `Application` – job applications submitted by job seekers
* Work`Profile` – job seeker resume

## Authentication & Roles

Laravel's built-in auth is used with a role field (e.g., `recruiter` or `job_seeker`) to manage permissions and dashboards.

## Project Structure

* `routes/web.php` – all routes are handled via web
* `resources/views/` – Blade templates for every page
* `app/Models/` – Eloquent models and relationships
* `app/Http/Controllers/` – handles logic and data rendering
* `database/migrations/` – all database schema definitions

## Setup Instructions

```bash
git clone https://github.com/zawsainan/beevacant.git
cd beevacant

# Install dependencies
composer install

# Copy and configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate

# Create symbolic link for storage
php artisan storage:link

# (Optional) seed sample data
php artisan db:seed

# Run the server
php artisan serve
```
