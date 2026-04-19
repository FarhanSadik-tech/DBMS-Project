# Smart Hospital Management System (SHM System)
A lightweight, web-based management solution designed to digitize hospital administration, streamline patient records, and optimize resource allocation.

## Overview
The Smart Hospital Management System is built to replace traditional paper-based record-keeping with a centralized digital platform. It focuses on maintaining data integrity and improving operational speed in a healthcare environment.

## Key Features
◈ Patient Management: Register new patients with details like name, phone, and gender.

◈ Doctor Assignment: Link patients to specialized doctors for better consultation tracking.

◈ Real-time Bed Tracking: Monitor bed occupancy (Available/Occupied) to ensure efficient admission.

◈ Instant Search: Fast retrieval of patient data using SQL-based pattern matching.

◈ Dynamic Dashboard: High-level overview of hospital resources (Total Patients, Doctors, and Beds).

## Tech Stack
◈ Backend: PHP 8.x

◈ Database: MySQL (Relational Database)

◈ Frontend: HTML5, CSS3, JavaScript

◈ Server Environment: XAMPP (Apache)

◈ Version Control: Git

### 📂 Project Structure

```text
├── 📁 css/                # Styling files (sidebar, tables, dashboard)
├── 📁 db/                 # Database configuration
│   ├── db_connect.php     # MySQL connection logic
│   └── database.sql       # SQL export file for migration
├── 📁 includes/           # Reusable UI components
│   ├── header.php         # Navbar and metadata
│   └── sidebar.php        # Main navigation menu
├── 📄 index.php           # Login and Authentication page
├── 📄 dashboard.php       # Main Admin Overview with stats
├── 📄 patients.php        # Patient registration & records
├── 📄 doctors.php         # Doctor directory
├── 📄 beds.php            # Real-time bed allocation
└── 📄 README.md           # Project documentation| **`/css`** | Contains all `.css` files for the sidebar, dashboard cards, and responsive tables.
|
| **`/db`** | Houses the `db_connect.php` for MySQLi connection and the `.sql` schema. |
| **`/includes`** | Stores modular PHP files like the sidebar to avoid code repetition. |
| **`patients.php`** | The core module handling Patient CRUD operations and Search logic. |
| **`dashboard.php`** | The landing page after login, displaying total counts of resources. |





