# 🧑‍💼 Simple HR System — Laravel 12

A simple Human Resources system built with Laravel 12. Designed for small companies or as a practical backend portfolio project.

## 🚀 Features

-   🔐 Authentication with Role-based Access (Admin & Employee)
-   👥 Employee Management (photo, position, salary, status)
-   📆 Leave Request Submission (Pending → Approved/Rejected)
-   ✅ Leave Approval Workflow (by Admin/HR)
-   📤 Export to Excel & PDF
-   📧 Email Notifications for Leave Approval/Rejection
-   🖼 Employee Photo Upload

## 🧩 Tech Stack & Packages

-   **Laravel 12**
-   **Laravel Breeze** — basic authentication scaffolding
-   **Spatie Laravel Permission** — role & permission management
-   **Maatwebsite Excel** — export to `.xlsx`
-   **Barryvdh DomPDF** — PDF generation
-   **Intervention Image** — photo upload & optimization
-   **Laravel Notifications** — for sending emails

## 🗂️ Core Entities

### Users

-   Role-based access (`admin`, `employee`)
-   Linked to employee profile

### Employees

-   Full name, photo, position, salary, status
-   Belongs to a `User`

### Leave Requests

-   Start/end date, reason, status
-   Can be approved/rejected by Admin
-   Email notifications sent automatically

## 📤 Data Export

-   Export employee list or leave data to Excel (via Laravel Excel)
-   Generate printable reports as PDF (via DomPDF)

## 📧 Email Notifications

-   Sent when a leave request is approved or rejected
-   Customizable via Laravel Notification system

## ✅ Permissions

-   `admin`: full access to all employees and leave approvals
-   `employee`: can view their profile, submit leave requests

## 📌 Use Case

This project demonstrates practical backend skills including:

-   Role-based authentication
-   Workflow logic for approvals
-   File uploads & image handling
-   Excel and PDF export
-   Notification system integration
