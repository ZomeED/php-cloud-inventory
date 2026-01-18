# 📦 PHP Cloud Inventory Manager

[![Deployment Status](https://img.shields.io/badge/Deployment-Live-success?style=for-the-badge&logo=amazon-aws)](https://dawproyects.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)](https://www.php.net/)

> **🔴 LIVE DEMO:** Access the deployed application at [https://dawproyects.com/](https://dawproyects.com/)

A professional, lightweight inventory management system developed as part of my **Web Application Development** training. This project demonstrates a full **CRUD** (Create, Read, Update, Delete) cycle using secure coding practices and is now **deployed in a production AWS environment**.

## 🚀 Key Features
- **Secure CRUD Logic:** Implemented using PHP Data Objects (PDO) to prevent SQL Injection.
- **Relational Database:** Optimized MySQL schema including audit timestamps (`created_at`, `updated_at`).
- **Professional UI:** Responsive dashboard built with Bootstrap 5, featuring real-time user feedback (UX).
- **Git Flow:** Developed using a systematic feature-branching strategy to ensure code stability.

## 📸 Project Preview

### Main Dashboard
![Dashboard Preview](screenshots/dashboard-enhancement.png)

## 🎥 Video Demo
Watch the CRUD functionality and real-time statistics in action:

https://github.com/user-attachments/assets/775854fb-dc66-4ce8-ae61-bbc2cebd5ea1

## 🛠️ Tech Stack
- **Backend:** PHP 8.x (Object-Oriented Programming).
- **Database:** MySQL / MariaDB.
- **Frontend:** HTML5, Bootstrap 5, JavaScript (Confirmations).
- **Infrastructure:** AWS EC2, Linux (Apache).

---

## ☁️ Cloud Infrastructure & Deployment
This project has been migrated from a local environment to a live production server.

### ⚙️ Implementation Details
I successfully deployed this application using the following DevOps practices:

1.  **AWS EC2 (Compute):** - Provisioned a Linux EC2 instance on Amazon Web Services.
    - Manually configured the **LAMP Stack** (Linux, Apache, MySQL, PHP) for production.
2.  **Remote Management:**
    - Server administration and file deployment handled via **Bitvise SSH Client**.
    - Utilized SFTP for secure file transfer and SSH terminal for server configuration.
3.  **Domain & Networking:**
    - Acquired and configured the domain **[dawproyects.com](https://dawproyects.com/)**.
    - Configured DNS records to point to the AWS instance's public IP.

---

## 💻 Local Development & Environment Setup

This project is developed and hosted locally using **LAMPP** on **Linux Mint**. To ensure the application runs correctly, follow these steps:

1. **Start the XAMPP/LAMPP Manager:**
   Run the following commands in your terminal to launch the service manager:
   ```bash
   cd /opt/lampp
   sudo ./manager-linux-x64.run
   ```

2. **Activate Services: Inside the graphical manager, navigate to the "Manage Servers" tab and start:**

    - MySQL Database: Handles all relational data storage.

    - Apache Web Server: Serves the PHP application files.

3. **Database Management: You can access and verify the table structure through phpMyAdmin at http://localhost/phpmyadmin.**

---

## 🔮 Future Scalability Strategy (Roadmap)
While the current version runs on a single EC2 instance, the architecture is designed to scale using advanced AWS services:

1. **Database Migration (High Availability)**
   - **Concept:** Transition from local MySQL on EC2 to **Amazon RDS**.
   - **Benefit:** Automated backups, multi-AZ deployment for disaster recovery, and easy scaling.

2. **High Availability & Load Balancing**
   - **Auto Scaling:** Implement an **Auto Scaling Group** to launch instances based on CPU traffic.
   - **Load Balancing:** Use an **Application Load Balancer (ALB)** to distribute incoming traffic, ensuring 24/7 availability.

3. **Security**
   - **VPC Configuration:** Isolate the database in a private subnet while keeping the web server in a public subnet.

---

## 🔧 Setup & Installation (Local)

To set up the project locally for development or testing:

1.  **Clone the repository:**
    
    > git clone [https://github.com/ZomeED/php-cloud-inventory.git](https://github.com/ZomeED/php-cloud-inventory.git)
    

2.  **Database Setup:**
    Import the `/sql/schema.sql` file into your MySQL manager (e.g., phpMyAdmin).

3.  **Configuration:**
    Set your database credentials in `config.php`.
    > **Note:** This file is excluded via `.gitignore` for security reasons. You must create it manually based on `config.sample.php` (if available) or your environment settings.

4.  **Deploy:**
    Move the project folder to your `htdocs` (XAMPP) or `/var/www/html/` (Linux Apache) directory and access it via your browser at `http://localhost/php-cloud-inventory`.

---

<div align="center">

**Developer:** Jose Antonio Zomeño Pardo - Web Development Student
<br>
**Contact:** joseantoniozome01@gmail.com
<br>
[🔴 Live Project](https://dawproyects.com/) • [🐱 GitHub Profile & CV](https://github.com/ZomeED)

</div>
