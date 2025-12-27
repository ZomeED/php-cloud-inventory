# PHP Cloud Inventory Manager

A lightweight, professional inventory management system built with **PHP (OOP)** and **MySQL**. Designed with cloud-readiness and security best practices in mind.

## 🚀 Features
- **Full CRUD Logic:** Managed through PDO for high security.
- **Relational Database:** Optimized schema with audit timestamps.
- **Responsive UI:** Built with Bootstrap 5 for professional look.
- **Cloud-Ready:** Prepared for deployment in AWS environments (EC2 + RDS).

## 🛠️ Tech Stack
- **Backend:** PHP 8.x (Object-Oriented)
- **Database:** MySQL
- **Frontend:** HTML5, Bootstrap 5
- **Version Control:** Git Flow (Feature branching)

## ☁️ AWS Architecture Perspective
This project is designed to be deployed on an **AWS Infrastructure**:
- **Compute:** Scalable EC2 instance running Apache.
- **Database:** Amazon RDS (MySQL) for high availability.
- **Security:** Isolated within a Custom VPC with specific Security Groups for port 80 (HTTP) and 443 (HTTPS).

## 🔧 Installation
1. Clone the repository: `git clone ...`
2. Import `sql/schema.sql` into your MySQL server.
3. Configure your credentials in `config.php`.
4. Run on your local Apache server (XAMPP/LAMPP).
