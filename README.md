# 🏥 Hospital Appointment Scheduler

> A robust, full-stack Hospital Management System built with **PHP (MVC Architecture)**, **MySQL**, and **AJAX**.

---

## 📖 About The Project
This is a comprehensive web application designed to streamline the interaction between doctors, patients, and hospital administrators. It solves the problem of manual booking by offering real-time slot generation, doctor availability management, and a secure approval workflow for new medical staff.

### 🌟 Key Features

#### 👨‍⚕️ For Doctors
* **Smart Scheduling:** Set weekly availability with "From Date" and "To Date".
* **Dashboard:** View upcoming appointments and patient details.
* **Profile Management:** Update specialization and contact info.

#### 🏥 For Patients
* **Real-Time Booking:** Dynamic time-slot calculation prevents double-booking.
* **AJAX Interface:** Browse doctors and available dates without page reloads.
* **User Panel:** View booking history and status updates.

#### 🛡️ For Admins
* **Approval Workflow:** Review and approve/reject new doctor registrations.
* **CMS Dashboard:** Manage all Users (Doctors, Patients, Admins).
* **Statistics:** View system-wide metrics at a glance.

---

## 🛠️ Tech Stack

* **Frontend:** HTML5, CSS3, JavaScript (Vanilla + AJAX)
* **Backend:** PHP 8.0+ (Object-Oriented, MVC Pattern)
* **Database:** MySQL (Relational Schema)
* **Security:** Password Hashing (`password_hash`), Session Management, Prepared Statements (PDO).

---

## 🚀 Installation Guide

Follow these steps to get the project running on your local machine.

### Prerequisites
* XAMPP / WAMP / MAMP (or any PHP/MySQL environment)
* Web Browser

### Steps
1.  **Clone/Download** this repository to your `htdocs` folder.
2.  **Start Apache & MySQL** in your XAMPP control panel.
3.  **Setup Database:**
    * Open `http://localhost/phpmyadmin`
    * Create a new database named `techspace` (or your preferred name).
    * Click **Import** tab.
    * Choose the file `scheduler_db.sql` provided in this folder.
    * Click **Go**.
4.  **Configure Connection:**
    * Open `config/Database.php`.
    * Ensure `$db_name` matches your database name and `$password` is correct (usually empty for XAMPP).
5.  **Run:**
    * Open your browser and visit: `http://localhost/techspace/`

---

## 🔐 Demo Credentials

Use these accounts to test the different roles in the system:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@techspace.com` | `password` |
| **Doctor** | `adnan@techspace.com` | `password` |
| **Patient** | `rafid@gmail.com` | `password` |

> **Note:** You can also register a new account. If you register as a **Doctor**, an Admin must approve you before you can log in.

---

## 📂 Project Structure (MVC)

```text
techspace/
├── assets/             # CSS and Images
├── config/             # Database Connection Class
├── controllers/        # Logic (Auth, Booking, Admin, Profile)
├── helpers/            # Utilities (TimeSlotGenerator)
├── models/             # Database Interactions (User, Appointment)
├── views/              # HTML Frontend Files
├── index.php           # Main Router
└── scheduler_db.sql    # Database Import File